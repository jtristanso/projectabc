<template>
  <div class="modal fade" id="returnPolicyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="exampleModalLabel">Return Policy</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <return-policy-content></return-policy-content>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#returnPolicyModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
</style>
<script>
  import ROUTER from '../../router'
  import Vue from 'vue'
  import AUTH from '../../services/auth'
  import Chart from 'chart.js'
  export default{
    components: {
      'return-policy-content': require('../../modules/docs/ReturnPolicy.vue')
    },
    data(){
      return {
        user: AUTH.user
      }
    },
    props: {
    },
    methods: {
      redirect(parameter){
        ROUTER.push(parameter)
      }
    }
  }
</script>
