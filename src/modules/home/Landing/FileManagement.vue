<template>
  <div class="cw-banner">
    <div class="text text-white">
      <span class="title">
        <h1>Manage your files Seamlessly</h1>
      </span>
      <span class="description">
        <h4> 
          We always make sure that everything is convenient and efficient for you. 
        </h4>
      </span>
      <span class="partners">
        <h4>
          To our printing partners, with file management you can organize well your designs and templates and you can also track down all completed transactions easily. Effective file management helps you save time, work smoothly and handle current transactions with no hassle.
        </h4>
      </span>
      <span class="customers">
        <h4>
          To our valued customers, you can also attach and publish your designs and template with file management. Sort and manage all your files in a systematic manner.
        </h4>
      </span>
    </div>
  </div>
</template>
<style scoped>
.cw-banner{
  width: 100%;
  background: #ffaa81;
  min-height: 150px;
  overflow-y: hidden;
}
.text{
  width: 45%;
  float: right;
  margin-top: 70px;
  margin-bottom: 70px;
  margin-right: 5%;
} 
.text .title{
  width: 100%;
  float: left;
  text-align: left;
  margin-right: 50px;
}
.title h1{
  font-size: 40px;
}
.text .description{
  margin-top: 25px;
  width: 100%;
  float: right;
  text-align: justify;
}
.text .partners{
  margin-top: 50px;
  width: 100%;
  float: left;
  text-align: justify;
}
.text .customers{
  margin-top: 50px;
  width: 100%;
  float: left;
  text-align: justify;
}

@media screen and (max-width: 992px){
  .text{
    width: 90%;
    margin-left: 5%;
    margin-right: 5%;
    margin-top: 50px;
  }
  .title{
    text-align: center;
  }
}
</style>
<script>
import ROUTER from '../../../router'
import AUTH from '../../../services/auth'
export default {
  mounted(){
  },
  data(){
    return {
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
