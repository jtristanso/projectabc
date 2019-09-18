<template>
  <div class="partner" v-if="item !== null && item.account !== null">
    <div class="partner-container">
      <div class="partner-profile">
        <img :src="config.BACKEND_URL + item.logo" v-if="item.logo !== null">
        <i class="fa fa-user-circle-o" v-else></i>
      </div>
      <div class="partner-info">
        <label class="item-name"><h5>{{item.name}}</h5></label>
        <label><i class="fas fa-map-marker-alt"></i>{{item.address}}</label>
        <label class="text-warning action-link" v-on:click="redirect('/messenger/' + item.account.username)"><i class="fas fa-envelope"></i>Send Message</label>
        <label class="text-danger action-link" v-on:click="redirect('/store/'+ item.code)"><i class="fas fa-store"></i>View Store</label>
      </div>
      <div class="partner-reviews">
<!--         <label class="input-group">
          <input type="text" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;" v-bind:id="'code' + item.id" class="form-control" v-model="item.code">
          <button class="btn btn-primary" @click="copy('code' + item.id)" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;"><i class="fa fa-copy"></i></button>
        </label> -->
        <label class="reviews">
          <span class="badge badge-warning">{{Math.floor(item.rating.avg)}}</span>
          <i v-bind:class="{'fas fa-star': item.rating.avg >= i, 'fa fa-star-o': item.rating.avg < i}" class="text-warning" v-for="i in 5"></i>
          <!-- 'fas fa-star-half-alt': item.rating.avg > (i - 1) && item.rating.avg < i  -->
        </label>
        <label>
          {{item.rating.size}} Reviews
        </label>
        <button class="btn btn-primary" v-if="printingButton === true" @click="printMeHere()">I want to print here</button>
      </div>
    </div>
  </div>
</template>
<style scoped>
.partner{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
  border: solid 1px #ddd;
}
.partner-container{
  margin-bottom: 10px;
  margin-top: 10px;
  width: 100%;
  float: left;
}
.partner-profile{
  width: 15%;
  float: left;
  text-align: center;
}
.partner-profile img{
  width: 100%;
  border-radius: 5px;
  float: left;
}
.partner-profile{
  font-size: 100px;
  float: left;
  line-height: 100px;
  padding-left: 10px;
}
.partner-info{
  margin-top: 5px;
  width: 35%;
  float: left;
}
.partner-info label{
  width: 100%;
  float: left;
  line-height: 16px;
  padding-left: 10px;
}
.partner-info label i{
  padding-right: 10px;
}
.partner-reviews{
  width: 50%;
  float: left;
  margin-top: 5px;
}
.partner-reviews label{
  width: 95%;
  float: left;
  margin-right: 5%;
}
.reviews i{
  padding-right: 5px;
}
@media (max-width: 991px){
  .partner-info{
    width: 100%;
  }
  .partner-reviews{
    width: 100%;
    padding-left: 10px;
  }
}
@media only screen and (max-width: 400px){
  .partner-profile{
    width: 80%;
    float: left;
    /* text-align: center; */
    margin-left: 33px;
    margin-top: 10px;
    margin-bottom: 10px;
  }
  .partner-profile img{
    width: 100%;
    border-radius: 5px;
  }
  /* .item-name{
    text-align: center;
    padding-bottom: 10px;
  } */
  .partner-info{
    width: 60%;
  }
  .partner-reviews{
    width: 40%;
    float: right;
    margin-top: 25px;
  }
  .partner-reviews label{
    width: 95%;
    float: right;
    margin-right: 5%;
  }
  .reviews i{
    padding-right: 5px;
  }
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      prevId: null
    }
  },
  props: ['item', 'index', 'printingButton', 'selectedId'],
  methods: {
    makeActive(){
      this.$parent.makeActive(this.index)
    },
    redirect(parameter){
      AUTH.redirect(parameter)
    },
    copy(id){
      let copyText = document.getElementById(id)
      copyText.select()
      document.execCommand('copy')
      console.log(copyText.value)
    },
    printMeHere(){
      this.$parent.updatePrinting(this.item.id)
    }
  }
}
</script>
