<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Increment\Marketplace\Models\Merchant;
use Increment\Marketplace\Models\Checkout;
use Increment\Marketplace\Models\CheckoutItem;
use Increment\Marketplace\Models\Product;
use Increment\Marketplace\Models\Pricing;
use Increment\Payment\Models\StripeWebhook;
use Increment\Payment\Models\PaypalTransaction;
use App\Client;
use App\Template;
use App\Employee;
use App\CustomObject;
use App\Attribute;
use Carbon\Carbon;
class CheckoutController extends APIController
{
    protected $subTotal = 0;
    protected $total = 0;
    protected $tax = 0;

    public $paymentMethodClass = 'Increment\Payment\Http\PaymentMethodController';
    public $paypalTransactionClass = 'Increment\Payment\Http\PaypalTransactionController';
    public $shippingAddressClass = 'Increment\Marketplace\Http\ShippingAddressController';
    public $merchantClass = 'Increment\Marketplace\Http\MerchantController';
    public $productClass = 'Increment\Marketplace\Http\ProductController';
    public $templateClass = 'App\Http\Controllers\TemplateController';
    public $objectClass = 'App\Http\Controllers\ObjectController';

    function __construct(){
    	$this->model = new Checkout();

      $this->notRequired = array(
        'coupon_id',
        'order_number',
        'payment_type',
        'payment_payload',
        'payment_payload_value'
      );
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      $cards = app($this->paymentMethodClass)->getPaymentMethod('account_id', $data['account_id']);
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $price = $this->getPrice($result[$i], $data['account_id']);
          $this->response['data'][$i]['merchant'] = ($result[$i]['merchant_id'] != null && $result[$i]['merchant_id'] != '' && $result[$i]['merchant_id'] > 0) ? app($this->merchantClass)->getMerchant($result[$i]['merchant_id']) : null;
          $this->response['data'][$i]['account_details'] = $this->retrieveAccountDetails($data['account_id']); 
          $this->response['data'][$i]['items'] = $this->getItems($result[$i]['id'], $price, $data['account_id']);
          $this->response['data'][$i]['sub_total'] = $this->subTotal;
          $this->response['data'][$i]['tax'] = $this->tax;
          $this->response['data'][$i]['total'] = $this->subTotal - $this->tax;
          $this->response['data'][$i]['shipping_address'] = app($this->shippingAddressClass)->getShippingAddress($result[$i]['id']);
          if($result[$i]['payment_type'] == 'authorized' && $result[$i]['payment_payload'] == 'credit_card'){
            $this->response['data'][$i]['method'] = app($this->paymentMethodClass)->getPaymentMethod('id', $result[$i]['payment_payload_value']);
          }else{
            $this->response['data'][$i]['method'] = null;
          }
          $i++;
        }
      }
      
      $this->response['method'] = $cards;
      return $this->response();
    }

    public function retrieveOrderItems(Request $request){
      $data = $request->all();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['items'] = $this->getOrderItems($result[$i]['id']);
          $i++;
        }
      }
      
      return $this->response();
    }

    public function retrieveOrders(Request $request){
      $data = $request->all();
      $this->retrieveDB($data);
      
      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['order_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $result[$i]['created_at'])->copy()->tz('Asia/Manila')->format('F j, Y');
          $this->response['data'][$i]['account'] = $this->retrieveAccountDetails($result[$i]['account_id']);
          $this->response['data'][$i]['merchant'] = ($result[$i]['merchant_id'] != null && $result[$i]['merchant_id'] != '' && $result[$i]['merchant_id'] > 0) ? $this->retrieveAccountDetails($result[$i]['merchant_id']) : null;
          $i++;
        }
      }
      return $this->response();
    }

    public function retrieveSummary(Request $request){
      $data = $request->all();
      $this->summary($data);
      return $this->response();
    }

    public function retrieveSummaryReceipt($data){
      $this->summary($data);
      return $this->response['data'];
    }

    public function summary($data){
      $this->model = new Checkout();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      $cards = app($this->paymentMethodClass)->getPaymentMethod('account_id', $data['account_id']);
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $price = $this->getPrice($result[$i]['id'], $data['account_id']);
          $coupon = ($result[$i]['coupon_id'] != null) ? $this->getCoupon($result[$i]['coupon_id']) : null;
          $this->response['data'][$i]['templates'] = $this->getItemBy($result[$i]['id'], 'template', null);
          $this->response['data'][$i]['products'] = $this->getItemBy($result[$i]['id'], 'product', null);
          $this->response['data'][$i]['employees'] = $this->getItemBy($result[$i]['id'], 'employee', $price);
          $this->response['data'][$i]['coupon'] = $coupon;
          if(($result[$i]['payment_type'] == 'authorized' || $result[$i]['payment_type'] == 'express') && $result[$i]['payment_payload'] == 'credit_card'){
            $this->response['data'][$i]['method'] = app($this->paymentMethodClass)->getPaymentMethod('id', $result[$i]['payment_payload_value']);
          }else if($result[$i]['payment_type'] == 'express' && $result[$i]['payment_payload'] == 'paypal'){
            $this->response['data'][$i]['method'] = app($this->paypalTransactionClass)->getPaypalTransaction($result[$i]['payment_payload_value']);
          }else{
            $this->response['data'][$i]['method'] = null;
          }
          $i++;
        }
      }
    }

    public function getPrice($checkout, $accountId){
      $total = $this->getItemSize($checkout['id'], 'employee');
      $price = 0;
      if(sizeof($checkout) > 0){
        $result = null;
        if($checkout['merchant_id'] != null && $checkout['merchant_id'] != '' && $checkout['merchant_id'] > 0){
          $product = Product::where('title', '=', 'id_printing')->orderBy('created_at', 'asc')->first();
          if($product){
            $productId = $product->id;
            $result = Pricing::where('account_id', '=', $productId)->Where('minimum', '<=', $total)->where('maximum', '>=', $total)->first(); 
          }
        }
        return ($result) ? $result->price : 0;
      }else{
        return 0;
      }
    }

    public function getItemSize($checkoutId, $payload){
      return CheckoutItem::where('checkout_id', '=', $checkoutId)->where('payload', '=', $payload)->count();
    }

    public function getItemBy($checkoutId, $payload, $price = null){
      $result = CheckoutItem::where('checkout_id', '=', $checkoutId)->where('payload', '=', $payload)->get();
      $this->subTotal = 0;
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $payload = $result[$i]['payload'];
          $payloadValue = $result[$i]['payload_value'];
          if($payload == 'template'){
            $result[$i]['template'] = app($this->templateClass)->getTemplateDetails($payloadValue);
            $result[$i]['objects'] = app($this->objectClass)->getObjects($payloadValue);
            $this->subTotal += $result[$i]['price'];
          }else if($payload == 'employee'){
            $result[$i]['employee'] = $this->getEmployee($payloadValue);
            if($result[$i]['employee']){
              $result[$i]['employee']['price'] = $price;
              $this->subTotal += $price;
            }
          }else if($payload == 'product'){
            $result[$i]['product'] = app($this->productClass)->retrieveProductById($payloadValue, null);
          }
          $i++;
        }
        return $result;
      }else{
        return null;
      }
    }

    public function getItems($checkoutId, $price, $accountId){
      $result = CheckoutItem::where('checkout_id', '=', $checkoutId)->get();
      $this->subTotal = 0;
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $payload = $result[$i]['payload'];
          $payloadValue = $result[$i]['payload_value'];
          $result[$i]['active_templates'] = app('App\Http\Controllers\ActiveTemplateController')->retrieveByAccountId($accountId);
          if($payload == 'template'){
            $result[$i]['template'] = app($this->templateClass)->getTemplateDetails($payloadValue);
            $result[$i]['objects'] = app($this->objectClass)->getObjects($payloadValue);
            $this->subTotal += $result[$i]['price'];
          }else if($payload == 'employee'){
            $result[$i]['employee'] = $this->getEmployee($payloadValue);
            if($result[$i]['employee']){
              $result[$i]['employee']['price'] = $price;
              $this->subTotal += $price;
            }
          }else if($payload == 'product'){
            $this->subTotal += floatval($result[$i]['price']) * floatval($result[$i]['qty']);
            $result[$i]['product'] = app($this->productClass)->retrieveProductById($payloadValue, $accountId);
            
          }else if($payload == 'profile'){
            $result[$i]['profile'] =  app('App\Http\Controllers\ProfileController')->retrieveById($payloadValue);
            $result[$i]['profile']['price'] = $price;
            $this->subTotal += $price;
          }
          $i++;
        }
        return $result;
      }else{
        return null;
      }
    }

    public function getOrderItems($checkoutId){
      $result = CheckoutItem::where('checkout_id', '=', $checkoutId)->get();
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $payload = $result[$i]['payload'];
          $payloadValue = $result[$i]['payload_value'];
          $result[$i]['templates'] = app('App\Http\Controllers\CheckoutTemplateController')->retrieveById('checkout_id', $checkoutId);
          $result[$i]['active'] = false;
          if($payload == 'employee'){
            $result[$i]['profile'] = null;
            $result[$i]['employee'] = $this->getEmployeeFromOrders($payloadValue);
            $result[$i]['template'] = null;
          }else if($payload == 'template'){
            $result[$i]['employee'] = null;
            $result[$i]['profile'] = null;
            $result[$i]['template'] = array(
              'details' => app($this->templateClass)->getTemplateDetails($payloadValue),
              'objects' => app($this->objectClass)->getObjects($payloadValue)
            );
          }else if($payload == 'profile'){
            $result[$i]['employee'] = null;
            $result[$i]['template'] = null;
            $result[$i]['profile'] =  app('App\Http\Controllers\ProfileController')->retrieveById($payloadValue);
          }
          $i++;
        }
        return $result;
      }else{
        return null;
      }
    }

    public function getEmployeeFromOrders($payloadValue){
      $result = Employee::where('id', '=', $payloadValue)->get();
      if(sizeof($result) > 0){
        $id = $result[0]['id'];
        // $result[0]['front_objects'] = $this->getObjectsCustom($result[0]['front_template'], $id);
        // $result[0]['back_objects'] = $this->getObjectsCustom($result[0]['back_template'], $id);
        // $result[0]['front_template_details'] = app($this->templateClass)->getTemplateDetails($result[0]['front_template']);
        // $result[0]['back_template_details'] = app($this->templateClass)->getTemplateDetails($result[0]['back_template']);
        // $result[0]['total_comments'] = $this->getComments($id);
        return $result[0];
      }else{
        return null;
      }
    }

    public function updateStatus(Request $request){
      $data = $request->all();
      $this->model = new Checkout();
      $this->updateDB($data);
      return $this->response();
    }


    public function updateRemoveMerchant(Request $request){
      $data = $request->all();
      $checkoutId = $data['id'];
      $result = Checkout::where('id', '=', $checkoutId)->update(array(
        'merchant_id' => null,
        'updated_at' => Carbon::now()
      ));

      if($result){
        return response()->json(array(
          'data' => true,
          'error' => null,
          'timestamp' => Carbon::now()
        ));
      }else{
        return response()->json(array(
          'data' => false,
          'error' => null,
          'timestamp' => Carbon::now()
        ));
      }
    }

    public function updateMerchant(Request $request){
      $data = $request->all();
      $this->model = new Checkout();
      $this->updateDB($data);
      return $this->response();
    }

    public function update(Request $request){
      $data = $request->all();
      $accountId = $data['account_id'];
      $id = $data['id'];
      $tax = $data['tax'];
      $subTotal = $data['sub_total'];
      $total = $data['total'];
      $paymentType = $data['payment_type'];
      $couponId = $data['coupon_id'];
      $discount = $data['discount'];
      $paymentPayload = $data['payment_payload'];
      $paymentPayloadValue = $data['payment_payload_value'];
      $email = $data['email'];
      $title = 'Charge for order number'.$data['order_number'];

      $updateData = array(
        'id'  => $id,
        'tax' => $tax,
        'sub_total' => $subTotal,
        'total' => $total,
        'discount'  => $discount,
        'payment_type' => $paymentType,
        'payment_payload' => $paymentPayload,
        'status'  => 'completed',
        'updated_at'  => Carbon::now()
      );

      if($couponId != '' && $couponId != null){
        $updateData['coupon_id'] = $couponId;
      }

      if(($paymentType == 'authorized' || $paymentType == 'express') && $paymentPayload == 'credit_card'){
        $paymentMethod = app($this->paymentMethodClass)->getPaymentMethod('id', $paymentPayloadValue);
        $updateData['payment_payload_value'] = $paymentPayloadValue;
        $charge = null;
        if($paymentMethod->payload == 'credit_card'){
          $stripe = new StripeWebhook();
          $charge = $stripe->chargeCustomer($email, $paymentMethod->stripe->source, $paymentMethod->stripe->customer, $total, $title);
        }

        if($charge && $charge->status == 'succeeded'){
          $this->model = new Checkout();
          $this->updateDB($updateData);
          $this->managePurchasedTemplate($updateData['id']);
          // send receipt
          $dataReceiptCondition = array(
            'condition' => array(
              array(
                'value' => $id,
                'column'  => 'id',
                'clause' => '='
              )
            ),
              'account_id' => $accountId
          );
          $dataReceipt = $this->retrieveSummaryReceipt($dataReceiptCondition);
          app('App\Http\Controllers\EmailController')->receipt($accountId, $dataReceipt);
          $this->response['data'] = true;
          return $this->response();
        }else{
          return response()->json(array(
            'data'  => false,
            'error' => 'Unable to charge',
            'timestamps'  => Carbon::now()
          ));
        }
      }else if($paymentType == 'express' && $paymentPayload == 'paypal'){
        $payerInfo = $paymentPayloadValue['payer']['payer_info'];
        $paypal = new PaypalTransaction();
        $paypal->account_id = $accountId;
        $paypal->paypal = $paymentPayloadValue['id'];
        $paypal->cart = $paymentPayloadValue['cart'];
        $paypal->email = $payerInfo['email'];
        $paypal->first_name = $payerInfo['first_name'];
        $paypal->middle_name = $payerInfo['middle_name'];
        $paypal->last_name = $payerInfo['last_name'];
        $paypal->payer = $payerInfo['payer_id'];
        $paypal->total = $total;
        $paypal->currency = 'PHP';
        $paypal->save();

        if($paypal->id){
          $updateData['payment_payload_value'] = $paypal->id;
          $this->model = new Checkout();
          $this->updateDB($updateData);
          $this->managePurchasedTemplate($updateData['id']);
          // send receipt
          $dataReceiptCondition = array(
            'condition' => array(
              array(
                'value' => $id,
                'column'  => 'id',
                'clause' => '='
              )
            ),
            'account_id' => $accountId
          );
          $dataReceipt = $this->retrieveSummaryReceipt($dataReceiptCondition);
          app('App\Http\Controllers\EmailController')->receipt($accountId, $dataReceipt);
          $this->response['data'] = true;
          return $this->response();
        }else{
          return response()->json(array(
            'data'  => false,
            'error' => 'Unable to charge',
            'timestamps'  => Carbon::now()
          ));
        }
      }else{
          return response()->json(array(
            'data'  => false,
            'error' => 'Unable to charge',
            'timestamps'  => Carbon::now()
          ));
      }
    }

    public function managePurchasedTemplate($checkoutId){
      $templates = CheckoutItem::where('checkout_id', '=', $checkoutId)->where('payload', 'template')->get();
      if(sizeof($templates) > 0){
        $i = 0;
        foreach ($templates as $key) {
          $template = app($this->templateClass)->getTemplateDetails($templates[$i]['payload_value']);
          if($template != null){
            $pTemplate = new Template();
            $pTemplate->account_id  = $templates[$i]['account_id'];
            $pTemplate->title       = $template['title'];
            $pTemplate->settings    = $template['settings'];
            $pTemplate->height      = $template['height'];
            $pTemplate->width       = $template['width'];
            $pTemplate->status      = 'purchased';
            $pTemplate->purchased   = $template['id'];
            $pTemplate->categories  = $template['categories'];
            $pTemplate->price       = $template['price'];
            $pTemplate->created_at  = Carbon::now();
            $pTemplate->save();
            if($pTemplate->id){
              $this->managePurchasedObjects($templates[$i]['payload_value'], $pTemplate->id);
            }
          }
          $i++;
        }
      }
    }

    public function managePurchasedObjects($oldTemplateId, $newTemplateId){
       $objects = app($this->objectClass)->getPurchasedObjects($oldTemplateId);
       if(sizeof($objects) > 0){
          $i = 0;
          foreach ($objects as $key) {
            $customObject = new CustomObject();
            $customObject->template_id = $newTemplateId;
            $customObject->name = $objects[$i]['name'];
            $customObject->type = $objects[$i]['type'];
            $customObject->content = $objects[$i]['content'];
            $customObject->settings = $objects[$i]['settings'];
            $customObject->created_at = Carbon::now();
            $customObject->save();
            if($customObject->id){
              $this->managePurchasedAttributes($objects[$i]['attributes'], $customObject->id);
            }
            $i++;
          }
       }
    }

    public function managePurchasedAttributes($attributes, $objectId){
      if(sizeof($attributes) > 0){
        $i = 0;
        foreach ($attributes as $key) {
          $attribute = new Attribute();
          $attribute->payload = 'object';
          $attribute->payload_value = $objectId;
          $attribute->attribute = $attributes[$i]['attribute'];
          $attribute->value = $attributes[$i]['value'];
          $attribute->created_at = Carbon::now();
          $attribute->save();
          $i++;
        }
      }
    }
}
