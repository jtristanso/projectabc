<template>
  <div class="html-content-holder">
    <iframe :src="content" scrolling="no"></iframe>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.html-content-holder{
  width: 100%;
  float: left;
  height: 100%;
  overflow-y: auto;
  font-size: 90%;
}

iframe{
  width: 100%;
  float: left;
  height: 100%;
  border: 0px;
  border-bottom-right-radius: 25px;
  border-bottom-left-radius: 25px;
}

::-webkit-scrollbar {
  width: 5px;
  height: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  border-radius: 2px;
  margin-top: 20px;
  margin-bottom: 20px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: $secondary;
  border-radius: 10px;
  height: 40px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: $secondary;
}
</style>
<script>
export default {
  props: ['content']
}
</script>
