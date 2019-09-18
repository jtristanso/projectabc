<template>
  <div class="cart-step">
    <span class="items">
      <cart-items :data="data"></cart-items>
    </span>
    <span class="sidebar pull-right">
      <total :item="data[0]" :method="method" :buttonTitle="'Proceed to checkout'" :back="false"></total>
    </span>
  </div>
</template>
<style scoped>
.cart-step{
  width: 100%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.cart-step .items{
  width: 68%;
  float: left;
  margin-right: 2%;
  min-height: 50px;
  overflow-y: hidden;
}
.cart-step .sidebar{
  width: 30%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
@media (max-width: 991px){
  .cart-step .items{
    width: 100%;
    margin-right: 0%;
  }
  .cart-step .sidebar{
    width: 100%;
  }
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      coupon: null,
      discount: null,
      success: null
    }
  },
  props: ['data', 'method'],
  components: {
    'cart-items': require('modules/checkout/CartItems.vue'),
    'total': require('components/increment/ecommerce/checkout/Total.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    setNextActiveStep(){
      this.$parent.setNextActiveStep()
    }
  }
}
</script>
