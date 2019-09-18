<template>
  <div class="checkout-printing">
    <div class="items">
      <div class="printing-partner-holder">
        <printing-partners :checkout="data"></printing-partners>
      </div>
    </div>
    <div class="sidebar">
      <total :item="data" :method="method" :buttonTitle="'Continue'" :back="true"></total>
    </div>

  </div>
</template>
<style scoped>
.form-check-input{
  float: left !important;
  position: inherit !important;
  margin-left: 0px;
}
.form-check-label{
  padding-left: 10px !important;
}
.checkout-printing .items{
  width: 68%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
  margin-right: 2%;
}
.checkout-printing .sidebar{
  width: 30%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.checkout-printing .step-action{
  width: 100%;
  float: left;
  margin-bottom: 25px;
}
.printing-menu{
  width: 100%;
  float: left;
  margin: 0px;
  list-style: none;
  padding: 0px;
}

.printing-menu li{
  float: left;
  padding-left: 20px;
  padding-right: 20px;
  height: 50px;
  border-right: solid 1px #ddd;
  border-left: solid 1px #ddd;
  line-height: 50px;
}
.printing-menu li:hover{
  cursor: pointer;
  border: solid 1px #ddd;
}
.printing-partner-holder{
  width: 100%;
  float: left;
}

@media (max-width: 991px){
  .checkout-printing .items{
    width: 100%;
    margin-right: 0%;
  }
  .checkout-printing .sidebar{
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
      errorMessage: null
    }
  },
  components: {
    'total': require('components/increment/ecommerce/checkout/Total.vue'),
    'printing-partners': require('modules/partner/CheckoutPartners.vue')
  },
  props: ['data', 'method'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    setNextActiveStep(){
      this.$parent.setNextActiveStep()
    },
    setPreviousActiveStep(){
      this.$parent.setPreviousActiveStep()
    },
    updatePrinting(id){
      let parameter = {
        id: this.data.id,
        merchant_id: id
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('custom_checkouts/update_merchant', parameter).then(response => {
        this.$parent.retrieve()
      })
    }
  }
}
</script>
