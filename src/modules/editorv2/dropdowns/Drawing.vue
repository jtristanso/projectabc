<template>
  <div class="menu-holder">
    <ul class="editor-menu">
      <li style="border-bottom: solid 1px white;">Drawing Tools</li>
      <li v-for="(item, index) in menus" :key="index" @click="select(item)">
        <i v-bind:class="item.icon" style="padding-right: 10px;" v-if="item.icon !== null"></i>
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
        title: 'Pencil',
        icon: 'fas fa-pencil-alt'
      }, {
        title: 'Pen Tool',
        icon: 'fas fa-pen-nib'
      }, {
        title: 'Bend Tool',
        icon: null
      }]
    }
  },
  methods: {
    select(item) {
      this.$emit('add', item)
    }
  }
}
</script>
