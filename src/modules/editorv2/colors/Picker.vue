<template>
  <div class="content-holder" v-bind:style="position">
    <Sketch v-model="newColor" @input="pickColor()"></Sketch>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.content-holder{
  position: absolute;
  min-height: 50px;
  overflow-y: hidden;
  width: 225px;
  z-index: 1000;
}
</style>
<script>
import { Sketch } from 'vue-color'
export default{
  data () {
    return {
      newColor: '#ffffff'
    }
  },
  props: ['position'],
  components: {
    Sketch
  },
  methods: {
    pickColor(){
      this.$emit('selectedColor', this.newColor.hex)
    }
  }
}
</script>
