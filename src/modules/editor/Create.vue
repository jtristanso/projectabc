<template>
  <div>
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createTemplateModal"><i class="fa fa-plus"></i> New Template</button>
    <div class="modal fade" id="createTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">New Template</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
            
          </div>
          <div class="modal-body">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <div class="form-group">
              <label for="exampleInputEmail1">Title</label>
              <input type="text" class="form-control" placeholder="Type title here..." v-model="title">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Additional Details</label>
              <select class="form-control" v-model="settings">
                <option value="front">Front</option>
                <option value="back">Back</option>
              </select>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Size</label>
              <select class="form-control" v-model="size">
                <option value="portrait">3.375" x 2.125" Portrait</option>
                <option value="landscape">2.125" x 3.375" Landscape</option>
              </select>
            </div>

            <div class="form-group" v-if="user.type === 'ADMIN'">
              <label for="exampleInputEmail1">Status</label>
              <select class="form-control" v-model="status">
                <option value="personal">Personal</option>
                <option value="marketplace">Marketplace</option>
              </select>
            </div>

            <div class="form-group" v-if="user.type === 'ADMIN'">
              <label for="exampleInputEmail1">Category</label>
              <select class="form-control" v-model="category">
                <option value="office">Office</option>
                <option value="school">School</option>
              </select>
            </div>

            <div class="form-group" v-if="user.type === 'ADMIN'">
              <label for="exampleInputEmail1">Price</label>
              <input type="text" class="form-control" placeholder="PHP 0.00" v-model="price">
            </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#createTemplateModal">Cancel</button>
              <button type="button" class="btn btn-primary" @click="submit()">Submit</button>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      title: null,
      settings: null,
      size: null,
      status: 'personal',
      category: 'personal',
      price: 0
    }
  },
  props: ['params'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    submit(){
      if(this.validate()){
        let parameter = {
          account_id: this.user.userID,
          title: this.title,
          settings: this.settings,
          width: (this.size === 'portrait') ? this.config.LANDSCAPE : this.config.PORTRAIT,
          height: (this.size === 'portrait') ? this.config.PORTRAIT : this.config.LANDSCAPE,
          status: this.status,
          categories: this.category,
          price: this.price
        }
        this.APIRequest('templates/create', parameter).then(response => {
          if(response.data > 0){
            $('#createTemplateModal').modal('hide')
            this.$parent.retrieve(false)
          }
        })
      }
    },
    validate(){
      if(this.title !== null || this.title !== '' || this.settings !== null || this.settings !== '' || this.orientation !== null || this.orientation !== ''){
        return true
      }
      return false
    }
  }
}
</script>
