<template>
  <div class="text-holder">
    <div>
      <span class="attribute-item">
      	<label>Color</label>
        <input type="text" class="form-control" v-model="color"/>
        <i v-bind:class="{'active': showColor === true}" class="fas fa-eye-dropper icon-right bordered-hover" @click="showColor = !showColor"></i>
      </span>
      <color-picker :color="color" @selectedColor="color = $event" v-if="showColor === true" :position="{right: '13%'}"></color-picker>
    </div>
    <div class="attribute-item">
    	<label>Size</label>
      <input type="number" class="form-control" style="padding-right: 0px;" />
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
  .attribute-item label{
  	position: absolute;
  	line-height: 28px;
  	z-index: 1;
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
  }

	.form-control{
		z-index: 0;
    height: 28px !important;
    font-size: 11px !important;
    border-top: none !important;
    border-left: solid 1px $gray;
    border-right: none !important;
    border-bottom: none !important;
    padding-left: 2px !important;
    padding-right: 2px !important;
    margin-top: 1px;
	}
  .attribute-item .form-control{
    position: absolute;
    width: 50%;
    right: 0px;
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
    background: $primary;
    color: white;
  }

  .attribute-double{
  	width: 100%;
  	float: left;
  	border-bottom: solid 1px $gray;
  	line-height: 28px;
  }

  .half{
  	width: 50%;
  	float: left;
  	border-right: solid 1px $gray;
  }
  .half i{
  	float: left;
  	line-height: 30px;
  	width: 30%;
  	text-align: center;
  }
  .half .form-control{
  	width: 70%;
  	float: right;
  }
</style>
<script>
export default{
  data () {
    return {
      fontStyles: ['Arial', 'Helvitica', 'Sans-serif'],
      color: '#ffffff',
      showColor: false,
      test: null
    }
  },
  components: {
    'color-picker': require('modules/editorv2/colors/Picker.vue')
  }
}
</script>
