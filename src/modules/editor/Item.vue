<template>
  <div>
    <div v-bind:class="{'make-active': item !== null && item.active === true}" v-if="item !== null" v-on:click="makeActive()" v-bind:style="{height: (parseInt(item.height) + 90) + 'px', width: (parseInt(item.width) + 1)  + 'px'}" class="item">
      <div class="holder">
        <div class="ribbon-wrapper">
          <div class="ribbon bg-warning" v-if="item.settings === 'front' && item.active_templates !== null">Front</div>
          <div class="ribbon bg-danger" v-if="item.settings === 'back' && item.active_templates !== null">Back</div>
        </div>
        <span v-bind:class="{'make-active-header': item.active === true}" class="header">
          <b>
            {{item.title}}
          </b>
        </span>
        <span v-bind:style="{height: parseInt(item.height) + 'px', width: (parseInt(item.width) + 1)  + 'px'}" class="body">
          <div v-bind:style="{height: parseInt(item.height) + 'px', width: (parseInt(item.width) + 1)  + 'px'}" class="preview">
            <objects :objects="item.objects" :heightTemplate="parseInt(item.height)" :widthTemplate="parseInt(item.width)" v-if="item.objects !== null"></objects>
          </div>
          <ul>
            <li @click="openEditor(item.code)" style="border-left: 0px;">Editor</li>
            <li>
              <div class="dropdown">
                <label id="dropdownMenuSettingsButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Settings
                </label>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuSettingsButton">
                  <span class="dropdown-item disabled">Settings</span>
                  <span class="dropdown-item" v-on:click="show(item, 'guideModal')" v-if="user.type === 'ADMIN'">Edit Guide</span>
                  <!-- <span class="dropdown-item" v-on:click="show(item, 'editSettings')">Edit Settings</span> -->
                  <span class="dropdown-item" v-on:click="show(item, 'updateSettings')" v-if="user.type === 'ADMIN'">Update</span>
                  <span class="dropdown-item" v-on:click="show(item, 'guideViewModal')" v-if="item.guide !== null">View Guide</span>
                  <span class="dropdown-item" v-on:click="setAsActive(item)" v-if="item.active_templates === null">Set as Active</span>
                  <span class="dropdown-item text-danger" v-on:click="show(item, 'deleteModal')" v-if="item.status !== 'purchased'">Delete</span>
                </div>
              </div>
            </li>
          </ul>
        </span>
      </div>
    </div>
    <delete-modal></delete-modal>
    <update></update>
    <editor></editor>
    <guide-modal></guide-modal>
    <guide-view></guide-view>
    <edit-setting></edit-setting>
  </div>
</template>
<style scoped>
.item{
  float: left;
  border: solid 1px #ddd;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  margin-right: 25px;
  margin-bottom: 25px;
}
.item:hover{
  cursor: pointer;
  border: solid 1px #22b173;
}
.holder{
  width: 100%;
  height: 100%;
  position: relative;
  margin-top: 0px !important;
}

.ribbon-wrapper {
  width: 85px;
  height: 88px;
  overflow: hidden;
  position: absolute;
  top: -3px;
  left: -3px;
  z-index: 30;
}

.ribbon-wrapper .ribbon {
  font: bold 15px sans-serif;
  color: #333;
  text-align: center;
  -webkit-transform: rotate(-45deg);
  -moz-transform:    rotate(-45deg);
  -ms-transform:     rotate(-45deg);
  -o-transform:      rotate(-45deg);
  position: relative;
  padding: 7px 0;
  top: 15px;
  left: -30px;
  width: 120px;
  color: #fff;
}

.make-active{
  border: solid 1px #22b173;
}
.header{
  width: 100%;
  float: left;
  height: 50px;
  text-align: center;
  line-height: 50px;
  position: relative;
  z-index: 20;
  border-bottom: solid 1px #ddd;
}
.make-active-header{
  background: #22b173;
  color: #fff;
}
.dropdown-menu{
  padding: 0px !important;
  margin-top: -145px !important;
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
.disabled:hover{
  background: #fff !important;
  cursor: default;
}
.body{
  float: left;
  position: relative;
}
ul{
  padding: 0px;
  margin: 0px;
  width: 100%;
  float: left;
  position: relative;
  z-index: 1000;
  list-style: none;
  bottom: 0;
  height: 40px;
  background: #22b173;
  transition: 1s;
}
ul li{
  width: 50%;
  float: left;
  height: 40px;
  text-align: center;
  line-height: 40px;
  border-left: solid 1px #028170;
  color: #fff;
}
ul li:hover{
  cursor: pointer;
  background: #028170;
}
#dropdownMenuSettingsButton{
  width: 100%;
}
#dropdownMenuSettingsButton:hover{
  cursor: pointer;
}
@media (max-width: 991px){
  .item{
    right: 0;
    left: 0;
    margin-right: auto;
    margin-left: auto;
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
  components: {
    'update': require('modules/editor/Update.vue'),
    'editor': require('modules/editor/Editor.vue'),
    'objects': require('modules/object/Objects.vue'),
    'delete-modal': require('modules/Editor/Delete.vue'),
    'guide-modal': require('modules/Editor/Guide.vue'),
    'guide-view': require('modules/Editor/ViewGuide.vue'),
    'edit-setting': require('modules/Editor/EditSetting.vue')
  },
  props: ['item', 'index'],
  methods: {
    makeActive(){
      this.$parent.makeActive(this.index)
    },
    openEditor(code){
      AUTH.mode = 1
      this.redirect('editor/v2/' + code)
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(parameter){
      this.$parent.retrieve((parameter === true) ? this.index : false)
    },
    setAsActive(item){
      let parameter = null
      if(item.settings === 'front'){
        parameter = {
          account_id: this.user.userID,
          front: item.id,
          settings: 'front'
        }
      }else{
        parameter = {
          account_id: this.user.userID,
          back: item.id,
          settings: 'back'
        }
      }
      this.APIRequest('active_templates/create', parameter).then(response => {
        this.retrieve(this.index)
      })
    },
    show(item, id){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === id){
          if(id === 'editor'){
            this.$children[i].item = item
            this.$children[i].retrieve()
            setTimeout(() => {
              $('#templateEditorModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
              })
            }, 50)
          }else if(id === 'updateSettings'){
            this.$children[i].size = (parseInt(item.width) === 204) ? 'portrait' : 'landscape'
            this.$children[i].item = item
            setTimeout(() => {
              $('#updateTemplateModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
              })
            }, 50)
          }else if(id === 'deleteModal'){
            this.$children[i].id = item.id
            setTimeout(() => {
              $('#deleteTemplateModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
              })
            }, 50)
          }else if(id === 'guideModal'){
            this.$children[i].item = item
            setTimeout(() => {
              $('#createGuideModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
              })
            }, 50)
          }else if(id === 'guideViewModal'){
            this.$children[i].item = item
            setTimeout(() => {
              $('#viewGuideModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
              })
            }, 50)
          }else if(id === 'editSettings'){
            this.$children[i].item = item
            setTimeout(() => {
              $('#editSettingsModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
              })
            }, 50)
          }
        }
      }
    }
  }
}
</script>
