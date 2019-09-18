<template>
  <div class="guide-holder">
    <ul class="first-ul">
      <li><strong>Returns Policy</strong></li>
      <li>Where an item is damaged, please return it to us within fourteen days upon receiving it. Your right to return items to us in accordance with these terms and conditions, in addition to any other statutory rights you may have.
      If you are eligible for a refund, we will refund the payment you made for the product via your original payment method or deposited in your account through your local bank. Alternatively, we may offer a replacement and resend it free of charge. Please note it is not our policy to offer both.
      If the damage is a result of your own actions such as product misuse or, if any personalisation is mis-spelt or, if you have uploaded an image of a low resolution or size, then we will not offer a refund.
      </li>
      <li><strong>Disclaimer</strong></li>
      <li>If We believe you have breached any of these terms and conditions you will not be entitled for a refund on any money paid to us.
      </li>
      <li><strong>Changes & Cancellation</strong></li>
      <li>We can make any requested changes to your order but we will be unable to do so once the Service has been started and/or finished. We cannot offer any refund or changes where the Service has been initiated or completed prior to you advising of any Changes and Cancellation.
      We advise you to contact us as soon as possible should you require a change to the Service of wish to cancel but such Amendments or Cancellations will be at our absolute discretion.
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
