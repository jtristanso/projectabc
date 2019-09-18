<template>
  <div class="work-experience-holder">
    <span class="header">Work Experience
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
                <span class="dropdown-item action-link dropdown-label">Settings</span>
                <span class="dropdown-item action-link" @click="showModal('update', item)">Edit</span>
                <span class="dropdown-item action-link" @click="removeWork(item.id)">Remove</span>
              </div>
            </div>
            </label>
          </span>
          <span class="summary-header">
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-sitemap" style="font-size: 15px;"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px; font-weight: 600; color: #000">
                {{ item.position }}
              </span>
            </div>
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-building"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px;"> 
                {{ item.company_name }}
              </span>
            </div>
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-map-marker-alt" style="font-size: 21px;"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px;">
                {{ item.location }}
              </span>
            </div>
            <div style="line-height: 160%;">
              <label style="margin: 5px 0 0 0; color: #000;">About Work:</label>
              <div style="font-size: 14px;">
                <div v-if="item.work_description.length <= 400">
                  {{ item.work_description }}
                </div>
                <div v-else style="word-break: break-all; font-color: 555;">
                  {{ showDescription === true &&  showDescriptionIndex === index ? item.work_description : item.work_description.substring(0, 400) }}
                  <a :class="showDescription === true &&  showDescriptionIndex === index ? 'see-more clicked' : 'see-more'" @click="setShowDescription(index)">
                    {{ showDescription === true &&  showDescriptionIndex === index ? '<<<' : '>>>'}}
                  </a>
                </div>
                <!-- <div v-if="item.work_description.length >= 400" title="See more" style="margin: 5px 47%">
                  <a :class="showDescription === true && showDescriptionIndex === index ? 'arrow-icon open' : 'arrow-icon'" @click="setShowDescription(index)">
                    <span class="left-bar"></span>
                    <span class="right-bar"></span>
                  </a>
                </div> -->
                <!-- <label v-else>
                  <span v-if="item.flag === false"> {{ item.work_description.substring(0, 400)}} <strong class="text-danger" @click="item.flag = true"> TEST </strong></span>
                  <span v-if="item.flag === true"> {{ item.work_description }} <strong class="text-danger" @click="item.flag = false"> TEST </strong></span>
                </label> -->
              </div>
            </div>
          </span>
        </div>
      </span>
    </span>
    <browse-images-modal :object="user.profile" v-if="user.profile !== null"></browse-images-modal>
    <browse-images-modal :object="newWork" v-if="user.profile === null"></browse-images-modal>
    <create-modal :property="createWorkModal"></create-modal>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.dropdown-label {
  color: black !important;
  font-weight: 500 !important;
}
.dropdown-label:hover {
  color: black !important;
  background: none !important;
  cursor: auto !important
}
.see-more {
  color: red !important;
}
.clicked {
  color: $secondary !important;
}
.see-more:hover {
  cursor: pointer;
  color: $secondary !important;
}
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
import Work from '../modal/CreateWork.js'

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
      createWorkModal: Work,
      showDescription: false,
      showDescriptionIndex: null,
      selectedWorkId: null,
      newWork: null
    }
  },
  components: {
    'browse-images-modal': require('components/increment/generic/image/BrowseModal.vue'),
    'create-modal': require('components/increment/generic/modal/Modal.vue')
  },
  methods: {
    setShowDescription(index){
      if(index === this.showDescriptionIndex){
        this.showDescriptionIndex = null
        this.showDescription = false
      }else{
        this.showDescription = true
        this.showDescriptionIndex = index
      }
    },
    retrieve(params){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }],
        sort: {
          year_ended: 'desc'
        }
      }
      this.APIRequest('works/retrieve', parameter).then(response => {
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
          this.createWorkModal = {...Work}
          let inputs = this.createWorkModal.inputs
          inputs.map(input => {
            input.value = null
          })
          break
        case 'update':
          let modalData = {...this.createWorkModal}
          let parameter = {
            title: 'Update Work Experience',
            route: 'works/update',
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
          this.createWorkModal = {...modalData}
          break
      }
      $('#createWorkModal').modal('show')
    },
    removeWork(id){
      let parameter = {
        id: id
      }
      this.APIRequest('works/delete', parameter).then(response => {
        this.retrieve()
      })
    },
    showImages(){
      $('#browseImagesModal').modal('show')
    },
    hideImages(){
      $('#browseImagesModal').modal('hide')
    },
    manageImageUrl(url){
      let parameter = {
        account_id: this.user.userID,
        payload: 'work',
        payload_value: this.selectedWorkId,
        url: url
      }
      this.createCertificate(parameter)
    }
  }
}
</script>
