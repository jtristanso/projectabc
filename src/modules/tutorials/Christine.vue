<template>
  <div>
    christine here...
  <button class="btn btn-primary" @click="showAudio">Call</button>
  </div>
</template>
<style>

</style>
<script>
import AUTH from 'src/services/auth'
export default {
  methods: {
    showAudio(){
      AUTH.triggerAudioCall(2, 2)
    }
  }
}
</script>
