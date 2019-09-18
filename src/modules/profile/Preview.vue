<template>
  <div class="profile-preview-wrapper" v-if="item !== null">
    <profile-header :item="item" v-if="item.account !== null"></profile-header>
    <basic :item="item" v-if="item.account !== null"></basic>
    <educations :item="item" v-if="item.account !== null"></educations>
    <works :item="item" v-if="item.account !== null"></works>
    <ids :item="item" v-if="item.account !== null"></ids>
    <reviews :item="item" v-if="item.account !== null"></reviews>
  </div>
</template>
<style scoped>
.profile-preview-wrapper{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
}
@media (max-width: 992px){
}

</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
export default{
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      data: null
    }
  },
  props: ['item'],
  components: {
    'profile-header': require('modules/profile/Header.vue'),
    'basic': require('modules/profile/Basic.vue'),
    'works': require('modules/profile/Works.vue'),
    'ids': require('modules/profile/Ids.vue'),
    'reviews': require('modules/profile/Reviews.vue'),
    'educations': require('modules/profile/Educations.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }

}
</script>
