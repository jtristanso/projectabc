<template>
	<div class="body">
    <landing-steps></landing-steps>
    <landing-editor></landing-editor>
    <landing-bizmarketplace></landing-bizmarketplace>
    <landing-mc></landing-mc>
    <landing-filemanagement></landing-filemanagement>
	</div>
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  components: {
    'landing-editor': require('modules/home/Landing/Editor.vue'),
    'landing-bizmarketplace': require('modules/home/Landing/BizMarketplace.vue'),
    'landing-steps': require('modules/home/Landing/Steps.vue'),
    'landing-features': require('modules/home/Landing/Features.vue'),
    'landing-mc': require('modules/home/Landing/MessageAndComment.vue'),
    'landing-filemanagement': require('modules/home/Landing/FileManagement.vue')
  },
  mounted(){
  },
  data(){
    return {
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
<style scoped>
.body{
	margin: 0px;
}
</style>
