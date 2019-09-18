<template>
  <div>
    <h1>Conditional</h1>
    <span v-if="flag === false">False</span>
    <span v-else>True</span>
    <h1>Inputs</h1>
    <h2>{{message}}</h2>
    <input type="text" class="form-control" placeholder="Type here..." v-model="message">
    <button class="btn btn-primary" style="margin-top: 10px;" v-on:click="save()">Save</button>
    <h1>Saved Message</h1>
    <h2>{{savedMessage}}</h2>
    <custom-input :message="message" @changeMessage="message = $event"></custom-input>
    <h1 class="text-primary">Add Names</h1>
    <div class="form-group">
      <input type="text" class="form-control col-lg-6" placeholder="First Name" v-model="firstName">
      <br>
      <input type="text" class="form-control col-lg-6" placeholder="Last Name" v-model="lastName">
      <button class="btn btn-primary" style="margin-top: 10px;" v-on:click="addName()">Save Name</button>
    </div>
    <custom-table :list="names" @makeActive="activeIndex = $event"></custom-table>
    <div class="form-group" v-if="activeIndex !== null">
      <input type="text" class="form-control col-lg-6" placeholder="First Name" v-model="names[activeIndex].first_name">
      <br>
      <input type="text" class="form-control col-lg-6" placeholder="Last Name" v-model="names[activeIndex].last_name">
    </div>
    <div id="user">
      <h1>Keyrwin</h1>
      <keyrwin></keyrwin>
    </div>
    <div id="user">
      <h1>Christine</h1>
      <christine></christine>
    </div>
    <div id="user">
      <h1>Jed</h1>
      <jed></jed>
    </div>
    <div id="user">
      <h1>Franz</h1>
      <franz></franz>
    </div>
    <div id="user">
      <h1>Mark</h1>
      <mark></mark>
    </div>
    <div id="user">
      <h1>Kerwin</h1>
      <kerwin></kerwin>
    </div>
    <div id="user">
      <h1>Hanny</h1>
      <hanny></hanny>
    </div>
  </div>
</template>
<style scoped>
.form-control{
  height: 50px !important;
}
#user {
  border: 1px solid black; 
  padding: 5px;
  margin-bottom: 30px;
}
</style>
<script>
export default{
  data(){
    return{
      flag: true,
      message: null,
      savedMessage: null,
      firstName: null,
      lastName: null,
      names: [],
      activeIndex: null
    }
  },
  components: {
    'custom-input': require('modules/tutorials/Input.vue'),
    'custom-table': require('modules/tutorials/Table.vue'),
    'keyrwin': require('modules/tutorials/Keyrwin.vue'),
    'christine': require('modules/tutorials/Christine.vue'),
    'jed': require('modules/tutorials/Jed.vue'),
    'franz': require('modules/tutorials/Franz.vue'),
    'mark': require('modules/tutorials/Mark.vue'),
    'kerwin': require('modules/tutorials/Kerwin.vue'),
    'hanny': require('modules/tutorials/Hanny.vue')
  },
  methods: {
    save(){
      this.savedMessage = this.message
    },
    addName(){
      let object = {
        first_name: this.firstName,
        last_name: this.lastName
      }
      this.names.push(object)
      this.firstName = null
      this.lastName = null
    }
  }
}
</script>
