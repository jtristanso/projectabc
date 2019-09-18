<template>
  <div class="incre-row">
    <label class="title"><b>Work Experiences</b></label>
    <div class="incre-row">
      <table class="table borderless">
        <tbody>
          <tr>
            <td>Total Borrowed</td>
            <td>PHP {{item.total.toFixed(2)}}</td>
          </tr>
          <tr>
            <td>Ratings</td>
            <td>
              <ratings :ratings="item.rating" v-if="item.rating !== null"></ratings>
            </td>
          </tr>
          <tr>
            <td>Email Address</td>
            <td><i class="fa fa-check text-primary"></i>{{item.account.email}}</td>
          </tr>
          <tr>
            <td>Contact Number</td>
            <td><i class="fa fa-check text-primary"></i>{{item.account.information.cellular_number}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<style scoped>
.incre-row .title{
  width: 100%;
  float: left;
  height: 50px;
  line-height: 50px;
  color: #555;
  border-top: solid 1px #ddd;
  border-bottom: solid 1px #ddd;
}

.borderless td, .borderless th {
    border: none;
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
      config: CONFIG
    }
  },
  components: {
    'ratings': require('components/increment/generic/rating/DirectRatings.vue')
  },
  props: ['item'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
