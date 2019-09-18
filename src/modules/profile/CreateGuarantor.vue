<template>
  <div class="profile-holder">
    <span class="header">Guarantor</span>
    <span class="content">
      <span class="inputs" v-if="data !== null">
        <div class="form-group" style="margin-top: 25px;">
          <label for="address">First Name</label>
          <input type="text" class="form-control" placeholder="Enter First Name" v-model="data.first_name">
        </div>

        <div class="form-group">
          <label for="address">Middle Name</label>
          <input type="text" class="form-control" placeholder="Optional" v-model="data.middle_name">
        </div>

        <div class="form-group">
          <label for="address">Last Name</label>
          <input type="text" class="form-control" placeholder="Enter Last Name" v-model="data.last_name">
        </div>

        <div class="form-group">
          <label for="address">Gender</label>
          <select class="form-control" v-model="data.sex">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>

        <div class="form-group">
          <label for="address">Cellular Numbar</label>
          <input type="text" class="form-control" placeholder="Optional" v-model="data.cellular_number">
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" class="form-control" placeholder="Optional" v-model="data.address">
        </div>

        <div class="form-group">
          <label for="address">Birthdate</label>
          <input type="date" class="form-control" v-model="data.birth_date" placeholder="Optional">
        </div>

        <button class="btn btn-primary" style="margin-bottom: 25px;" @click="update()">Update</button>
      
      </span>
      <span class="sidebar">
        <span class="sidebar-header" style="margin-top: 25px;">Profile Picture</span>
        <span class="image" v-if="user.profile !== null">
          <img :src="config.BACKEND_URL + user.profile.url" height="auto" width="100%" >
        </span>
        <span class="image" v-else>
          <i class="fa fa-user-circle-o" ></i>
        </span>
        <button class="btn btn-primary custom-block" style="margin-top: 5px;" @click="showImages()">Select from images
        </button>
      </span>
    </span>
    <browse-images-modal :object="user.profile" v-if="user.profile !== null"></browse-images-modal>
    <browse-images-modal :object="newProfile" v-if="user.profile === null"></browse-images-modal>
  </div>
</template>
<style scoped>
.profile-holder{
  width: 95%;
  float: left;
  margin-left: 5%;
}
.header{
  width: 100%;
  height: 50px;
  line-height: 50px;
  font-size: 24px;
  border-bottom: solid 1px #ddd;
  float: left;
}
.content{
  width: 100%;
  min-height: 50px;
  float: left;
  overflow-y: hidden;
}
.inputs{
  width: 65%;
  float: left;
  margin-right: 5%;
  min-height: 50px;
  overflow-y: hidden;
}
.sidebar{
  width: 30%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.sidebar-header{
  height: 40px;
  line-height: 40px;
  width: 100%;
  float: left;
}
.sidebar .image{
  width: 100%;
  float: left;
  min-height: 200px;
  overflow-y: hidden;
  text-align: center;
}
.image i{
  font-size: 150px;
  line-height: 200px;
}
.image img{
  border-radius: 5px;
}
.custom-block{
  width: 100%;
  float: left;
}
.custom-block input{
  display: none;
}
@media screen and (max-width: 992px){
  .holder{
    width: 96%;
    margin-left: 2%;
    margin-right: 2%;
  }
  .sidebar, .inputs{
    width: 100%;
    margin-right: 0%;
    margin-left: 0%;
  }
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import axios from 'axios'
import CONFIG from '../../config.js'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      config: CONFIG,
      data: null,
      newProfile: {
        account_id: null,
        url: null
      }
    }
  },
  components: {
    'browse-images-modal': require('components/increment/generic/image/BrowseModal.vue')
  },
  methods: {
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      this.APIRequest('account_informations/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data[0]
        }else{
          this.data = null
        }
      })
    },
    update(){
      if(this.validate()){
        this.APIRequest('account_informations/update', this.data).then(response => {
          if(response.data === true){
            this.retrieve()
          }
        })
      }
    },
    updatePhoto(object){
      this.APIRequest('account_profiles/update', object).then(response => {
        if(response.data === true){
          this.hideImages()
          this.retrieve()
          AUTH.checkAuthentication()
        }
      })
    },
    createPhoto(object){
      this.APIRequest('account_profiles/create', object).then(response => {
        if(response.data > 0){
          this.hideImages()
          AUTH.checkAuthentication()
        }
      })
    },
    validate(){
      let i = this.data
      if(i.first_name !== null && i.last_name !== null && i.sex !== null){
        return true
      }
      return false
    },
    showImages(){
      $('#browseImagesModal').modal('show')
    },
    hideImages(){
      $('#browseImagesModal').modal('hide')
    },
    manageImageUrl(url){
      if(this.user.profile !== null){
        this.user.profile.url = url
        this.updatePhoto(this.user.profile)
      }else{
        this.newProfile.account_id = this.user.userID
        this.newProfile.url = url
        this.createPhoto(this.newProfile)
      }
    }
  }
}
</script>
