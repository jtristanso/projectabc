<template>
	<div class="employee-holder">
    <div class="entry-viewer">
      <label v-bind:class="{'active-menu-icon': viewIcon === 'badge'}" class="menu-icons"  @click="changeViewBy('badge')">
        <i class="fas fa-id-badge"></i>
      </label>
      <label v-bind:class="{'active-menu-icon': viewIcon === 'table'}"  class="menu-icons" @click="changeViewBy('table')">
         <i class="fas fa-table"></i>
      </label>
      <create></create>
    </div>
		
    <div class="employee-list" v-if="data !==null && viewIcon === 'badge' && templates !== null">
      <div v-bind:class="{'make-active': item !== null && item.active === true}" v-for="item, index in data">
        <span v-bind:style="{height: (parseInt(templates.front.height) === config.LANDSCAPE) ? ((parseInt(templates.front.height) * 2) + 54) + 'px' : (parseInt(templates.front.height) + 54) + 'px', width: (parseInt(templates.front.height) === config.LANDSCAPE) ? (parseInt(templates.front.width) + 4)  + 'px' : ((parseInt(templates.front.width) * 2) + 4)  + 'px'}" class="holder">
          <span class="header">
            <ul class="menu">
              <li style="width: 50%;">
                <label @click="showComments(item.id)" class="option">
                  Comments
                  <span class="badge badge-danger" v-if="parseInt(item.total_comments) > 0">{{item.total_comments}}</span>
                </label>
                <div class="overlay" v-bind:class="{'first-overlay': parseInt(item.counter) === 0,'second-overlay': parseInt(item.counter) === 1,'third-overlay': parseInt(item.counter) === 2, 'fourth-overlay': parseInt(item.counter) === 3}" v-bind:id="'overlay-' + item.id">
                  <div class="header">
                    Comments
                    <i class="pull-right fa fa-close" @click="hideComments(item.id)"></i>
                  </div>
                  <div class="contents">
                    <comments :payloadValue="item.id" :payload="'profiles'" :load="false"></comments>
                  </div>
                </div>
              </li>
              <li>
                <i v-bind:class="{'gray': item.status === 'not_verified', 'green': item.status === 'verified'}" class="fas fa-check"></i>
              </li>
              <li style="border-right: 0px;">
                <div class="dropdown">
                  <label id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i>
                  </label>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <span class="dropdown-item disabled">Settings</span>
                      <span class="dropdown-item" v-if="item.status === 'verified' && item.checkout === null" @click="addToCart(item.id)">Add to Cart</span>
                      <span class="dropdown-item" v-if="item.status === 'not_verified'" @click="updateStatus('verified', item.id)">Verified</span>
                      <span class="dropdown-item" v-if="item.status === 'verified' || item.status === 'printed'" @click="updateStatus('not_verified', item.id)">Need Verification</span>
                      <span class="dropdown-item" @click="editProfile(item)">Edit Profile</span>
                      <span class="dropdown-item text-danger" @click="remove(item.id)">Delete</span>
                  </div>
                </div>
              </li>
            </ul>
          </span>

          <span v-bind:style="{height: (parseInt(templates.front.height)) + 'px', width: (parseInt(templates.front.width) * 2)  + 'px'}" class="items" v-if="parseInt(templates.front.width) === config.LANDSCAPE">
            <objects :objects="templates.front.objects" :key="item.id" v-if="templates.front !== null" :heightTemplate="parseInt(templates.front.height)" :widthTemplate="parseInt(templates.front.width)" :profile="item">
            </objects>

            <objects :objects="templates.back.objects" :key="item.id + 'b'" v-if="templates.back !== null" :heightTemplate="parseInt(templates.back.height)" :widthTemplate="parseInt(templates.back.width)" :profile="item">
            </objects>
          </span>

<!--           <span v-bind:style="{height: (parseInt(item.front_template_details.height) * 2) + 'px', width: (parseInt(item.front_template_details.width))  + 'px'}" class="items" v-if="parseInt(item.front_template_details.width) === config.PORTRAIT">
            <objects :objects="item.front_objects" :key="item.id" v-if="item.front_objects !== null" :heightTemplate="parseInt(item.front_template_details.height)" :widthTemplate="parseInt(item.front_template_details.width)">
            </objects>

            <objects :objects="item.back_objects" :key="item.id + 'b'" v-if="item.back_objects !== null" :heightTemplate="parseInt(item.front_template_details.height)" :widthTemplate="parseInt(item.front_template_details.width)">
            </objects>
          </span> -->
        </span>
      </div>
    </div>
    <div class="employee-list" v-if="data !== null && viewIcon === 'table'">
      <table class="table table-custom table-hover table-bordered table-responsive">
        <thead>
          <tr>
            <td>Email</td>
            <td>First Name</td>
            <td>Last Name</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data" @click="editProfile(item)">
            <td>
              <img :src="config.BACKEND_URL + item.profile" v-if="item.profile !== null" height="40px" width="40px" style="margin-right: 10px;border-radius: 50%; margin-top: 5px; margin-bottom: 5px;">
              <i class="fa fa-user-circle-o" style="font-size: 40px !important; line-height: 40px !important; vertical-align: middle; margin: 5px 0px;" v-if="item.profile === null"></i>
              {{item.email}}</td>
            <td>{{item.first_name}}</td>
            <td>{{item.last_name}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <edit-profile></edit-profile>
    <print></print>
    <empty v-if="data === null" :title="'Looks like you have not added an profiles to your template!'" :action="'Click the  New or Import Button to get started.'"></empty>
  </div>
</template>
<style scoped>
.employee-holder{
  width: 98%;
  float: left;
  margin-right: 2%;
}
.entry-viewer{
  width: 100%;
  float: left;
  height: 50px;
  line-height: 50px;
  border-bottom: solid 1px #ddd;
}
.entry-viewer .menu-icons{
  height: 40px;
  width: 40px;
  float: left;
  line-height: 40px;
  text-align: center;
  margin-top: 5px;
}
.menu-icons i{
  line-height: 40px;
  font-size: 20px;
}
.menu-icons:hover{
  border-radius: 50%;
  background: #ddd;
  cursor: pointer;
}
.active-menu-icon{
  border-radius: 50%;
  background: #ddd;
  cursor: pointer;
  color: #22b173;
}
.employee-list{
  width: 100%;
  float: left;
  margin-top: 25px;
}

.holder{
  float: left;
  margin-right: 25px;
  border: solid 1px #ddd;
  margin-bottom: 25px;
}
.holder:hover{
  cursor: pointer;
  border: solid 1px #22b173;
}
.make-active{
  border: solid 1px #22b173;
}
.header{
  width: 100%;
  float: left;
  min-height: 50px;
  text-align: center;
  line-height: 50px;
  border-bottom: solid 1px #ddd;
}

.header .menu{
  padding: 0px;
  margin: 0px;
  height: 50px;
  float: left;
  width: 100%;
  list-style: none;
}

.menu li{
  width: 25%;
  float: left;
  height: 50px;
  border-right: solid 1px #ddd;
}

.menu li .option{
  width: 100%;
  float: left;
  height: 50px;
  color: #22b173;
}
.menu li i{
  font-size: 15px;
}
.menu li:hover, .menu li .option{
  cursor: pointer;
}
.items{
  float: left;
}

.dropdown-menu{
  padding: 0px !important;
}

.dropdown-item{
  height: 35px !important;
  line-height: 35px !important;
  padding-top: 0px !important;
  padding-bottom: 0px !important;
}
.dropdown-item:hover{
  background: #eee;
}
.gray{
  color: #555;
}
.green{
  color: #22b173;
}
.overlay{
  position: absolute; 
  height: 350px;
  width: 600px;
  background: #fff;
  border: solid 1px #22b173 !important;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  margin-top: -350px;
  display: none;
  cursor: default;
  margin-top: 50px;
  z-index: 10;
}
.first-overlay{
  margin-left: 0px;
}
.second-overlay{
  margin-left: 0px;
}
.third-overlay{
  margin-left: -500px; 
}
.fourth-overlay{
  margin-left: -500px;
}
.overlay .header{
  height: 50px;
  width: 100%;
  float: left;
  line-height: 50px;
  background: #22b173;
  color: #fff;
}
.overlay .header i{
  color: #fff;
  padding-right: 10px;
  line-height: 50px;
}
.overlay .contents{
  overflow-y: scroll;
  height: 295px;
  width: 100%;
  float: left;
  color: #555;
}

.table-head-title{
  text-transform: capitalize;
}

.table-custom tr{
  height: 40px !important;
  line-height: 40px;
}

.table-photo{
  height: 40px;
  width: 40px;
  border-radius: 50%;
}

.table-text{
  margin-bottom: 0px;
}

.table-custom td{
  padding-top: 0px !important;
  padding-bottom: 0px !important;
}
@media (max-width: 991px){
  .employee-list td img{
    display: none;
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
      viewIcon: 'table',
      templates: null
    }
  },
  components: {
    'create': require('modules/profiles/Create.vue'),
    'edit-profile': require('modules/profiles/Update.vue'),
    'objects': require('modules/object/BadgeProfile.vue'),
    'comments': require('components/increment/generic/comment/Comments.vue'),
    'print': require('modules/print/Print.vue'),
    'empty': require('components/increment/generic/empty/Empty.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('profiles/retrieve', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data.length > 0){
          this.data = response.data
          this.templates = response.active_templates
        }else{
          this.data = null
          this.templates = null
        }
      })
    },
    changeViewBy(parameter){
      this.viewIcon = parameter
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
        }
      }
    },
    showComments(id){
      $('#overlay-' + id).css({'display': 'block'})
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === ('comment' + id)){
          this.$children[i].retrieve()
        }
      }
    },
    hideComments(id){
      $('#overlay-' + id).css({'display': 'none'})
    },
    print(item){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'printer'){
          console.log('Hi')
          this.$children[i].item = item
          this.$children[i].modal()
        }
      }
    },
    editProfile(item){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'editProfileModule'){
          this.$children[i].item = item
          this.$children[i].modal()
        }
      }
    },
    updateStatus(status, id){
      let parameter = {
        id: id,
        status: status
      }
      this.APIRequest('profiles/update', parameter).then(response => {
        if(response.data === true){
          this.retrieve()
        }
      })
    },
    addToCart(id){
      let parameter = {
        account_id: this.user.userID,
        payload: 'profile',
        payload_value: id,
        price: 0,
        qty: 1,
        type: 'cards',
        front: this.templates.front.id,
        back: this.templates.back.id
      }
      this.APIRequest('checkout_items/create', parameter).then(response => {
        if(response.data > 0){
          AUTH.checkAuthentication(null)
          this.retrieve()
        }
      })
    },
    remove(id){
      let parameter = {
        id: id
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('profiles/delete', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data > 0){
          AUTH.checkAuthentication(null)
          this.retrieve()
        }
      })
    }
  }
}
</script>
