<template>
  <div class="modal" tabindex="-1" role="dialog" id="promptMessage" v-if="global.template.contents.prompts !== null">
    <div class="modal-dialog" role="document" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{global.template.contents.prompts.title}}</h5>
          <button type="button" class="close"  @click="hide()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <page-setup v-if="global.template.contents.prompts.payload === 'new_template'"></page-setup>
        <unsave-template v-if="global.template.contents.prompts.payload === 'save'"></unsave-template>
      </div>
    </div>
  </div>
</template>
<style lang="scss">
@import "~assets/style/colors.scss";
</style>
<script>
import CONFIG from 'src/config.js'
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data () {
    return {
      global: GLOBAL
    }
  },
  components: {
    'page-setup': require('modules/editorv2/prompts/TemplateSetup.vue'),
    'unsave-template': require('modules/editorv2/prompts/UnsaveTemplate.vue')
  },
  methods: {
    hide(){
      $('#promptMessage').modal('hide')
    },
    yes(){
      if(GLOBAL.template.contents.prompts.title === 'Unsave Template'){
        this.addTemplate()
      }
    },
    addTemplate(){
      let height = 300
      let width = 500
      GLOBAL.template.contents.title = 'This is a test'
      GLOBAL.template.contents.category = 'Tarpaulin'
      GLOBAL.template.contents.status = 'personal'
      GLOBAL.template.contents.purchased = null
      GLOBAL.template.contents.contents = {
        style: {
          height: height + 'px',
          width: width + 'px',
          background: '#ffffff'
        },
        pages: [],
        plugins: [],
        selected_page: null,
        selected_plugin: null
      }
      GLOBAL.template.contents.setting.page = {
        height: height,
        width: width
      }
      GLOBAL.template.contents.setting.zoom = {
        height: height,
        width: width
      }
      this.hide()
    }
  }
}
</script>
