<template>
  <div class="pages-holder" v-if="global.template.contents.content !== null">
    <ul class="pages-wrapper">
      <li class="pages-item">
        <i class="fas fa-plus pull-right" @click="global.addPage()"></i>
        <i class="fa fa-trash text-danger pull-right"></i>
        <i class="fa fa-clone text-primary pull-right" @click="copy()"></i>
      </li>
      <li class="pages-item" v-for="(item, index) in global.template.contents.content.pages" :key="index" @click="makeActive(item, index)" v-bind:class="{'active': global.template.contents.content.selected_page === index}">
        <i class="fa" v-bind:class="{'fa-eye': item.eye === true,  'fa-eye-slash': item.eye === false}" @click="item.eye = !item.eye"></i>
        <i class="fas" v-bind:class="{'fa-unlock': item.locked === false,  'fa-lock': item.locked === true}" @click="item.locked = !item.locked"></i>
        <span>{{item.title + ' ' + (index + 1)}}</span>
      </li>
    </ul>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
  .pages-holder{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
  }

  ul{
    width: 100%;
    float: left;
    min-height: 50px;
    padding: 0px;
    margin: 0px;
    overflow-y: hidden;
  }

  ul li{
    width: 100%;
    float: left;
    min-height: 30px;
    line-height: 30px;
    padding-left: 5px;
    color: black;
    overflow-y: hidden;
  }

  ul li i{
    color: black;
    padding-right: 5px;
  }

  ul li:hover{
    cursor: pointer;
    border-bottom: solid 1px $secondary;
  }

  input{
    border: none;
    height: 30px;
  }

  .pull-right{
    line-height: 30px;
  }

  .active{
    background: $gray;
    color: white;
  }
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import axios from 'axios'
import GLOBAL from 'src/modules/editorv2/global.js'
import HELPER from 'src/modules/editorv2/helper.js'
export default {
  data(){
    return {
      global: GLOBAL
    }
  },
  methods: {
    makeActive(item, index){
      GLOBAL.template.contents.content.selected_page = index
      GLOBAL.template.contents.activePageIndex = index
      GLOBAL.template.contents.objectSettings = item.style
      this.$emit('scrollEvent', index)
    },
    copy(index){
      let copy = JSON.parse(JSON.stringify(GLOBAL.template.contents.content.pages[GLOBAL.template.contents.content.selected_page]))
      GLOBAL.template.contents.content.pages.push(copy)
    }
  }
}
</script>
