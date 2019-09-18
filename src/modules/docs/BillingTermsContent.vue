<template>
  <div class="guide-holder">
    <ul class="first-ul">
      <li><strong>Shipping</strong></li>
      <li><strong>Charges</strong></li>
      <li>All our pricing and delivery options can be viewed on our Pricing page.</li>
      <li><strong>Information</strong></li>
      <li>All orders are shipped via LBC, JRS and AP Cargo. 
      You will receive an on screen confirmation once your payment has been authorized, which will confirm the address the goods are to be delivered to along with your order reference number. An email confirmation acknowledging receipt of your order will follow.
      All answers will be answered within one business day.
      When receiving the goods please open the package and examine them before signing to ensure they are in good condition - if the packaging or item is damaged please do not accept the goods and notify us as soon as possible. If you are unable to check the item at the time of delivery, please sign as unchecked but do make sure to report any issues within 24 hours.
      If items are signed for in good condition that later prove to be damaged we have no recourse with the carriers so please check items thoroughly to avoid any disappointment. If there is no-one in to sign for the goods, they will be taken back to the courier depot and a card left.
      </li>
    </ul>
  </div>
</template>
<style scoped>
  .guide-holder{
  margin-top:22px;
  width:90%;
  float: left;
  margin-left:5%;
  margin-right:5%;
}
.first-ul{
  padding: 0px;
  list-style: none;
}
.first-ul li, .second-ul li{
  text-align: justify;
  font-size: 15px;
  color: grey;
  padding-top: 10px;
}
.second-ul{
  padding-left: 10px;
  list-style: inside;
}
</style>
<script>
  import ROUTER from '../../router'
  import Vue from 'vue'
  import AUTH from '../../services/auth'
  import Chart from 'chart.js'
  export default{
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
