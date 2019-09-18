<template>
  <div class="menu-holder">
    <ul class="editor-menu">
      <li style="border-bottom: solid 1px white;">Window Settings</li>
      <li v-for="(item, index) in menus" :key="index" @click="select(item)">
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
export default{
  data () {
    return {
      menus: [{
        title: 'Text'
      }, {
        title: 'Settings'
      }, {
        title: 'Color'
      }, {
        title: 'Stroke'
      }, {
        title: 'Shadow'
      }, {
        title: 'Comments'
      }]
    }
  },
  methods: {
    select(item) {
      this.$emit('settingsEvent', item.icon)
    }
  }
}
</script>
