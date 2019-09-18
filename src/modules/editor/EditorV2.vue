<template>
  <div class="editor-v2">
    <div class="editor-header">
      <span class="pull-left">
        <i class="fa fa-bars editor-menu"></i>
        <label class="text-white" style="font-size: 18px;">
          {{title}}
        </label>
      </span>
      <span class="pull-right">
        <button class="btn btn-danger">Save</button>
        <button class="btn btn-warning">Add to cart</button>
        <i class="fa fa-phone audio-call bg-white text-primary action-link" @click="auth.triggerAudioCall()"></i>
      </span>
    </div>
    <div class="editor-tools">
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.editor-v2{
  width: 100%;
  float: left;
  height: auto;
}
.editor-header{
  width: 100%;
  float: left;
  height: 40px;
  background: $primary;
}


i{
  font-size: 28px;
  color: white;
  width: 40px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  float: left;
}

.editor-header button{
  margin-top: 2px;
  margin-right: 5px;
}

.editor-header label{
  line-height: 40px;
  margin-bottom: 0px;
  float: left;
}

.editor-menu:hover{
  background: gray;
  cursor: pointer;
}

.audio-call{
  width: 35px;
  height: 35px;
  text-align: center;
  border-radius: 50%;
  line-height: 35px;
  margin-top: 2px;
  font-size: 24px;
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
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      title: 'Test',
      auth: AUTH
    }
  },
  components: {
    'division': require('modules/editor/Div.vue'),
    'photo': require('modules/editor/Photo.vue'),
    'c-text': require('modules/editor/Text.vue'),
    'basic-text': require('modules/editor/BasicText.vue'),
    'basic-photo': require('modules/editor/BasicPhoto.vue'),
    'basic-div': require('modules/editor/BasicDiv.vue'),
    'browse-images': require('components/increment/generic/image/BrowseImages.vue')
  },
  methods: {
  }
}
</script>
