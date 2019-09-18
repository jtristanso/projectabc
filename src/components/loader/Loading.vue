<template>
  <div>
    <div class="customModal" id="loading">
      <span class="loading">
        <i class="fas fa-circle-o-notch fa-spin"></i>
      </span>
    </div>
  </div>
</template>
<script>
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.customModal{
  position: fixed;
  background: rgba(254, 254, 254, 0);
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 100000 !important;
  -webkit-transition: all 0.1s;
  -moz-transition: all 0.1s;
  transition: all 0.1s;
  text-align: center;
  display: none;
}
.customModal .loading{
  font-size: 75px;
  margin-top: 20vh;
  height: 35vh;
  float: left;
  width: 20%;
  margin-left: 40%;
  margin-right: 40%;
  text-align: center;
  color: $primary;
  line-height: 30vh;
  border-radius: 5px;
}
.fa-spin{
  animation-duration: 0.50s;
}
</style>
