<template>
  <div class="partner-holder">
    <div class="partner-list" v-if="checkout !== null">
      <div class="selected-partner">
        <b>Selected Printing</b>
      </div>
      <partner v-if="checkout.merchant !==null" :item="checkout.merchant" :printingButton="false" :selectedId="checkout.merchant.id"></partner>
    </div>
    <div class="filter" v-if="data !== null">
      <partner-filter></partner-filter>
    </div>
    <div class="partner-list" v-if="data !== null">
      <partner v-for="item, index in data" v-if="data !== null" :item="item" :key="item.id" :index="index" :printingButton="true" :selectedId="checkout.id"></partner>
    </div>
    <empty v-if="data === null && checkout.merchant === null" :title="'No printing partners available!'" :action="'Please be back soon.'">
    </empty>
  </div>
</template>
<style scoped>
.partner-holder{
  width: 100%;
  float: left;
}
.filter{
  width: 100%;
  float: left;
  height: 45px;
}

.form-control{
  height: 45px !important;
}
.input-group{
  margin-bottom: 10px !important;
}
.input-group-addon{
  width: 100px !important;
  background: #22b173 !important;
  color: #fff !important;
}
.input-group-title{
  width: 100px !important;
  background: #028170 !important;
  color: #fff !important;
}

.partner-list{
  width: 100%;
  float: left;
}
.selected-partner{
  width: 100%;
  float: left;
  height: 50px;
  line-height: 50px;
}
@media (max-width: 991px){
  .partner-holder{
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
    AUTH.checkPlan()
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      prevIndex: null,
      filterValue: 'name',
      searchValue: null
    }
  },
  props: ['checkout'],
  components: {
    'partner': require('modules/partner/Partner.vue'),
    'partner-filter': require('modules/partner/Filter.vue'),
    'empty': require('components/increment/generic/empty/Empty.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = null
      if(this.searchValue !== null){
        parameter = {
          condition: [{
            value: this.searchValue + '%',
            column: this.filterValue,
            clause: 'like'
          }, {
            value: 'verified',
            column: 'status',
            clause: '='
          }]
        }
      }else{
        parameter = {
          condition: [{
            value: 'verified',
            column: 'status',
            clause: '='
          }]
        }
      }
      if(this.checkout !== null && this.checkout.merchant !== null){
        parameter.condition.push({
          value: this.checkout.merchant.id,
          column: 'id',
          clause: '!='
        })
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('merchants/retrieve', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    makeActive(index){
      if(this.prevIndex === null){
        this.prevIndex = index
        this.data[index].active = true
      }else{
        if(this.prevIndex !== index){
          this.data[this.prevIndex].active = false
          this.data[index].active = true
          this.prevIndex = index
        }else{
          this.data[this.prevIndex].active = false
          this.prevIndex = null
        }
      }
    },
    updatePrinting(id){
      this.$parent.updatePrinting(id)
    }
  }
}
</script>
