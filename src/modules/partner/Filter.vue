<template>
  <div class="filter">
    <div class="input-group">
      <span id="content-desktop" class="input-group-addon">Filter By</span>
      <select id="content-desktop" class="form-control" v-model="filterValue" @change="retrieve()">
        <option value="name">Name</option>
        <option value="address">Location</option>
      </select>
      <span id="content-mobile" class="input-group-addon"><i class="fas fa-filter"></i></span>
      <select id="content-mobile" class="form-control" v-model="filterValue" @change="retrieve()">
        <option value="name">Name</option>
        <option value="address">Location</option>
      </select>
      <span id="content-desktop" class="input-group-addon">Search</span>
      <span id="content-mobile" class="input-group-addon"><i class="fas fa-search"></i></span>
      <input type="text" class="form-control" v-model="searchValue" @keyup.enter="retrieve()" placeholder="Search here...">
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
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
  background: $primary !important;
  color: #fff !important;
}
.input-group-title{
  width: 100px !important;
  background: $primary !important;
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
#content-desktop{
  display: inherit;
}
#content-mobile{
  display: none;
}
@media only screen and (max-width: 400px){
  #content-desktop{
    display: none;
  }
  #content-mobile{
    display: inherit;
    width: 32px !important;
  }
  .form-control{
    width: 80px;
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
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      filterValue: 'name',
      searchValue: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      this.$parent.filterValue = this.filterValue
      this.$parent.searchValue = this.searchValue
      this.$parent.retrieve()
    }
  }
}
</script>
