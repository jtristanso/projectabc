<template>
  <div class="right-page-holder">
    <div class="filter">
      <i class="fas fa-search"></i>
      <input type="text" class="form-control" placeholder="Search">
      <i class="fas fa-close" @click="global.template.contents.overlay.title = null"></i>
    </div>
    <div class="result-holder">
      <profile v-if="global.template.contents.overlay.title === 'designer'"></profile>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.right-page-holder{
  width: 20%;
  position: fixed;
  height: calc(100vh - 40px);
  background: white;
  border-right: solid 1px $gray; 
  z-index: 0;
  left: 12%;
}
.filter{
  height: 40px;
  width: 100%;
  float: left;
  position: relative;
}
.filter .fa-search{
  position: absolute;
  line-height: 40px;
  z-index: 1;
  right: 10%;
  font-size: 16px;
  padding-right: 5px;
  color: #555;
}

.filter .fa-close{
  position: absolute;
  line-height: 40px;
  z-index: 1;
  right: 0%;
  font-size: 16px;
  padding-right: 10px;
  color: #555; 
}

.filter i:hover{
  color: $primary;
  cursor: pointer;
}
.filter .form-control{
  height: 40px !important;
  border-radius: 0px !important;
  position: absolute;
  z-index: 0;
  padding-left: 6px !important;
  font-size: 11px !important;
  border-top: 0px !important;
  border-left: 0px !important;
  border-right: 0px !important;
  border-bottom: 0px !important;
  width: 90% !important;
}

.result-holder{
  width: 100%;
  float: left;
  height: calc(100% - 40px);
  overflow-y: auto;
}

</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data () {
    return {
      global: GLOBAL
    }
  },
  components: {
    'profile': require('modules/editorv2/overlays/Profile.vue')
  }
}
</script>
