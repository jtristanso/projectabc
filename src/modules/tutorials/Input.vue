<template>
  <div>
    <h1>Input</h1>
    <input type="text" class="form-control" placeholder="Type here..." v-model="input" @change="update()">
  </div>
</template>
<style scoped>
.form-control{
  height: 50px !important;
}
</style>
<script>
export default{
  data(){
    return{
      input: this.message
    }
  },
  props: ['message'],
  methods: {
    update(){
      this.$emit('changeMessage', this.input)
    }
  }
}
</script>
