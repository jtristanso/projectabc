<template>
  <div class="content-holder" v-bind:style="position">
    <Chrome v-model="newColor" @input="pickColor()"></Chrome>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.content-holder{
  width: 80%;
}
</style>
<script>
import { Chrome } from 'vue-color'
export default{
  data () {
    return {
      newColor: '#ffffff'
    }
  },
  props: ['position'],
  components: {
    Chrome
  },
  methods: {
    pickColor(){
      this.$emit('selectedColor', this.newColor.hex)
    }
  }
}
</script>
