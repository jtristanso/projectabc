<template>
  <div class="menu-holder">
    <ul class="editor-menu">
      <li style="border-bottom: solid 1px white;">Insert Objects</li>
      <li v-for="(item, index) in menus" :key="index" @click="select(item)">
        <i v-bind:class="item.icon" style="padding-right: 10px;"></i>
        {{item.title}}
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
  width: 150px;
}
.editor-menu{
  padding: 0px;
  margin: 0px;
  width: 100%;
  float: left;
  height: auto;
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
}

i{
  width: 30px;
  text-align: center;
  color: white;
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
      menus: [{
        title: 'Square',
        icon: 'fas fa-square'
      }, {
        title: 'Circle',
        icon: 'fas fa-circle'
      }]
    }
  },
  methods: {
    select(item) {
      this.$emit('objectEvent', item.icon)
      GLOBAL.addObject(item.title, null)
    }
  }
}
</script>
