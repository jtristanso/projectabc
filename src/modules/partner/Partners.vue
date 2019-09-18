<template>
  <div class="partner-holder">
    <div class="filter">
      <partner-filter></partner-filter>
    </div>
    <div class="partner-list" v-if="data !== null">
      <partner v-for="item, index in data" v-if="data !==null" :item="item" :key="item.id" :index="index" :printingButton="false"></partner>
    </div>
    <empty v-if="data === null" :title="'No printing partners available!'" :action="'Please be back soon.'">
    </empty>
  </div>
</template>
<style scoped>
.partner-holder{
  width: 100%;
  float: left;
  margin-top: 25px;
  padding-left: 20px;
  padding-right: 20px;
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
@media (max-width: 991px){
  .partner-holder{
    width: 100%;
  }
}
@media only screen and (max-width: 400px){
  .partner-holder{
    width: 100%;
    float: left;
    margin-top: 5px;
    padding-left: 0px;
    padding-right: 0px;
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
    }
  }
}
</script>
