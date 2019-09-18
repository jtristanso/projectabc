<template>
  <div class="holder">
    <div class="filter">
      <i class="fa fa-search"></i>
      <input type="text" placeholder="Search" class="form-control">
      <i class="fas fa-plus pull-right bordered-hover" @click="showImages()"></i>
    </div>
    <browse-image></browse-image>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
  .holder{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
  }
  .filter{
    width: 100%;
    float: left;
    height: 40px;
    position: relative;
  }
  .filter i{
    position: absolute;
    line-height: 30px;
    z-index: 1;
    text-align: center;
    width: 30px;
    font-size: 13px;
  }

  .filter .form-control{
    position: absolute;
    z-index: 0;
    font-size: 11px !important;
    padding-left: 25px;
    border: none;
  }
  .pull-right{
    line-height: 30px;
    right: 5px;
    border-radius: 2px;
  }

  .bordered-hover:hover{
    background: $primary;
    color: white;
    cursor: pointer;
  }
</style>
<script>
export default {
  components: {
    'browse-image': require('components/increment/generic/image/BrowseModal.vue')
  },
  methods: {
    showImages(){
      $('#browseImagesModal').modal('show')
    },
    manageImageUrl(url){
      console.log(url)
    }
  }
}
</script>
