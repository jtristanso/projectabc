<template>
  <div class="marketplace-wrapper">
    <div class="filter">
      <i class="fas fa-search"></i>
      <input type="text" class="form-control" placeholder="Search">
    </div>
    <span class="marketplace-item" v-bind:class="{'active': index === selected}" v-for="(item, index) in categories" :key="index" @click="makeActive(item, index)">
      <label class="title">
        {{item}}
      </label>
    </span>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.marketplace-wrapper{
  width: 100%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}

.filter{
  height: 30px;
  width: 100%;
  float: left;
  position: relative;
}

.filter .fa-search{
  position: absolute;
  line-height: 30px;
  z-index: 1;
  right: 0%;
  font-size: 14px;
  padding-right: 5px;
  color: #555;
}

.filter i:hover{
  color: $primary;
  cursor: pointer;
}
.filter .form-control{
  height: 30px !important;
  border-radius: 0px !important;
  position: absolute;
  z-index: 0;
  padding-left: 6px !important;
  font-size: 11px !important;
  width: 100% !important;
}

.marketplace-item{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
  padding: 0px 5px;
}

.marketplace-item:hover{
  cursor: pointer;
  color: $primary;
  border-bottom: solid 1px #ccc;
}

.marketplace-item .title:hover{
  cursor: pointer;
}

.marketplace-item .title{
  float: left;
}

.active{
  background: $gray;
  color: white;
}
</style>
<script>
import CONFIG from 'src/config.js'
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data () {
    return{
      categories: [
        'Tarpaulin', 'TShirt', 'Calling Cards', 'ID Cards'
      ],
      config: CONFIG,
      selected: null
    }
  },
  methods: {
    makeActive(item, index){
      GLOBAL.template.contents.overlay.title = 'marketplace'
      GLOBAL.template.contents.overlay.description = item
      GLOBAL.template.contents.overlay.payload = 'category'
      GLOBAL.template.contents.overlay.payload_value = item
      this.selected = index
    }
  }
}
</script>
