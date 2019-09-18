<template>
  <div class="phone-wrapper">
    <div class="phone-header">
      <label class="camera">
        <font-awesome-icon icon="circle"></font-awesome-icon>
      </label>
      <label class="speaker"></label>
    </div>
    <div class="phone-body">
      <HtmlContent :content="content"></HtmlContent>
    </div>
    <div class="phone-footer">
      <label class="home-btn"></label>
    </div>
  </div>
</template>
<style lang="scss" scoped>
$gray: #ccc;
.phone-wrapper{
  width: 100%;
  height: 100%;
  float: left;
  border-radius: 15px;
  background: white;
  border: solid 1px $gray;
}
.phone-holder{
  width: 100%;
  float: left;
}
.phone-footer, .phone-header{
  width: 100%;
  float: left;
  height: 10%;
}
.camera{
  float: left;
  margin-top: 18px;
  margin-left: 30%;
}
.speaker{
  height: 5px;
  width: 20%;
  background: #555;
  border-radius: 2px;
  margin-top: 25px;
  margin-left: 10%;
}

.phone-footer{
  text-align: center;
}
.home-btn{
  height: 40px;
  width: 40px;
  background: white;
  border-radius: 50%;
  margin-top: 5px;
  border: solid 2px #555;
}
.home-btn:hover{
  cursor: pointer;
  border: solid 2px gold;
}
.phone-body{
  overflow-y: auto;
  width: 98%;
  float: left;
  height: 80%;
  margin-left: 1%;
  margin-right: 1%;
  background:white;
  border: solid 2px #ccc;
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
