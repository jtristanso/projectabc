<template>
  <div class="header">
    <div class="page-header">
      <div class="header-section">
        <span class="logo">
          <a class="navbar-brand" v-on:click="redirect('/')">
            <img src="../../../assets/img/logo_white.png" style="margin-bottom: 5px;">
            <label v-html="config.APP_NAME_HTML"></label>
          </a>
        </span>
        <span class="menu">
          <span class="navbar-menu-toggler-md">
            <i class="fa fa-bars" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" onclick="void(0)"></i>
          </span>
          <ul class="header-primary-menu">
          <!--<li class="nav-item" v-on:click="redirect('/signup_partner')"><a class="nav-link">Be our Partner</a></li>
            <li class="nav-item" v-on:click="redirect('/signup')"><a class="nav-link">Register</a></li> -->
            <li class="nav-item btn btn-warning" v-on:click="redirect('/signup')"> Start Free 30 Day Trial</li>
            <li class="nav-item btn btn-default" style="margin-right:5px" v-on:click="redirect('/login')"><a class="nav-link">Login</a></li>
          </ul>
        </span>
      </div>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <!-- <li class="nav-item" v-on:click="redirect('/signup_partner')"><a class="nav-link">Be our Partner</a></li> -->
          <li class="nav-item" v-on:click="redirect('/signup')" data-toggle="collapse" data-target="#navbarSupportedContent"><a class="nav-link">Start Free 30 Day Trial</a></li>
          <li class="nav-item" v-on:click="redirect('/login')" data-toggle="collapse" data-target="#navbarSupportedContent"><a class="nav-link">Login</a></li>
        </ul>
      </div>
    </div>
  </div>
</template>
<style lang="scss"scoped>
@import "~assets/style/colors.scss";
.header{
  background: transparent;
  width: 100%;
  float: left;
  min-height: 70px;
  overflow-y: hidden;
  background: $primary;
}
.header-section{
  min-height: 50px;
  overflow-y: hidden;
  width: 90%;
  font-size: 12px;
  color: #fff;
  margin: 5px auto 5px auto;
}

.header-section .logo{
  width: 20%;
  float: left;
  height: 100%;
}

.header-section .menu{
  width: 80%;
  float: left;
  height: 100%;
  margin-top: 10px;
}

.navbar-menu-toggler-md{
  width: 100%;
  text-align: right;
  float: left;
  display: none;
}

.menu .header-primary-menu{
  width: 100%;
  float: left;
  min-height: 30px;
  list-style: none;
  overflow-y: hidden;
  padding: 0px;
  margin-bottom: 0px !important;
}
.btn-white{
  background: #fff;
  color: #22b173 !important;
}
.fa-bars{
  border: solid 1px #fff;
  font-size: 20px !important;
  padding: 10px 8px 10px 8px !important;
  color: #fff !important;
}

.fa-bars:hover{
  cursor: pointer;
}

.menu .header-primary-menu .nav-item{
  float: right;
  font-size: 15px;
}

.header-primary-menu .nav-item .nav-link{
  padding: 0.1rem;
}
.header-primary-menu .nav-item a{
  color: #111;
  font-family: MuseoRounded700, sans-serif;
}
.header-primary-menu .nav-item .nav-link:hover{
  cursor: pointer;
  text-decoration: underline;
}

.navbar-toggler{
  background: inherit !important;
  border-radius: 0px !important;
  border: solid 1px #fff;
  font-size: 20px !important;
  padding: 10px 8px 10px 8px !important;
  color: #fff !important;
}
.navbar-toggler:hover{
  color: #22b173 !important;
  background: #fff !important;
}

.navbar-collapse .show{
  display: none !important;
}

.header-section .logo a img{
  width: 50px;
}
.header-section .logo a label{
  font-size: 24px;
  margin-bottom: 0px;
}
.hs-rebranded-btn {
  padding: 8px 17px;
  border: 2px solid transparent;
  font-size: 14px;
  font-weight: 700;
  border-radius: 2px;
  font-family: "Ubuntu", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}
.hs-rebranded-btn.hs-btn-success {
  color: #fff;
  background-color: #FBCD03;
  border-color: #0CDFA3;
}
.hs-btn-success:hover {
    color: #fff;
    background-color: #18d06b;
    border-color: #18d06b;
}

@media screen and (max-width: 992px){
  .header-section{
    width: 90% !important;
    margin: 0 5% 0 5% !important;
  }
  .header-section .logo{
    width: 80%;
    margin-top: 10px;
  }
  
  .header-section  .menu{
    width: 20%;
    margin-top: 15px;
  }
  .menu .top-menu, .menu .header-primary-menu{
    display: none;
  }

  .navbar{
    width: 90% !important;
    margin: 0 5% 0 5% !important;
    padding: 0 !important;
  }
  .navbar-collapse {
    width: 100% !important;
    position: absolute !important;
    z-index: 100000 !important;
    float: left;
    border-bottom: solid 1px #22b173;
  }
  .navbar-nav{
    background: #fff !important;
    margin: 0 !important;
  }
  .navbar-nav .nav-link{
    width: 100% !important;
    padding: 17px 30px 17px 30px !important;
  }

  .navbar-nav .nav-link:hover{
    background: #22b173;
    color: #fff;
  }

  .navbar-nav .nav-link{
    color: #22b173;
  }
  .navbar-menu-toggler-md{
    width: 100%;
    text-align: right;
    float: left;
    display: block;
  }
  .navbar-collapse .show{
    display: block !important;
  }
  .hs-rebranded-btn {
    padding: 8px 17px;
    border: 2px solid transparent;
    font-size: 14px;
    font-weight: 700;
    border-radius: 2px;
    font-family: "Ubuntu", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }
  .hs-rebranded-btn.hs-btn-success {
    color: #fff;
    background-color: #0CDFA3;
    border-color: #0CDFA3;
  }
  .hs-btn-success:hover {
    color: #fff;
    background-color: #18d06b;
    border-color: #18d06b;
  }
}
</style>
<script>
import ROUTER from '../../../router'
import AUTH from '../../../services/auth'
import CONFIG from '../../../config.js'
export default {
  mounted(){
  },
  data(){
    return {
      config: CONFIG
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
