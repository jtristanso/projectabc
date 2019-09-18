<template>
  <div>
    <div class="modal-body">
      <div class="form-group col-lg-12" style="float: left;">
        <label>Title</label>
        <input type="text" class="form-control" placeholder="Enter title of template" v-model="newTemplate.title">
      </div>
      <div class="form-group col-lg-12" style="float: left;">
        <label>Category</label>
        <select class="form-control" v-model="newTemplate.category">
          <option v-for="(item, index) in categories" :key="index" :value="item">{{item}}</option>
        </select>
      </div>
      <div class="form-group col-lg-6" style="float: left;">
        <label>Width</label>
        <input type="number" class="form-control" v-model="newTemplate.width">
        <!-- <small id="emailHelp" class="form-text text-muted">Pixel</small> -->
      </div>
      <div class="form-group col-lg-6" style="float: left;">
        <label>Height</label>
        <input type="number" class="form-control" v-model="newTemplate.height">
        <!-- <small id="emailHelp" class="form-text text-muted">Pixel</small> -->
      </div>

      <div class="form-group col-lg-6" style="float: left;">
        <label>Units</label>
        <select class="form-control" v-model="newTemplate.units">
          <option value="px">Pixel</option>
          <option value="in">Inches</option>
        </select>
        <!-- <small id="emailHelp" class="form-text text-muted">Pixel</small> -->
      </div>
      <div class="form-group col-lg-6" style="float: left;">
        <label style="floatl: left">Background Color</label>
        <div class="input-group">
          <div class="input-group-prepend" @click="colorFlag = !colorFlag">
            <div class="input-group-text">
              <i class="fas fa-eye-dropper"></i>
            </div>
          </div>
          <input type="text" class="form-control" id="inlineFormInputGroup" v-model="newTemplate.background">
        </div>
        <color-picker :color="newTemplate.background" @selectedColor="setColor($event)" :position="{right: '100%', top: '-200px'}" v-if="colorFlag === true"></color-picker>
        <!-- <small id="emailHelp" class="form-text text-muted">Pixel</small> -->
      </div>
    </div>
    <div class="modal-footer" style="margin-top: 5px;">
      <button type="button" class="btn btn-danger" @click="hide()">{{global.template.contents.prompts.btn.no}}</button>
      <button type="button" class="btn btn-primary" @click="yes()">{{global.template.contents.prompts.btn.yes}}</button>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.form-control, .btn{
  font-size: 11px !important;
}

.btn{
  height: 30px !important;
}

.input-group-prepend{
  line-height: 30px !important;
  padding: 0px 10px;
  border-top: solid 1px #ccc !important;
  border-bottom: solid 1px #ccc !important;
  border-left: solid 1px #ccc !important;
  border-top-left-radius: 3px !important;
  border-bottom-left-radius: 3px !important;
}

.input-group-prepend:hover{
  cursor: pointer !important;
}

.modal-footer{
  border-top: none !important;
}
</style>
<script>
import CONFIG from 'src/config.js'
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data () {
    return {
      global: GLOBAL,
      categories: ['Tarpaulin', 'Tshirt'],
      colorFlag: false,
      newTemplate: {
        title: null,
        category: 'Tarpaulin',
        status: 'personal',
        purchased: null,
        width: 500,
        height: 300,
        units: 'px',
        background: '#ffffff'
      }
    }
  },
  components: {
    'color-picker': require('modules/editorv2/colors/Picker.vue')
  },
  methods: {
    hide(){
      $('#promptMessage').modal('hide')
    },
    yes(){
      if(GLOBAL.template.contents.prompts.payload === 'new_template'){
        this.addTemplate()
      }
    },
    setColor(color){
      this.newTemplate.background = color
    },
    addTemplate(){
      let height = parseInt(this.newTemplate.height)
      let width = parseInt(this.newTemplate.width)
      GLOBAL.template.contents.optionFlag = false
      GLOBAL.template.title = this.newTemplate.title
      GLOBAL.template.category = this.newTemplate.category
      GLOBAL.template.status = this.newTemplate.status
      GLOBAL.template.purchased = this.newTemplate.purchased
      GLOBAL.template.optionFlag = false
      GLOBAL.template.contents.content = {
        style: {
          height: height,
          width: width,
          background: this.newTemplate.background
        },
        pages: [],
        plugins: [],
        selected_page: null,
        selected_plugin: null
      }
      GLOBAL.template.contents.setting.units = this.newTemplate.units
      GLOBAL.template.contents.setting.actual = {
        height: height,
        width: width
      }
      GLOBAL.template.contents.setting.page = {
        height: height,
        width: width
      }
      GLOBAL.template.contents.setting.zoom = {
        height: height,
        width: width
      }
      GLOBAL.saveSetting = false
      GLOBAL.addPage()
      this.hide()
    }
  }
}
</script>
