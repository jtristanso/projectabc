<template>
  <div class="menu-holder">
    <ul class="editor-menu">
      <li style="border-bottom: solid 1px white;">Zoom View</li>
      <li v-for="(item, index) in menus" :key="index" @click="select(item)">Zoom to {{item}}%</li>
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
      menus: [25, 50, 75, 100, 125, 150, 200, 250, 300]
    }
  },
  methods: {
    select(item) {
      this.$emit('zoomEvent', item)
      GLOBAL.zoomHandler(item)
    }
  }
}
</script>
