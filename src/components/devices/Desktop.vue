<template>
  <div class="desktop-wrapper">
    <div class="desktop-monitor">
      <HtmlContent :content="content"></HtmlContent>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~@/styles/colors.scss";
.desktop-wrapper{
  width: 100%;
  height: 100%;
  float: left;
  border-radius: 10px;
  background: black;
  position: relative;
}

.desktop-monitor{
  width: 94%;
  height: 90%;
  margin-left: 3%;
  margin-right: 3%;
  margin-top: 15px;
  background: white;
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
