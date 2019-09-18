<template>
  <div class="holder">
    <span class="list" v-if="data !== null">
      <span class="items">
        <span class="title">
          <b>Your Items</b>
        </span>
        <span class="item" v-for="item, index in data">
          <span class="objects-holder">
          
          </span>
          <span class="details">
              <label style="margin-top: 10px;">
                <b>{{item.title}}</b>
                <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
              </label>
              <label style="margin-top: 10px;" >
                Price: {{products.currency}} {{item.price}} x {{item.months}}
              </label>
              <label style="margin-top: 10px;" >
                Total: {{products.currency}} {{item.total_amount}}
              </label>
          </span>
        </span>
      </span>
      <span class="sidebar pull-right">
        <span class="title">Order Summary</span>
        <span class="item">
          <label>Subtotal</label>
          <label class="pull-right" style="padding-right: 10px;">PHP {{subTotal}}</label>
        </span>
        <span class="item">
          <label>Tax</label>
          <label class="pull-right" style="padding-right: 10px;">PHP {{tax}}</label>
        </span>
        
        <span class="item">
          <label class="text-primary">
            <b>Promo Code</b>: <b v-if="coupon !== null">{{coupon.code.toUpperCase()}}</b>
            <b v-if="coupon !== null && coupon.type === 'percentage'"> (-{{coupon.value}}%)</b>
            <b v-if="coupon !== null && coupon.type === 'fixed_amount'"> (-{{coupon.value}})</b>
          </label>
          <i @click="clearCoupon()" class="fa fa-trash text-danger pull-right" style="line-height: 50px; font-size: 20px;padding-right: 10px;" v-if="coupon !== null"></i>
          <i @click="applyCoupon()" class="fa fa-plus text-primary pull-right" style="line-height: 50px; font-size: 20px;padding-right: 10px;" v-else></i>
        </span>

        <span class="item" style="border-bottom: 0px;">
          <label><b>Total</b></label>
          <label class="pull-right" style="padding-right: 10px;"><b>PHP {{total}}</b></label>
        </span>
        
        <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.stripe !== null">
          <label>Active Payment Method</label>
          
          <label class="pull-right" style="padding-right: 10px;">******** {{method.stripe.last4}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
        </span>
        <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.paypal !== null">
          <label>Active Payment Method</label>
          
          <label class="pull-right" style="padding-right: 10px;"> {{method.paypal.nickname}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
        </span>

        <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.payload === 'cod'">
          <label>Active Payment Method</label>
          
          <label class="pull-right" style="padding-right: 10px;"> {{method.payload_value}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
        </span>
        <span class="custom-btn" style="border-bottom: 0px;">
            <PayPal
              v-bind:amount="'' + total"
              currency="PHP"
              :client="paypal"
              :button-style="myStyle"
              :env="paypalStatus"
              @payment-completed="paypalCompleted($event)"
              @payment-cancelled="paypalCancelled($event)"
              @payment-authorized="paypalAuthorized($event)">
            </PayPal>
        </span>
        <button class="btn btn-primary custom-btn" @click="creditCard()"><i class="fa fa-credit-card"></i> Credit Card</button>
        <button class="btn btn-primary custom-btn" @click="redirect('/profile/payment_method')" v-if="method === null">Authorized Payment using Credit Card</button>
        <button class="btn btn-warning custom-btn" @click="updateStripeAuthorized()"> Complete Purchase</button>
      </span>
    </span>
    <cancelled-paypal></cancelled-paypal>
    <express-credit-card></express-credit-card>
    <apply-coupon></apply-coupon>
  </div>
</template>
<style scoped>
.holder{
  width: 98%;
  float: left;
  margin-right: 2%;
  margin-top: 25px;
}
.list{
  width: 100%;
  float: left;
  margin-top: 25px;
}
.items{
  width: 70%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.items .title{
  height: 50px;
  width: 100%;
  float: left;
  line-height: 50px;
  padding-left: 10px;
  font-size: 24px;
  border-bottom: solid 1px #eee;
  color: #22b173;
}
.items .item{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
  border-bottom: solid 1px #eee;
}
.objects-holder{
  float: left;
}
.details{
  float: left;
  width: 70%;
}
.two-objects-holder{
  float: left;
  width: 80%;
}
.two-details{
  float: left;
  width: 40%;
}
.details label, .two-details label{
  width: 100%;
  float: left;
}
.sidebar{
  width: 30%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
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
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
import PayPal from 'vue-paypal-checkout'
import PRODUCTS from '../../products.js'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      method: null,
      total: null,
      tax: null,
      coupon: null,
      discount: null,
      subTotal: null,
      products: PRODUCTS,
      paypal: CONFIG.paypal,
      paypalStatus: CONFIG.IS_DEV ? 'sandbox' : 'production',
      myStyle: {
        label: 'checkout',
        size: 'responsive',
        shape: 'pill',
        color: 'gold'
      },
      success: null
    }
  },
  components: {
    'cancelled-paypal': require('modules/checkout/CancelPaypal.vue'),
    'express-credit-card': require('modules/checkout/CreditCard.vue'),
    'apply-coupon': require('components/increment/ecommerce/coupon/Apply.vue'),
    PayPal
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }, {
          column: 'status',
          value: 'added',
          clause: '='
        }],
        account_id: this.user.userID
      }
      this.APIRequest('plans/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data
          this.method = response.method
          this.subTotal = response.sub_total
          this.tax = response.tax
          this.total = response.total
          this.initPaypal()
        }else{
          this.data = null
        }
      })
    },
    remove(id){
      let parameter = {
        id: id
      }
      this.APIRequest('plans/delete', parameter).then(response => {
        AUTH.checkAuthentication(null)
        this.retrieve()
      })
    },
    updateStripeAuthorized(){
      if(this.data !== null){
        let parameter = {
          id: this.data[0].id,
          payment_type: 'authorized',
          payment_payload: 'credit_card',
          payment_payload_value: this.method.id,
          sub_total: this.subTotal,
          total: this.total,
          tax: this.tax,
          account_id: this.user.userID,
          email: this.user.email,
          order_number: this.data[0].order_number
        }
        this.updateRequest(parameter)
      }
    },
    updateStripeExpress(id){
      if(this.data !== null){
        let parameter = {
          id: this.data[0].id,
          coupon_id: (this.coupon !== null) ? this.coupon.id : null,
          payment_type: 'express',
          payment_payload: 'credit_card',
          payment_payload_value: id,
          sub_total: this.subTotal,
          total: this.total,
          tax: this.tax,
          discount: (this.coupon !== null) ? this.discount : 0,
          account_id: this.user.userID,
          email: this.user.email,
          order_number: this.data[0].order_number
        }
        this.updateRequest(parameter)
      }
    },
    initPaypal(){
    },
    paypalCompleted(data){
      if(data.state === 'approved'){
        let parameter = {
          id: this.data[0].id,
          coupon_id: (this.coupon !== null) ? this.coupon.id : null,
          payment_type: 'express',
          payment_payload: 'paypal',
          payment_payload_value: data,
          sub_total: this.subTotal,
          total: this.total,
          tax: this.tax,
          discount: (this.coupon !== null) ? this.discount : 0,
          account_id: this.user.userID,
          email: this.user.email,
          order_number: this.data[0].order_number
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
      this.APIRequest('plans/update', parameter).then(response => {
        if(response.data === true){
          AUTH.checkAuthentication(null)
          ROUTER.push('/cp_thank_you/' + this.data[0].order_number)
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
      this.retrieve()
    },
    manageCoupon(){
      if(this.coupon !== null){
        if(this.coupon.type === 'percentage'){
          this.discount = (parseFloat(this.coupon.value) / 100) * this.total
        }else if(this.coupon.type === 'fixed_amount'){
          this.discount = parseFloat(this.coupon.value)
        }
        this.total -= this.discount
      }
    }
  }
}
</script>

