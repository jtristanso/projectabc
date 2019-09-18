<template>
  <div class="text-holder">
    <div class="attribute-item">
      <i class="fas fa-font"></i>
      <select class="form-control" v-model="property.fontFamily">
        <option v-for="(item, index) in fontFamily" :key="index">  {{item}}
        </option>
      </select>
    </div>
    <div>
      <span class="attribute-item">
        <i class="fas fa-palette"></i>
        <input type="text" class="form-control" v-model="property.color"/>
        <i v-bind:class="{'active': showColor === true}" class="fas fa-eye-dropper icon-right bordered-hover" @click="showColor = !showColor"></i>
      </span>
      <color-picker :color="color" @selectedColor="setColor($event)" v-if="showColor === true" :position="{right: '13%'}"></color-picker>
    </div>
    <div class="attribute-multiple">
      <i class="fas fa-bold bordered-hover" @click="bold()" v-bind:class="{'active': property.fontWeight === 'bold'}"></i>
      <i class="fas fa-italic bordered-hover" v-bind:class="{'active': property.fontStyle === 'italic'}" @click="fontStyle()"></i>
      <label style="text-decoration: inital" class="bordered-hover" v-bind:class="{'active': property.textDecoration === 'initial'}" @click="property.textDecoration = 'initial'">T</label>
      <label style="text-decoration: underline" class="bordered-hover" v-bind:class="{'active': property.textDecoration === 'underline'}" @click="property.textDecoration = 'underline'">T</label>
      <label style="text-decoration: line-through" class="bordered-hover" v-bind:class="{'active': property.textDecoration === 'line-through'}" @click="property.textDecoration = 'line-through'">T</label>
      <label style="text-decoration: overline" class="bordered-hover" v-bind:class="{'active': property.textDecoration === 'overline'}" @click="property.textDecoration = 'overline'">T</label>
    </div>
    <div class="attribute-multiple">
      <i class="fas fa-align-left bordered-hover" v-bind:class="{'active': property.textAlign === 'left'}" @click="property.textAlign = 'left'"></i>
      <i class="fas fa-align-center bordered-hover" v-bind:class="{'active': property.textAlign === 'center'}" @click="property.textAlign = 'center'"></i>
      <i class="fas fa-align-right bordered-hover" v-bind:class="{'active': property.textAlign === 'right'}" @click="property.textAlign = 'right'"></i>
      <i class="fas fa-align-justify bordered-hover" v-bind:class="{'active': property.textAlign === 'justify'}" @click="property.textAlign = 'justify'"></i>
      <i class="fas fa-indent bordered-hover" v-bind:class="{'active': property.padding === '10px'}" @click="property.padding = '10px'"></i>
      <i class="fas fa-outdent bordered-hover" v-bind:class="{'active': property.padding === '0px'}" @click="property.padding = '0px'"></i>
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
  .text-holder{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
    margin-bottom: 30px;
  }
  .attribute-item{
    width: 100%;
    position: relative;
    float: left;
    height: 30px;
    border-bottom: solid 1px $gray;
  }
  .attribute-item i{
    width: 30px;
    position: absolute;
    z-index: 1;
    line-height: 28px;
    padding-left: 5px;
  }

  .attribute-item .icon-right{
    right: 0px;
    text-align: center;
  }

  .attribute-item .form-control{
    position: absolute;
    z-index: 0;
    height: 28px !important;
    font-size: 11px !important;
    padding-left: 35px !important;
    border: none !important;
  }

  .attribute-multiple{
    width: 100%;
    float: left;
    height: 30px;
    line-height: 30px;
    border-bottom: solid 1px $gray;
  }

  .attribute-multiple i,  .attribute-multiple label{
    width: 16%;
    height: 30px;
    border-radius: 2px;
    line-height: 30px;
    text-align: center;
    float: left;
    font-weight: 700;
  }

  .bordered-hover:hover{
    background: $primary;
    color: white;
    cursor: pointer;
  }
  .active{
    color: $primary;
  }
</style>
<script>
export default{
  data () {
    return {
      fontFamily: ['Arial', 'Helvitica', 'Sans-serif'],
      color: '#ffffff',
      showColor: false
    }
  },
  props: ['property'],
  components: {
    'color-picker': require('modules/editorv2/colors/Picker.vue')
  },
  methods: {
    setColor(color){
      this.property.color = color
    },
    bold(){
      if(this.property.hasOwnProperty('fontWeight')){
        if(this.property.fontWeight === 'normal'){
          this.property['fontWeight'] = 'bold'
        }else{
          this.property['fontWeight'] = 'normal'
        }
      }else{
        this.property['fontWeight'] = 'normal'
      }
    },
    fontStyle(){
      if(this.property.fontStyle === 'normal'){
        this.property.fontStyle = 'italic'
      }else{
        this.property.fontStyle = 'normal'
      }
    }
  }
}
</script>
