<template>
  <div class="editor-v2">
    <div class="editor-header">
      <span class="pull-left">
        <i class="fa fa-bars editor-menu" v-bind:class="{'gray': activeDropdown === 'mainMenu'}" @click="showDropdown('mainMenu')"></i>
        <dropdown-menu v-if="activeDropdown === 'mainMenu'" @closed="activeDropdown = null"></dropdown-menu>
      </span>
      <div v-if="global.template.contents.content !== null">
        <span class="editor-dropdown text-white" @click="showDropdown('moveScale')">
          <label>{{selectedMoveScale}}</label>
          <i class="fa fa-chevron-down"></i>
          <dropdown-movescale v-if="activeDropdown === 'moveScale'" @moveEvent="selectedMoveScale = $event"></dropdown-movescale>
        </span>
        
        <span class="editor-dropdown text-white" @click="showDropdown('zoom')">
          <label>{{selectedZoom}}%</label>
          <i class="fa fa-chevron-down"></i>
          <dropdown-zoom v-if="activeDropdown === 'zoom'" @zoomEvent="selectedZoom = $event"></dropdown-zoom>
        </span>

        <span class="editor-dropdown text-white" @click="global.addObject('text', 'Text')">
          <label style="padding: 0px 5px;">T</label>
        </span>

        <span class="editor-dropdown text-white" @click="showImages()">
          <label style="padding: 0px 5px;">
            <i class="fa fa-image"></i>
          </label>
        </span>
        <span class="editor-dropdown text-white" @click="showDropdown('frame')">
          <label style="padding: 0px 5px;">
            <i class="fas fa-dice-d6"></i>
          </label>
        </span>

        <span class="editor-dropdown text-white" @click="showDropdown('object')">
          <label>
            <i v-bind:class="selectedObject" class="text-white"></i>
          </label>
          <i class="fa fa-chevron-down"></i>
          <dropdown-object v-if="activeDropdown === 'object'" @objectEvent="selectedObject = $event"></dropdown-object>
        </span>

        <span class="editor-dropdown text-white" @click="showDropdown('drawing')">
          <label>
            <i v-bind:class="selectedDrawing" class="text-white"></i>
          </label>
          <i class="fa fa-chevron-down"></i>
          <dropdown-drawing v-if="activeDropdown === 'drawing'" @objectEvent="selectedDrawing = $event"></dropdown-drawing>
        </span>

        <span class="editor-dropdown text-white" @click="showDropdown('settings')">
          <label>
            <i class="fas fa-cog text-white"></i>
          </label>
          <i class="fa fa-chevron-down"></i>
          <dropdown-settings v-if="activeDropdown === 'settings'" @objectEvent="selectedSettings = $event"></dropdown-settings>
        </span>


        <span class="editor-dropdown text-white" @click="showDropdown('frame')">
          <label style="padding: 0px 5px;">
            <i class="fas fa-clone"></i>
          </label>
        </span>
      </div>

      <label class="text-white edit-cursor" style="font-size: 13px; padding-left: 100px;" v-if="global.template.title !== null">
        {{global.template.category}} / <b @dblclick="global.template.edit_flag = true" v-if="global.template.edit_flag === false">{{global.template.title}}</b>
        <input type="text" v-model="global.template.title" class="title-input" v-else @keyup.enter="global.template.edit_flag = false">
      </label>
      <label v-else class="text-white" style="padding-left: 10px;">
        <b>Add new template</b>
      </label>
      <span class="pull-right" v-if="global.template.contents.content !== null">
        <button class="btn btn-danger" @click="save()">Save</button>
        <button class="btn btn-warning" @click="redirect('/checkout')">Add to cart</button>
        <i class="fa fa-phone audio-call bg-white text-primary action-link" @click="auth.triggerAudioCall()"></i>
      </span>
    </div>
    <div class="editor-body">
      <editor-body v-if="global.template.contents.optionFlag === false"></editor-body>
      <overlay v-if="global.template.contents.overlay.title !== null && global.template.contents.optionFlag === false"></overlay>
      <initial-options v-if="global.template.contents.content === null && global.template.contents.optionFlag === true"></initial-options>
<!--       <color-picker :color="color" @selectedColor="color = $event"></color-picker> -->
    </div>
    <div class="screen-mode" >
      <i class="fas fa-arrows-alt-h" v-if="auth.mode === 0" @click="auth.mode = 1"></i>
      <i class="fas fa-compress" v-if="auth.mode === 1" @click="auth.mode = 0"></i>
    </div>
    <prompt-message></prompt-message>
    <images></images>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.editor-v2{
  width: 100%;
  float: left;
  height: auto;
  font-size: 11px;
}
.editor-header{
  width: 100%;
  float: left;
  height: 40px;
  background: $primary;
  position: fixed;
  z-index: 2;
}


.editor-menu{
  font-size: 16px;
  color: white;
  width: 40px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  float: left;
}

.editor-header button{
  margin-top: 5px;
  margin-right: 5px;
  height: 30px !important;
  padding-top: 5px;
  font-size: 12px;
}

.editor-header label{
  line-height: 40px;
  margin-bottom: 0px;
  float: left;
}

.editor-menu:hover, .editor-dropdown:hover, .editor-dropdown label:hover{
  background: $darkPrimary;
  cursor: pointer;
}

.audio-call{
  width: 30px;
  height: 30px;
  text-align: center;
  border-radius: 50%;
  line-height: 30px;
  margin-top: 5px;
  font-size: 16px;
  float: left;
  margin-right: 5px;
  float: left;
}

.editor-tools{
  width: 100%;
  float: left;
  height: 40px;
  border-bottom: solid 1px #ccc;
  border-top: solid 1px #ccc;
  line-height: 40px;
}
.gray{
  background: gray;
}

.editor-body{
  width: 100%;
  float: left;
  height: calc(100vh - 40px);
  background: white;
  margin-top: 40px;
  position: relative;
}

.editor-dropdown{
  height: 40px;
  float: left;
  padding-left: 10px;
  padding-right: 10px;
  line-height: 40px;
}

.editor-dropdown label{
  padding-right: 5px;
}

.screen-mode{
  position: absolute;
  height: 50px;
  width: 50px;
  bottom: 10px;
  border-radius: 50%;
  background: $primary;
  color: white;
  line-height: 50px;
  text-align: center;
}

.screen-mode i{
  line-height: 50px;
  font-size: 24px;
}

.screen-mode:hover{
  cursor: pointer;
  background: $darkPrimary;
}

.edit-cursor:hover{
  cursor: text;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import GLOBAL from 'src/modules/editorv2/global.js'
import axios from 'axios'
export default {
  mounted(){
    if(this.code !== null){
      let parameter = {
        condition: [{
          value: this.code,
          clause: '=',
          column: 'code'
        }]
      }
      GLOBAL.retrieve(parameter)
    }
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      title: 'Test',
      auth: AUTH,
      selectedZoom: 100,
      selectedMoveScale: 'Move',
      selectedObject: 'fas fa-square',
      selectedDrawing: 'fas fa-pencil-alt',
      selectedSettings: null,
      activeDropdown: null,
      global: GLOBAL,
      code: this.$route.params.code ? this.$route.params.code : null
    }
  },
  components: {
    'dropdown-menu': require('modules/editorv2/dropdowns/Menu.vue'),
    'editor-body': require('modules/editorv2/Body.vue'),
    'dropdown-zoom': require('modules/editorv2/dropdowns/Zoom.vue'),
    'dropdown-movescale': require('modules/editorv2/dropdowns/MoveScale.vue'),
    'dropdown-object': require('modules/editorv2/dropdowns/Objects.vue'),
    'dropdown-drawing': require('modules/editorv2/dropdowns/Drawing.vue'),
    'dropdown-settings': require('modules/editorv2/dropdowns/Settings'),
    'color-picker': require('modules/editorv2/colors/Picker.vue'),
    'overlay': require('modules/editorv2/overlays/RightPane.vue'),
    'prompt-message': require('modules/editorv2/prompts/Overlay.vue'),
    'initial-options': require('modules/editorv2/Options.vue'),
    'images': require('components/increment/generic/image/BrowseModal.vue')
  },
  methods: {
    redirect(parameter){
      AUTH.mode = 0
      AUTH.redirect(parameter)
    },
    showDropdown(item){
      if(item === this.activeDropdown){
        this.activeDropdown = null
      }else{
        this.activeDropdown = item
      }
    },
    showImages(){
      $('#browseImagesModal').modal('show')
    },
    save(){
      this.global.save()
    },
    manageImageUrl(url){
      GLOBAL.addObject('image', url)
    }
  }
}
</script>
