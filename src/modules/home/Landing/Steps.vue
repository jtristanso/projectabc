<template>
  <div class="cw-snetwork">
    <div class="text text-green">
      <h1>Three easy steps to your printed design</h1>
    </div>
    <div class="card-holder">
      <div class="card" v-for="item, index in data" v-if="data !== null">
        <img class="card-img-top" src="../../../assets/img/template.png" v-if="index === 0">
        <img class="card-img-top" src="../../../assets/img/entry.png" v-if="index === 1">
        <img class="card-img-top" src="../../../assets/img/checkout.png" v-if="index === 2">
        <div class="card-body">
          <h5 class="card-title text-green">Step {{index + 1}}: {{item.title}}</h5>
          <p class="card-text">{{item.description}}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.cw-snetwork{
  width: 100%;
  float: left;
  min-height: 650px;
  overflow-y: hidden;
}

.text{
  width: 90%;
  float: left;
  margin-right: 10%;
  margin-top: 50px;
  height: 50px;
  margin-left: 5%;
  margin-right: 5%;
}

.text .title{
  width: 100%;
  float: left;
}

.title h1{
  font-size: 40px;
}

.text .description{
  margin-top: 25px;
  width: 100%;
  float: left;
  text-align: justify;
}

.image{
  width: 40%;
  margin-left: 10%;
  float: left;
  margin-top: 150px;
  display: block;
}
.card-holder{
  width: 90%;
  float: left;
  margin-left: 5%;
  margin-right: 5%;
}
.card{
  width: 30%;
  float: left;
  margin-right: 3%;
  margin-top: 50px;
  margin-bottom: 50px;
}
.card-body{
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

  .card{
    width: 100%;
    margin-left: 0%;
    margin-right: 0%;
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
      data: [
        {title: 'Create or Attach a Design', description: 'Create custom designs using our editor tool or choose from the marketplace for designs or attach your own design.', image: '../../assets/img/banner.png'},
        {title: 'Finding a Printing Partner', description: 'When you are already satisfied with your design, you can now choose any of our printing partners near your locale. ', image: '../../../assets/img/banner.png'},
        {title: 'Check Out', description: 'Once you are done choosing any of our printing partners, you can now proceed to checkout and choose whether it is for delivery or pickup.', image: '../../../assets/img/banner.png'}
      ]
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
