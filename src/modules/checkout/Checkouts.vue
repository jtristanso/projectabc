<template>
  <div class="holder">
    <span class="list" v-if="data !== null && data[0].items !== null">
      <span class="checkout-steps">
        <ul>
          <li v-for="item, index in steps" v-bind:class="{'hide-on-mobile': activeStep !== index}">
           <label class="step-number" v-bind:class="{'bg-primary': activeStep === index, 'bg-warning': activeStep !== index}">{{index + 1}}</label>
           <label class="step-title" v-bind:class="{'text-primary': activeStep === index, 'text-warning': activeStep !== index}">{{item.title}}</label>          </li>
        </ul>
      </span>
      <span class="step-viewer">
        <cart-step :data="data" :method="method" v-if="activeStep === 0"></cart-step>
        <printing-step :data="data[0]" :method="method" v-if="activeStep === 1"></printing-step>
        <shipping-address :item="data[0]" :method="method" v-if="activeStep === 2"></shipping-address>
        <payment-method :item="data[0]" :method="method" v-if="activeStep === 3"></payment-method>
      </span>
    </span>
    <checkout-empty v-if="data === null || data[0].items === null" :title="'You don\'t have items on your cart yet!'" :action="'Start checking out items now!'" :icon="'far fa-smile'" :iconColor="'text-primary'"></checkout-empty>
  </div>
</template>
<style scoped>
.holder{
  width: 98%;
  float: left;
  margin-right: 2%;
  margin-top: 25px;
  margin-bottom: 100px;
}
.checkout-steps{
  width: 100%;
  float: left;
  margin-bottom: 25px;
}
.checkout-steps ul{
  width: 100%;
  float: left;
  margin: 0px;
  padding: 0px;
  list-style: none;
}
.checkout-steps ul li{
  width: 25%;
  float: left;
  height: 50px;
}
.step-number{
  height: 30px;
  width: 30px;
  border-radius: 50%;
  line-height: 30px;
  margin-top: 10px;
  text-align: center;
}
.step-viewer{
  width: 100%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.list{
  width: 100%;
  float: left;
  margin-top: 25px;
}
.hide-on-mobile{
  display: block;
}

@media (max-width: 991px){
  .items, .sidebar{
    width: 100%;
  }
  .checkout-steps ul li{
    width: 100%;
    text-align: center;
  }
  .hide-on-mobile{
    display: none;
  }
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
    AUTH.checkPlan()
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      method: null,
      success: null,
      parter: null,
      steps: CONFIG.checkoutSteps,
      activeStep: 0
    }
  },
  components: {
    'checkout-empty': require('components/increment/generic/empty/EmptyDynamicIcon.vue'),
    'cart-step': require('modules/checkout/CartStep.vue'),
    'printing-step': require('modules/checkout/Printing.vue'),
    'shipping-address': require('components/increment/ecommerce/shipping/CheckoutShipping.vue'),
    'payment-method': require('components/increment/ecommerce/payment/PaymentMethod.vue')
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
      $('#loading').css({display: 'block'})
      this.APIRequest('custom_checkouts/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data
          this.method = response.method
        }else{
          this.data = null
        }
      })
    },
    remove(id){
      let parameter = {
        id: id
      }
      this.APIRequest('checkout_items/delete', parameter).then(response => {
        AUTH.checkAuthentication(null)
        this.retrieve()
      })
    },
    setNextActiveStep(){
      if(this.activeStep < 3){
        this.activeStep++
      }
    },
    setPreviousActiveStep(){
      if(this.activeStep > 0){
        this.activeStep--
      }
    }
  }
}
</script>

