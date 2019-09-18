<template>
	<div class="page-container-holder" v-if="global.template.contents.content !== null" id="page-container-holder">
		
    <div class="page-holder" v-for="(page, pageIndex) in global.template.contents.content.pages" :key="pageIndex" v-bind:id="'page' + pageIndex">
			
      <div class="page-container" :style="{height: global.template.contents.setting.zoom.height + global.template.contents.setting.units, width: global.template.contents.setting.zoom.width + global.template.contents.setting.units, background: global.template.contents.content.style.background}">
				
        <div v-bind:style="helper.style(layer.style, global.template.contents.zoom, global.template.contents.setting, 0)" v-for="(layer, layerIndex) in page.layers" :key="layerIndex">
					<div v-bind:style="helper.style(object.style, global.template.contents.zoom, global.template.contents.setting, 1)" class="object" v-bind:class="{'selected-object': objectIndex === layer.selected_object}" v-for="(object, objectIndex) in layer.objects" :key="objectIndex" @click="selectObject(objectIndex, layer, object)">
            

            <label v-bind:style="helper.style(object.style, global.template.contents.zoom, global.template.contents.setting, 2)" @click="selectObject(objectIndex, layer, object)" draggable="true" v-on:dragstart="moveObject($event, object, true)" v-on:dragend="drag($event, object)" v-on:drag="drag($event, object)" v-if="object.type === 'text' && object.edit_flag === false" @dblclick="object.edit_flag = !object.edit_flag">
              {{object.content}}
            </label>

            <textarea v-bind:style="helper.style(object.style, global.template.contents.zoom, global.template.contents.setting, 2)" @click="selectObject(objectIndex, layer, object)" draggable="true" v-on:dragstart="moveObject($event, object, true)" v-on:dragend="drag($event, object)" v-on:drag="drag($event, object)" v-if="object.type === 'text' && object.edit_flag === true" @dblclick="object.edit_flag = !object.edit_flag"  v-model="object.content" class="input"></textarea>

            <img v-bind:style="helper.style(object.style, global.template.contents.zoom, global.template.contents.setting, 2)" @click="selectObject(objectIndex, layer, object)" draggable="true" v-on:dragstart="moveObject($event, object, true)" v-on:dragend="drag($event, object)" v-on:drag="drag($event, object)" v-if="object.type === 'image'" :src="config.BACKEND_URL + object.content"/>

            <div v-bind:style="helper.style(object.style, global.template.contents.zoom, global.template.contents.setting, 2)" @click="selectObject(objectIndex, layer, object)" draggable="true" v-on:dragstart="moveObject($event, object, true)" v-on:dragend="drag($event, object)" v-on:drag="drag($event, object)" v-if="notDiv.indexOf(object.type) < 0">
            </div>

            <!-- Resize corner -->
            <span class="resize" v-bind:class="item.class" v-bind:style="helper.resize(global.template.contents.zoom, global.template.contents.setting, item.style)" v-if="objectIndex === layer.selected_object" @mouseover="position.resize = item.section" draggable="false" v-on:dragstart="moveObject($event, object, false)" v-on:dragend="drag($event, object)" v-on:drag="drag($event, object)" v-for="(item, index) in resize" :key="'rc' + index"></span>

            <!-- Resize edge -->
            <span class="resize-edge" v-bind:class="item.class" v-bind:style="helper.resizeEdge(global.template.contents.zoom, global.template.contents.setting, object.style, item)" v-if="objectIndex === layer.selected_object" @mouseover="position.resize = item.section" draggable="false" v-on:dragstart="moveObject($event, object, false)" v-on:dragend="drag($event, object)" v-on:drag="drag($event, object)" v-for="(item, index) in resizeEdge" :key="'re' + index"></span>
          </div>
				</div>
			</div>
		</div>
	</div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.page-container-holder{
	width: 100%;
	float: left;
	height: 100%;
  overflow-y: auto;
}

.page-holder{
	width: 100%;
	float: left;
	height: 100%;	
	display: flex;
	align-items: center;
}

.page-container{
	border: solid 1px $gray;
	margin-bottom: 20px;
	margin-left: auto;
	margin-right: auto;
	position: relative;
}

.object{
	cursor: move;
  position: relative;
  border: none !important;
}

.resize{
  position: absolute;
  background: white;
}

.resize-edge{
  position: absolute;
}

.resize-top-left{
  border: solid 1px #4285F4 !important;
  cursor: nw-resize;
}

.resize-top-right{
  border: solid 1px #4285F4 !important;
  cursor: ne-resize;
}

.resize-bottom-left{
  border: solid 1px #4285F4 !important;
  cursor: sw-resize;
}

.resize-bottom-right{
  border: solid 1px #4285F4 !important;
  cursor: se-resize;
}

.re-left{
  border-left: solid 1px #4285F4 !important;
  cursor: w-resize;
}

.re-top{
  border-top: solid 1px #4285F4 !important;
  cursor: s-resize;
}

.re-right{
  border-right: solid 1px #4285F4 !important;
  cursor: w-resize;
}

.re-bottom{
  border-bottom: solid 1px #4285F4 !important;
  cursor: s-resize;
}

.object:active {
  cursor: move;
}
.selected-object{
	// border: solid 1px #4285F4 !important;
}

.input{
  border: none;
  background: transparent;
  resize: none;
  overflow-y: hidden;
}
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
import HELPER from 'src/modules/editorv2/helper.js'
import CONFIG from 'src/config.js'
export default{
  data () {
    return {
      global: GLOBAL,
      config: CONFIG,
      posX: null,
      posY: null,
      notDiv: ['text', 'image'],
      position: {
        top: null,
        left: null,
        charTop: null,
        charLeft: null,
        width: null,
        height: null,
        resize: null
      },
      helper: HELPER,
      dragFlag: false,
      resize: [{
        class: 'resize-top-left',
        style: {
          left: 0,
          top: 0
        },
        section: 'top-left'
      }, {
        class: 'resize-top-right',
        style: {
          right: 0,
          top: 0
        },
        section: 'top-right'
      }, {
        class: 'resize-bottom-left',
        style: {
          left: 0,
          bottom: 0
        },
        section: 'bottom-left'
      }, {
        class: 'resize-bottom-right',
        style: {
          right: 0,
          bottom: 0
        },
        section: 'bottom-right'
      }],
      resizeEdge: [{
        class: 're-left',
        section: 'left'
      }, {
        class: 're-top',
        section: 'top'
      }, {
        class: 're-right',
        section: 'right'
      }, {
        class: 're-bottom',
        section: 'bottom'
      }]
    }
  },
  methods: {
    selectObject(index, layer, object){
      layer.selected_object = index
      this.clickFlag = true
      GLOBAL.template.contents.selectedTopMenu = 'Object'
      GLOBAL.template.contents.activeObjectIndex = index
      GLOBAL.template.contents.objectSettings = object.style
    },
    moveObject(event, object, flag){
      this.posX = event.x
      this.posY = event.y
      this.position.top = object.style.top
      this.position.left = object.style.left
      this.position.width = object.style.width
      this.position.height = object.style.height
      this.dragFlag = flag
    },
    changePosition(x, y, object){
      this.position.top = parseInt(this.position.top)
      this.position.left = parseInt(this.position.left)
      object.style.top = (this.position.top + y)
      object.style.left = (this.position.left + x)
    },
    resizeObject(x, y, object){
      let height = object.style.height
      let width = object.style.width
      this.position.height = parseInt(this.position.height)
      this.position.width = parseInt(this.position.width)
      if(this.position.resize === 'top-left'){
        // bottom, right
        object.style.width = this.position.width + (x * -1)
        object.style.height = this.position.height + (x * -1)
        object.style.top = this.position.top + x
        object.style.left = this.position.left + x
      }else if(this.position.resize === 'top-right'){
        // bottom, left
        object.style.width = this.position.width + x
        object.style.height = this.position.height + x
        object.style.top = this.position.top + (x * -1)
      }else if(this.position.resize === 'bottom-right'){
        // top, left
        object.style.width = this.position.width + x
        object.style.height = this.position.height + x
      }else if(this.position.resize === 'bottom-left'){
        // top, right
        object.style.width = this.position.width + (x * -1)
        object.style.height = this.position.height + (x * -1)
        object.style.left = this.position.left + x
      }else if(this.position.resize === 'left'){
        object.style.width = this.position.width + (x * -1)
        object.style.left = this.position.left + x
      }else if(this.position.resize === 'top'){
        object.style.height = this.position.height + y
        object.style.top = this.position.top + (y * -1)
      }else if(this.position.resize === 'right'){
        object.style.width = this.position.width + x
      }else if(this.position.resize === 'bottom'){
        object.style.height = this.position.height + (y * -1)
      }
    },
    drag(event, object){
      let x = this.posX - event.x
      let y = this.posY - event.y
      if(this.dragFlag === true){
        this.changePosition(x * -1, y * -1, object)
      }else{
        this.resizeObject(x * -1, y * 1, object)
      }
    },
    scroll(index){
      let top = $('#page' + index).outerHeight() * index
      $('.page-container-holder').animate({
        scrollTop: parseInt(top)
      }, 500)
    }
  }
}
</script>
