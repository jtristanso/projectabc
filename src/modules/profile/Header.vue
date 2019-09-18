<template>
  <div class="profile-header-wrapper" v-if="item.account !== null">
    <div class="incre-row text-center">
      <span class="image text-center" v-if="item.account.profile !== null">
        <img :src="config.BACKEND_URL + item.account.profile.url">
      </span>
      <span class="image text-center" v-else>
        <i class="fa fa-user-circle-o" ></i>
      </span>
    </div>
    <div class="incre-row text-center">
      <h2 class="text-primary" v-if="item.account.information !== null">
        <b v-if="item.account.information.first_name !== null">{{item.account.information.first_name}}</b>
        <b v-if="item.account.information.last_name !== null">{{item.account.information.last_name}}</b>
      </h2>
      <h2 v-else class="text-primary">{{item.account.username}}</h2>
      <label v-if="item.account.information !== null"><b>{{item.account.information.address}}</b></label>
      <label class="text-warning">
        <i class="fab fa-facebook action-link"></i>
        <i class="fab fa-twitter action-link"></i>
        <i class="fab fa-instagram action-link"></i>
        <i class="fab fa-linkedin action-link"></i>
      </label>
    </div>
  </div>
</template>
<style scoped>
.profile-header-wrapper{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
}
.image{
  width: 100%;
  float: left; 
}
.image img{
  width: 150px;
  height: 150px;
}
.image i{
  font-size: 150px;
  line-height: 200px;
}
.image img{
  border-radius: 50%;
}
.incre-row h2, .incre-row label{
  height: 40px;
  line-height: 40px;
  width: 100%;
  margin-bottom: 0px;
}
.incre-row label i{
  font-size: 24px;
  padding-right: 5px;
  padding-left: 5px;
}
label{
  width: 100%;
  float: left;
  margin: 0px;
  line-height: 40px;
}
@media (max-width: 992px){
}

</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
export default{
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG
    }
  },
  props: ['item'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
