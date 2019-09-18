<template>
  <div class="work-experience-holder">
    <span class="header">Education
      <button class="btn btn-primary pull-right" style="margin-right: 10px;" @click="showModal('create')">Add</button>
    </span>
    <span class="content">
      <!-- Display Here -->
      <span class="display">
        <div class="rl-container-item" v-for="(item, index) in data" :key="index">
          <span class="header">
            <label class="cards-label"> 
              {{ item.month_started }}
              {{ item.year_started }}
            </label>
            -
            <label class="cards-label" v-if="item.month_ended && item.year_ended !== null">
              {{ item.month_ended }}
              {{ item.year_ended }}
            </label>
            <label class="cards-label" v-else>
              Present
            </label>
            <label class="pull-right">
              <div class="dropdown" id="dropdownMenuButtonDropdown">
              <i class="fas fa-ellipsis-h text-gray more-options" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-target="dropdownMenuButtonDropdown">
              </i>
              <div class="dropdown-menu dropdown-more-options" aria-labelledby="dropdownMenuButton" >
                <span class="dropdown-item action-link" @click="showModal('update', item)">Edit</span>
                <span class="dropdown-item action-link" @click="removeEducation(item.id)">Remove</span>
              </div>
            </div>
            </label>
          </span>
          <span class="summary-header">
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-university"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px;"> 
                {{ item.school }}
              </span>
            </div>
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-graduation-cap" style="font-size: 15px;"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px;">
                {{ item.degree }}
              </span>
            </div>
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-book" style="font-size: 21px;"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px;">
                {{ item.field_of_study }}
              </span>
            </div>
          </span>
        </div>
      </span>
    </span>
    <!-- <browse-images-modal :object="user.profile" v-if="user.profile !== null"></browse-images-modal> -->
    <create-modal :property="createEducationModal"></create-modal>
  </div>
</template>
<style scoped>
.cards-label {
  font-size: 20px;
  font-weight: 400;
}
span.dropdown-item.action-link {
  height: 50px !important;
}
.dropdown-menu.dropdown-more-options.show {
  padding: 0 !important;
}
.work-experience-holder{
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
.display{
  width: 100%;
  float: left;
  margin-right: 5%;
  min-height: 50px;
  overflow-y: hidden;
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
.rl-container-item{
  width: 100%;
  float: left;
  border-radius: 5px;
  min-height: 50px;
  overflow-y: hidden;
  border: solid 1px #ddd;
  margin-top: 10px;
  padding-left: 10px;
  padding-right: 10px;
}
.rl-container-item .header{
  width: 100%;
  float: left;
  height: 50px;
  line-height: 50px;
  color: #555;
}
.rl-container-item .summary-header{
  width: 100%;
  float: left;
  line-height: 25px;
  font-size: 17px;
  color: #555; 
}
.rl-container-item .footer{
  width: 100%;
  float: left;
  height: 45px;
  line-height: 40px;
}
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import axios from 'axios'
import Education from '../modal/CreateEducation.js'

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
      createEducationModal: Education,
      newProfile: {
        account_id: null,
        url: null
      }
    }
  },
  components: {
    'browse-images-modal': require('components/increment/generic/image/BrowseModal.vue'),
    'create-modal': require('components/increment/generic/modal/Modal.vue')
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
      this.APIRequest('educations/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    showModal(action, item = null){
      switch(action){
        case 'create':
          this.createEducationModal = {...Education}
          let inputs = this.createEducationModal.inputs
          inputs.map(input => {
            input.value = null
          })
          break
        case 'update':
          let modalData = {...this.createEducationModal}
          let parameter = {
            title: 'Update Education',
            route: 'educations/update',
            button: {
              left: 'Cancel',
              right: 'Update'
            },
            sort: {
              column: 'created_at',
              value: 'desc'
            },
            params: [{
              variable: 'id',
              value: item.id
            }]
          }
          modalData = {...modalData, ...parameter} // updated data without input values
          let selectedData = this.data.slice().find(data => data.id === item.id)
          let object = Object.keys(selectedData)
          modalData.inputs.map(data => {
            for(let obj in selectedData){
              if(obj === data.variable){
                data.value = selectedData[obj]
              }
            }
          })
          this.createEducationModal = {...modalData}
          break
      }
      $('#createEducationModal').modal('show')
    },
    removeEducation(id){
      let parameter = {
        id: id
      }
      this.APIRequest('educations/delete', parameter).then(response => {
        this.retrieve()
      })
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
