<template>
  <div class="cart-items" v-if="data !== null">
    <span class="title">
      <b>Your Items</b>
    </span>
    <span class="item" v-for="item, index in data[0].items" >
      <span class="objects-holder" v-if="item.payload === 'template'">
        <objects :objects="item.objects" v-if="item.objects !== null" :heightTemplate="parseInt(item.template.height)" :widthTemplate="parseInt(item.template.width)"></objects>
      </span>
      <span class="objects-holder" v-if="item.payload === 'employee' && item.employee.front_objects !== null && parseInt(item.employee.front_template_details.height) === config.PORTRAIT">
        <objects :objects="item.employee.front_objects" :heightTemplate="parseInt(item.employee.front_template_details.height)" :widthTemplate="parseInt(item.employee.front_template_details.width)"></objects>
      </span>
      <span class="objects-holder" v-if="item.payload === 'employee' && item.employee.back_objects !== null && parseInt(item.employee.front_template_details.height) === config.PORTRAIT">
        <objects :objects="item.employee.back_objects" :heightTemplate="parseInt(item.employee.front_template_details.height)" :widthTemplate="parseInt(item.employee.front_template_details.width)"></objects>
      </span>
      <span class="objects-holder" v-if="item.payload === 'employee' && item.employee.back_objects !== null && parseInt(item.employee.front_template_details.height) === config.LANDSCAPE">
        <objects :objects="item.employee.front_objects" :heightTemplate="parseInt(item.employee.front_template_details.height)" :widthTemplate="parseInt(item.employee.front_template_details.width)"></objects>
        <objects :objects="item.employee.back_objects" :heightTemplate="parseInt(item.employee.front_template_details.height)" :widthTemplate="parseInt(item.employee.front_template_details.width)"></objects>
      </span>


      <span class="objects-holder" v-if="item.payload === 'profile' && item.active_templates.front !== null && parseInt(item.active_templates.front.height) === config.LANDSCAPE">
        <badge-profile :objects="item.active_templates.front.objects" :heightTemplate="parseInt(item.active_templates.front.height)" :widthTemplate="parseInt(item.active_templates.front.width)" :profile="item.profile"></badge-profile>
        <badge-profile :objects="item.active_templates.back.objects" :heightTemplate="parseInt(item.active_templates.front.height)" :widthTemplate="parseInt(item.active_templates.front.width)" :profile="item.profile"></badge-profile>
      </span>

      <span class="objects-holder" v-if="item.payload === 'profile' && item.active_templates.front !== null && parseInt(item.active_templates.front.height) === config.PORTRAIT">
        <badge-profile :objects="item.active_templates.front.objects" :heightTemplate="parseInt(item.active_templates.front.height)" :widthTemplate="parseInt(item.active_templates.front.width)" :profile="item.profile"></badge-profile>
      </span>


      <span class="objects-holder" v-if="item.payload === 'profile' && item.active_templates.back !== null && parseInt(item.active_templates.front.height) === config.PORTRAIT">
        <badge-profile :objects="item.active_templates.back.objects" :heightTemplate="parseInt(item.active_templates.front.height)" :widthTemplate="parseInt(item.active_templates.front.width)" :profile="item.profile"></badge-profile>
      </span>


      <span class="objects-holder-full" v-if="item.payload === 'product' && item.product !== null">
        <marketplace-product :data="item" :route="'checkout_items'"></marketplace-product>
      </span>
      <span class="details" v-if="item.payload === 'template' || (item.payload === 'employee' && (item.employee.back_objects === null || item.employee.front_objects === null))">
          <label style="margin-top: 10px;" v-if="item.payload === 'employee'">
            Price: Php {{item.employee.price}}
            <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
          </label>
          <label style="margin-top: 10px;" v-if="item.payload === 'template'">
            <b>{{item.template.title}}</b>
            <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
          </label>
          <label v-if="item.payload === 'template'">Price Php {{item.template.price}}</label>
          <label v-if="item.payload === 'template'">Cetegory: {{item.template.categories}}</label>
          <label v-if="item.payload === 'template'">
            <rating :payload="'template'" :payloadValue="item.payload_value"></rating>
          </label>
      </span>
      <span class="two-details" v-if="item.payload === 'employee' && item.employee.back_objects !== null && item.employee.front_objects !== null">
          <label style="margin-top: 10px;">
            Price Php {{item.employee.price}}
            <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
          </label>
      </span>


      <span class="two-details" v-if="item.payload === 'profile' && item.active_templates.front !== null && item.active_templates.back !== null">
          <label style="margin-top: 10px;">
            Price Php {{item.price}}
            <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
          </label>
      </span>

    </span>
  </div>
</template>
<style scoped>
.cart-items{
  width: 100%;
  float: left;
}
.cart-items .title{
  height: 50px;
  width: 100%;
  float: left;
  line-height: 50px;
  padding-left: 10px;
  font-size: 24px;
  border-bottom: solid 1px #eee;
  color: #22b173;
}
.cart-items .item{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
  border-bottom: solid 1px #eee;
}
.objects-holder-full{
  float: left;
  width: 100%;
  height: 150px;
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
  props: ['data'],
  components: {
    'objects': require('modules/object/Objects.vue'),
    'badge-profile': require('modules/object/BadgeProfile.vue'),
    'rating': require('components/increment/generic/rating/Ratings.vue'),
    'marketplace-product': require('components/increment/ecommerce/marketplace/CheckoutItem.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    remove(id){
      let parameter = {
        id: id
      }
      this.APIRequest('checkout_items/delete', parameter).then(response => {
        AUTH.checkAuthentication(null)
        this.retrieve()
      })
    }
  }
}
</script>
