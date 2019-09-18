<template>
  <div class="profile-wrapper">
    <div class="header">
      {{global.template.contents.overlay.description}}
      <i class="fa fa-phone pull-right" @click="auth.triggerAudioCall(2, global.template.contents.overlay.payload_value)"></i>
      <i class="fas fa-envelope pull-right"  @click="redirect('/messenger/' + global.template.contents.overlay.description)"></i>
    </div>
    <div class="gallery">
      <div class="gallery-item" v-for="(item) in 5" :key="item"></div>
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.profile-wrapper{
  width: 100%;
  float: left;
  height: 100%;
}

.header{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
  padding: 0px 10px;
}

.header .fa-phone{
  text-align: center;
  height: 26px;
  width: 26px;
  border-radius: 50%;
  text-align: center;
  background: $primary;
  color: white;
  font-size: 14px;
  line-height: 26px;
  margin-top: 2px;
}

.header .fa-envelope{
  text-align: center;
  height: 26px;
  width: 26px;
  border-radius: 50%;
  text-align: center;
  background: $warning;
  color: white;
  font-size: 14px;
  line-height: 26px;
  margin-top: 2px;
}

.gallery{
  width: 100%;
  height: calc(100% - 30px);
  overflow-y: auto;
}

.gallery-item{
  width: 100%;
  height: 150px;
  border-top: solid 1px $gray;
}
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
export default {
  mounted () {
    // this.retrieve()
  },
  data () {
    return {
      global: GLOBAL,
      data: null,
      auth: AUTH
    }
  },
  methods: {
    redirect(params){
      this.auth.mode = 0
      ROUTER.push(params)
    },
    retrieve () {
      let parameter = {
        condition: [{
          column: 'account_id',
          value: this.global.overlay.payload_value,
          clause: '='
        }]
      }
      this.APIRequest('accounts/retrieve', parameter).then(response => {
        if(response.data !== null){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    }
  }
}
</script>
