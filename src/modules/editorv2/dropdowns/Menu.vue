<template>
  <div class="menu-holder">
    <ul class="editor-menu">
      <li v-for="(item, index) in menus" :key="index" @click="select(item, index)">
        {{item.title}}
        <i class="fas fa-chevron-right pull-right" style="padding-right: 5px; line-height: 30px;" @click="show(index)" v-if="item.subMenu.length > 0"></i>
        <span class="menu-holder1" v-if="item.subMenu.length > 0 && item.show === true">
          <ul class="editor-menu">
            <li v-for="(subItem, subIndex) in item.subMenu" :key="subIndex" @click="select(subItem, index)">{{subItem.title}}</li>
          </ul>
        </span>
      </li>
    </ul>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.menu-holder{
  position: absolute;
  top: 45px;
  min-height: 50px;
  overflow-y: hidden;
  min-width: 50px;
  overflow-x: hidden;
}

.menu-holder1{
  position: absolute;
  min-height: 50px;
  overflow-y: hidden;
  width: 150px;
  left: 155px;
  z-index: 20;
}

.editor-menu{
  padding: 0px;
  margin: 0px;
  width: 150px;
  float: left;
  background: gray;
  color: white;
  list-style: none;
}
.editor-menu li{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
  padding-left: 10px;
  position: relative;
}
.editor-menu li:hover{
  color: $primary;
  cursor: pointer;
}
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
export default{
  data () {
    return {
      prevIndex: null,
      menus: [{
        title: 'Templates',
        payload: 'templates',
        show: false,
        subMenu: [{
          title: 'New Template',
          payload: 'new_template',
          subMenu: []
        }, {
          title: 'Marketplace',
          payload: 'marketplace_template',
          subMenu: []
        }]
      }, {
        title: 'Find Designer', subMenu: [], payload: 'designer'
      }, {
        title: 'Find Printing', subMenu: [], payload: 'printing'
      }, {
        title: 'Publish on marketplace', subMenu: [], payload: 'publish'
      }, {
        title: 'Export',
        payload: 'designer',
        show: false,
        subMenu: [{
          title: 'PNG',
          payload: 'export_png',
          subMenu: []
        }, {
          title: 'JPG',
          payload: 'export_jpg',
          subMenu: []
        }]
      }, {
        title: 'Print', subMenu: [], payload: 'print'
      }]
    }
  },
  methods: {
    select(item, index) {
      if(item.subMenu.length > 0){
        this.show(index)
        return
      }
      this.$emit('closed', item)
      switch(item.payload){
        case 'new_template':
          if(GLOBAL.template.contents.content === null){
            GLOBAL.template.contents.prompts = {
              title: 'New Template Setup',
              message: null,
              btn: {
                yes: 'Create',
                no: 'Cancel'
              },
              payload: 'new_template'
            }
            setTimeout(() => {
              $('#promptMessage').modal('show')
            }, 1000)
          } else {
            GLOBAL.template.contents.prompts = {
              title: 'Unsave Template',
              message: 'You have unsave work. Are you sure you want to disregard this changes?',
              btn: {
                yes: 'Yes',
                no: 'No'
              },
              payload: 'save'
            }
            setTimeout(() => {
              $('#promptMessage').modal('show')
            }, 1000)
          }
          break
        case 'marketplace_template':
          GLOBAL.template.contents.selectedTopMenu = 'Marketplace'
          GLOBAL.template.contents.leftPane.title = 'Marketplace'
          GLOBAL.template.contents.leftPane.index = 1
          GLOBAL.template.contents.overlay.title = null
          break
        case 'designer':
          GLOBAL.template.contents.selectedTopMenu = 'Designers'
          GLOBAL.template.contents.leftPane.title = 'Designers'
          GLOBAL.template.contents.leftPane.index = 0
          GLOBAL.template.contents.overlay.title = null
          break
        case 'printing':
          GLOBAL.template.contents.selectedTopMenu = 'Printing'
          GLOBAL.template.contents.leftPane.title = 'Printing'
          GLOBAL.template.contents.leftPane.index = 2
          GLOBAL.template.contents.overlay.title = null
          break
      }
    },
    addTemplate(){
      let height = 300
      let width = 500
      GLOBAL.template.contents.optionFlag = false
      GLOBAL.template.title = 'This is a test'
      GLOBAL.template.category = 'Tarpaulin'
      GLOBAL.template.status = 'personal'
      GLOBAL.template.purchased = null
      GLOBAL.template.optionFlag = false
      GLOBAL.template.contents.content = {
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
      GLOBAL.saveSetting = false
    },
    show(index){
      if(this.prevIndex === null){
        this.prevIndex = index
        this.menus[index].show = true
      }else{
        this.menus[this.prevIndex].show = false
        if(this.prevIndex !== index){
          this.menus[index].show = true
          this.prevIndex = index
        }else{
          this.prevIndex = null
        }
      }
    }
  }
}
</script>
