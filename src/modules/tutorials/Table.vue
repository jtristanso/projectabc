<template>
  <div>
    <h1>Table</h1>
    <div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item, index in list">
            <td>{{item.first_name}}</td>
            <td>{{item.last_name}}</td>
            <td>
              <button class="btn btn-primary" v-on:click="save(index)">Edit</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<style scoped>
.form-control{
  height: 50px !important;
}
.table{
  margin-bottom: 50px;
}
</style>
<script>
export default{
  props: ['list'],
  methods: {
    save(index){
      console.log(index)
      this.$emit('makeActive', index)
    }
  }
}
</script>
