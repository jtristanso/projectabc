<template>
  <div class="sidebar">
    <span class="title">Order Summary</span>
    <span class="bg-danger printing-hint" v-if="item.merchant === null">
      Kindly assign your checkout to our printing partner by clicking the + icon below using the company code.  
    </span>
    <span class="item" v-if="item.merchant !== null">
      <label>Subtotal</label>
      <label class="pull-right" style="padding-right: 10px;">PHP {{item.sub_total}}</label>
    </span>
    <span class="item" v-if="item.merchant !== null">
      <label>Tax</label>
      <label class="pull-right" style="padding-right: 10px;">PHP {{item.tax}}</label>
    </span>
    <span class="item" style="border-bottom: 0px;" v-if="item.payload !== 'direct'">
      <label class="text-primary">
        <label v-if="item.merchant === null"><b>Assign</b></label>
        <label v-if="item.merchant !== null"><b>Assigned</b></label>
        <b>Printing</b> <b v-if="item.merchant !== null">{{' to ' + item.merchant.account.username}}</b>
      </label>
      <i @click="clearMerchant()" class="fa fa-trash text-danger pull-right" style="line-height: 50px; font-size: 20px;padding-right: 10px;" v-if="item.merchant !== null"></i>
      <i @click="applyMerchant()" class="fa fa-plus text-primary pull-right" style="line-height: 50px; font-size: 20px;padding-right: 10px;" v-else></i>
    </span>
    <span class="item" style="border-bottom: 0px;" v-if="item.merchant !== null">
      <label class="text-primary">
        <b>Promo Code</b>: <b v-if="coupon !== null">{{coupon.code.toUpperCase()}}</b>
        <b v-if="coupon !== null && coupon.type === 'percentage'"> (-{{coupon.value}}%)</b>
        <b v-if="coupon !== null && coupon.type === 'fixed_amount'"> (-{{coupon.value}})</b>
      </label>
      <i @click="clearCoupon()" class="fa fa-trash text-danger pull-right" style="line-height: 50px; font-size: 20px;padding-right: 10px;" v-if="coupon !== null"></i>
      <i @click="applyCoupon()" class="fa fa-plus text-primary pull-right" style="line-height: 50px; font-size: 20px;padding-right: 10px;" v-else></i>
    </span>
    <span class="item" style="border-bottom: 0px;" v-if="item.merchant !== null">
      <label><b>Total</b></label>
      <label class="pull-right" style="padding-right: 10px;"><b>PHP {{item.total}}</b></label>
    </span>
    <span class="item" style="border-bottom: 0px;">
      <label><b>Ship to</b></label>
      <label class="pull-right"><i class="fa fa-edit text-danger" @click="shippingAddress()"></i></label>
    </span>
    <span class="item2 alert alert-success" v-if="item.shipping_address !== null">
      <label v-if="item.shipping_address === null && item.account_details.billing !== null && item.account_details.billing.company !== null">
        {{item.account_details.billing.company}}, {{item.account_details.billing.address + ',' + item.account_details.billing.city + ' ' + item.account_details.billing.postal_code}}
        <br />
        {{item.account_details.billing.state + ', ' + item.account_details.billing.country}}
      </label>
      <label v-if="item.shipping_address !== null && item.shipping_address.payload === 'billing'">
        {{item.shipping_address.payload_details.company}}, {{item.shipping_address.payload_details.address + ',' + item.shipping_address.payload_details.city + ' ' + item.shipping_address.payload_details.postal_code}}
        <br />
        {{item.shipping_address.payload_details.state + ', ' + item.shipping_address.payload_details.country}}
      </label>
      <label v-if="item.shipping_address !== null && item.shipping_address.payload === 'other'">
         {{item.shipping_address.payload_value}}
      </label>
    </span>
    <span class="item" style="border-bottom: 0px;" v-if="item.shipping_address !== null && item.shipping_address.notes !== null">
      <label><b>Shipping Note</b></label>
    </span>
    <span class="item2  alert alert-danger" style="border-bottom: 0px;" v-if="item.shipping_address !== null && item.shipping_address.notes !== null">
      <label>{{item.shipping_address.notes}}</label>
    </span>
    <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.stripe !== null && item.merchant !== null">
      <label>Active Payment Method</label>
      
      <label class="pull-right" style="padding-right: 10px;">******** {{method.stripe.last4}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
    </span>
    <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.paypal !== null && item.merchant !== null">
      <label>Active Payment Method</label>
      
      <label class="pull-right" style="padding-right: 10px;"> {{method.paypal.nickname}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
    </span>

    <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.payload === 'cod'">
      <label>Active Payment Method</label>
      
      <label class="pull-right" style="padding-right: 10px;"> {{method.payload_value}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
    </span>
    <span class="custom-btn" style="border-bottom: 0px;" v-if="item.merchant !== null">
        <PayPal
          v-bind:amount="'' + item.total"
          currency="PHP"
          :client="paypal"
          :button-style="myStyle"
          :env="paypalStatus"
          @payment-completed="paypalCompleted($event)"
          @payment-cancelled="paypalCancelled($event)"
          @payment-authorized="paypalAuthorized($event)">
        </PayPal>
    </span>
    <button class="btn btn-primary custom-btn" @click="creditCard()" v-if="item.merchant !== null"><i class="fa fa-credit-card"></i> Credit Card</button>
    <button class="btn btn-primary custom-btn" @click="redirect('/profile/payment_method')" v-if="method === null && item.merchant !== null">Authorized Payment using Credit Card</button>
    <!-- <button class="btn btn-warning custom-btn" @click="updateStripeAuthorized()"> Complete Purchase</button> -->
    
    <cancelled-paypal></cancelled-paypal>
    <express-credit-card></express-credit-card>
    <apply-coupon></apply-coupon>
    <apply-partner></apply-partner>
    <shipping-address :item="item"></shipping-address>
  </div>
</template>
<style scoped>
.sidebar{
  width: 100%;
  float: left;
}
.sidebar .title, .sidebar .item{
  height: 50px;
  width: 100%;
  float: left;
  line-height: 50px;
  border-bottom: solid 1px #eee;
  padding-left: 10px;
}
.sidebar .title{
  font-size: 24px;
  border-bottom: 0px;
  background: #22b173;
  color: #fff;
}
.sidebar .item2{
  min-height: 50px;
  width: 100%;
  float: left;
  border-bottom: solid 1px #eee;
  padding-left: 10px;
  overflow-y: hidden;
  text-align: justify;
}

.sidebar .item2 label{
  width: 100%;
  float: left;
}
.custom-btn{
  margin-top: 10px !important; 
  width: 100% !important;
  height: 50px !important;
}
.fa-edit{
  font-size: 24px;
  line-height: 50px;
  float: left;
}
.delete:hover{
  cursor: pointer;
}
.fa-edit:hover{
  cursor: pointer;
  color: #22b173;
}
.printing-hint{
  width: 100%;
  float: left;
  min-height: 50px;
  margin-top: 10px;
  overflow-y: hidden;
  padding: 10px;
  color: #fff;
  text-align: justify;
  border-radius: 5px;
}

.alert{
  margin: 0px !important;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
import PayPal from 'vue-paypal-checkout'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      partner: null,
      coupon: null,
      discount: null,
      paypal: CONFIG.paypal,
      paypalStatus: CONFIG.IS_DEV ? 'sandbox' : 'production',
      myStyle: {
        label: '',
        size: 'responsive',
        shape: 'pill',
        color: 'gold'
      },
      success: null
    }
  },
  props: ['item', 'method'],
  components: {
    'cancelled-paypal': require('modules/checkout/CancelPaypal.vue'),
    'express-credit-card': require('modules/checkout/CreditCard.vue'),
    'apply-coupon': require('components/increment/ecommerce/coupon/Apply.vue'),
    'apply-partner': require('modules/checkout/Partner.vue'),
    'shipping-address': require('modules/checkout/ShippingAddress.vue'),
    PayPal
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    updateStripeAuthorized(){
      if(this.data !== null){
        let parameter = {
          id: this.item.id,
          payment_type: 'authorized',
          payment_payload: 'credit_card',
          payment_payload_value: this.method.id,
          sub_total: this.item.sub_total,
          total: this.item.total,
          tax: this.item.tax,
          account_id: this.user.userID,
          email: this.user.email,
          order_number: this.item.order_number
        }
        this.updateRequest(parameter)
      }
    },
    updateStripeExpress(id){
      if(this.data !== null){
        let parameter = {
          id: this.item.id,
          payment_type: 'express',
          payment_payload: 'credit_card',
          payment_payload_value: id,
          sub_total: this.item.sub_total,
          total: this.item.total,
          tax: this.item.tax,
          discount: (this.coupon !== null) ? this.discount : 0,
          coupon_id: (this.coupon !== null) ? this.coupon.id : null,
          account_id: this.user.userID,
          email: this.user.email,
          order_number: this.item.order_number
        }
        this.updateRequest(parameter)
      }
    },
    paypalCompleted(data){
      if(data.state === 'approved'){
        let parameter = {
          id: this.item.id,
          payment_type: 'express',
          payment_payload: 'paypal',
          payment_payload_value: data,
          sub_total: this.item.sub_total,
          total: this.item.total,
          tax: this.item.tax,
          discount: (this.coupon !== null) ? this.discount : 0,
          coupon_id: (this.coupon !== null) ? this.coupon.id : null,
          account_id: this.user.userID,
          email: this.user.email,
          order_number: this.item.order_number
        }
        this.updateRequest(parameter)
      }
    },
    paypalCancelled(data){
      $('#cancelPaypalModal').modal('show')
    },
    paypalAuthorized(data){
    },
    updateRequest(parameter){
      this.APIRequest('custom_checkouts/update', parameter).then(response => {
        if(response.data === true){
          AUTH.checkAuthentication(null)
          ROUTER.push('/thankyou/' + this.item.order_number)
        }
      })
    },
    creditCard(){
      $('#creditCardModal').modal('show')
    },
    applyCoupon(){
      $('#applyCouponModal').modal('show')
    },
    clearCoupon(){
      this.coupon = null
      this.$parent.retrieve()
    },
    applyMerchant(){
      $('#applyPartnerModal').modal('show')
    },
    clearMerchant(){
      let parameter = {
        id: this.item.id
      }
      this.APIRequest('custom_checkouts/update_remove_merchant', parameter).then(response => {
        if(response.data === true){
          this.$parent.retrieve()
        }
      })
    },
    managePartner(){
      let parameter = {
        id: this.item.id,
        merchant_id: this.partner.id
      }
      this.APIRequest('custom_checkouts/update_status', parameter).then(response => {
        if(response.data === true){
          $('#applyPartnerModal').modal('hide')
          this.$parent.retrieve()
        }
      })
    },
    manageCoupon(){
      if(this.coupon !== null){
        if(this.coupon.type === 'percentage'){
          this.discount = (parseFloat(this.coupon.value) / 100) * this.item.total
        }else if(this.coupon.type === 'fixed_amount'){
          this.discount = parseFloat(this.coupon.value)
        }
        this.item.total -= this.discount
      }
    },
    shippingAddress(){
      $('#shippingAddressModal').modal('show')
    },
    retrieve(){
      this.$parent.retrieve()
    }
  }
}
</script>
