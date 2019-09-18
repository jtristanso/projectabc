<template>
  <div class="cw-banner">
    <div class="text text-white">
      <span class="title">
        <h1>Showcase your Creativity</h1>
      </span>
      <span class="description">
        <h4>
          Explore and make use of our editor tools to create your own template and design. Our editor tools can provide you customizable layouts that will help you in creating better content. 
        </h4>
      </span>
      <span class="designer">
        <h4>
          Make your Designs your source of income
        </h4>
      </span>
      <span class="description1">
        <h5>
          For graphic designers and editors, you can publish your arts and works in marketplace and get revenue every time customers pick and purchase your designs and templates. Start your investment here. 
        </h5>        
      </span>
    </div>
  </div>
</template>
<style scoped>        
.cw-banner{
  width: 100%;
  background: #4d529f;
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
.designer h4{
  font-size: 1.5rem;
}
.text .description{
  margin-top: 25px;
  width: 100%;
  float: right;
  text-align: justify;
}

.text .designer{
  width: 100%;
  float: left;
  margin-top: 50px;
}

.text .description1{
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
