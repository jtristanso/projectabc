<template>
  <div class="phone-wrapper">
    <label class="speaker"></label>
    <div class="phone-body">
      <HtmlContent :content="content"></HtmlContent>
    </div>
    <label class="home-swipe"></label>
  </div>
</template>
<style lang="scss" scoped>
$gray: #ccc;
.phone-wrapper{
  width: 100%;
  height: 100%;
  float: left;
  border-radius: 20px;
  background: black;
  position: relative;
}

.phone-body{
  width: 96%;
  height: 97%;
  margin: 2%;
  background:white;
  border-radius: 20px;
  padding-top: 25px;
}
.speaker{
  background: black;
  height: 25px;
  width: 60%;
  margin-left: 20%;
  position: absolute;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
}
.home-swipe{
  height: 5px;
  width: 30%;
  bottom: 10px;
  background: #555;
  border-radius: 2px;
  position: absolute;
  right: 35%;
}

</style>
<script>
import HtmlContent from '@/components/devices/Content.vue'
export default {
  props: ['content'],
  components: {
    HtmlContent
  }
}
</script>
