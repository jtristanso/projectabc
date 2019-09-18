<template>
  <div class="layer-holder" v-if="global.template.contents.content !== null">
    <ul class="layer-wrapper" v-if="global.template.contents.content.pages.length > 0">
      <li class="layer-item">
        <i class="fas fa-plus pull-right" @click="global.addLayer()"></i>
        <i class="fa fa-trash text-danger pull-right" @click="remove(global.template.contents.content.pages[activePageIndex].selected_layer)"></i>
        <i class="fa fa-clone text-primary pull-right" @click="duplicate()"></i>
      </li>
      <li class="layer-item" v-for="(layer, layerIndex) in global.template.contents.content.pages[activePageIndex].layers" :key="layerIndex" v-bind:class="{'active': global.template.contents.content.pages[activePageIndex].selected_layer === layerIndex && layer.show === false}" @click="makeActive(layer, layerIndex)">

        <i class="fa" v-bind:class="{'fa-eye': layer.eye === true,  'fa-eye-slash': layer.eye === false}" @click="layer.eye = !layer.eye"></i>
        
        <i class="fas" v-bind:class="{'fa-unlock': layer.locked === false,  'fa-lock': layer.locked === true}" @click="layer.locked = !layer.locked"></i>
        

        <span v-if="layer.edit_flag === false" @dblclick="layer.edit_flag = true">{{layer.title + (layerIndex + 1)}}</span>
        
        <input type="text" v-model="layer.title" v-if="layer.edit_flag === true" @keyup.enter="layer.edit_flag = false"> 

        <i class="fas fa-chevron-down pull-right" v-if="layer.show === false && layer.objects.length > 0" @click="layer.show = true, makeActiveObject(layer, layer.objects[0], 0)"></i>
        
        <i class="fas fa-chevron-up pull-right" v-if="layer.show === true && layer.objects.length > 0" @click="makeActive(layer, layerIndex), layer.show = false"></i>

        <ul v-if="layer.show === true && layer.objects.length > 0">
          <li v-for="(object, objectIndex) in layer.objects" :key="objectIndex" v-bind:class="{'active': layer.selected_object === objectIndex && global.template.contents.content.pages[activePageIndex].selected_layer === layerIndex}" @click="makeActiveObject(layer, object, objectIndex)">
            <i class="fa fa-image" v-if="object.type === 'image'"></i>
            <i class="fa fa-square" v-if="object.type === 'object'"></i>
            <i class="fa fa-paragraph" v-if="object.type === 'text'"></i>
            <span v-if="object.edit_flag === false" @dblclick="object.edit_flag = true">{{object.title}}</span>
            <input type="text" v-model="object.title"  v-if="object.edit_flag === true" @keyup.enter="object.edit_flag = false">
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
  .layer-holder{
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
    background: transparent;
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
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data () {
    return {
      global: GLOBAL,
      clickFlag: false,
      activePageIndex: GLOBAL.template.contents.activePageIndex
    }
  },
  methods: {
    remove(index){
      GLOBAL.template.contents.content.pages[GLOBAL.template.contents.activePageIndex].layers.splice(index, 1)
    },
    duplicate(index){
      let activePageIndex = GLOBAL.template.contents.activePageIndex
      let activeLayerIndex = GLOBAL.template.contents.activeLayerIndex
      if(GLOBAL.template.contents.selectedTopMenu === 'Object'){
        let index = GLOBAL.template.contents.content.pages[activePageIndex].layers[activeLayerIndex].selected_object
        let copy = JSON.parse(JSON.stringify(GLOBAL.template.contents.content.pages[activePageIndex].layers[activeLayerIndex].objects[index]))
        GLOBAL.template.contents.content.pages[activePageIndex].layers[activeLayerIndex].objects.push(copy)
      }else{
        let index = GLOBAL.template.contents.content.pages[activePageIndex].selected_layer
        let copy = JSON.parse(JSON.stringify(GLOBAL.template.contents.content.pages[activePageIndex].layers[index]))
        GLOBAL.template.contents.content.pages[activePageIndex].layers.push(copy)
      }
    },
    makeActive(item, index){
      if(this.clickFlag === false){
        GLOBAL.template.contents.content.pages[GLOBAL.template.contents.activePageIndex].selected_layer = index
        GLOBAL.template.contents.activeLayerIndex = index
        GLOBAL.template.contents.objectSettings = item.style
        GLOBAL.template.contents.selectedTopMenu = 'Layers'
      }
      this.clickFlag = false
    },
    makeActiveObject(layer, item, index){
      this.clickFlag = true
      GLOBAL.template.contents.selectedTopMenu = 'Object'
      layer.selected_object = index
      GLOBAL.template.contents.activeObjectIndex = index
      GLOBAL.template.contents.objectSettings = item.style
    }
  }
}
</script>
