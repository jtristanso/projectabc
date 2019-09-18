<template>
  <div class="options-wrapper">
    <div class="option-item" v-for="(item, index) in menus" :key="index" @click="selectOption(item)">
      <span class="title"><b>{{item.title}}</b></span>
      <span>
        <i v-bind:class="item.icon"></i>
      </span>
      <span class="description">{{item.description}}</span>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
  .options-wrapper{
    width: 80%;
    float: left;
    min-height: 200px;
    margin-right: 10%;
    margin-left: 10%;
    margin-top: 200px;
    overflow-y: hidden;
  }

  .option-item{
    width: 23%;
    float: left;
    min-height: 200px;
    border: solid 1px $darkPrimary;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px; 
    margin-right: 1%;
    margin-left: 1%;
    background: $darkPrimary;
    color: white;
    overflow-y: hidden;
    padding: 0px 5px;
  }

  .option-item:hover{
    background: $primary;
    cursor: pointer;
    border: solid 1px $primary;
  }

  .option-item span{
    width: 100%;
    float: left;
    text-align: center;
  }

  .option-item .title{
    line-height: 40px;
    font-size: 16px;
  }
  .option-item i{
    font-size: 60px;
    padding: 10px 0px;
  }
  .option-item .description{
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 13px;
  }

  @media (max-width: 992px){
    .options-wrapper{
      width: 100%;
      margin-left: 0px;
      margin-right: 0px;
    }

    .option-item{
      width: 98%;
    }
  }

</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data () {
    return {
      menus: [{
        title: 'Find Printing',
        description: 'Do you need to talk with our printing partner? Checkout and they are waiting for you.',
        icon: 'fas fa-handshake',
        payload: 'Printing'
      }, {
        title: 'Find Designer',
        description: 'Do you need help for your design? Click and we have online designers that can  help you.',
        icon: 'fas fa-users',
        payload: 'Designers'
      }, {
        title: 'Find Templates',
        description: 'Do you need ready made template? You can buy affordable template to our marketplace.',
        icon: 'fas fa-palette',
        payload: 'Marketplace'
      }, {
        title: 'Attach file and print',
        description: 'Do you have file(s) already? Attach file and connect right away to our printing partner.',
        icon: 'fas fa-paperclip',
        payload: 'Attachments'
      }]
    }
  },
  methods: {
    selectOption(item){
      GLOBAL.template.contents.optionFlag = false
      switch(item.payload){
        case 'Marketplace':
          GLOBAL.template.contents.selectedTopMenu = 'Marketplace'
          GLOBAL.template.contents.leftPane.title = 'Marketplace'
          GLOBAL.template.contents.leftPane.index = 1
          GLOBAL.template.contents.overlay.title = null
          break
        case 'Designers':
          GLOBAL.template.contents.selectedTopMenu = 'Designers'
          GLOBAL.template.contents.leftPane.title = 'Designers'
          GLOBAL.template.contents.leftPane.index = 0
          GLOBAL.template.contents.overlay.title = null
          break
        case 'Printing':
          GLOBAL.template.contents.selectedTopMenu = 'Printing'
          GLOBAL.template.contents.leftPane.title = 'Printing'
          GLOBAL.template.contents.leftPane.index = 2
          GLOBAL.template.contents.overlay.title = null
          break
      }
    }
  }
}
</script>
