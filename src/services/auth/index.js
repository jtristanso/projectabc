// src/auth/index.js
import {router} from '../../router/index'
import ROUTER from '../../router'
import {Howl} from 'howler'
import Vue from 'vue'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import Config from '../../config.js'
export default {
  audio: {
    status: 0,
    timeDisplay: `00:00:00`,
    seconds: 0,
    minutes: 0,
    hours: 0,
    timer: null,
    receiverId: null,
    senderUser: null,
    receiverUser: null
  },
  mode: 0,
  user: {
    userID: 0,
    username: '',
    email: null,
    type: null,
    status: null,
    profile: null,
    cart: 0,
    plan: null,
    notifications: {
      data: null,
      current: null,
      prevCurrent: null
    },
    notifSetting: null,
    messages: {
      data: null,
      totalUnreadMessages: 0
    }
  },
  messenger: {
    messages: null,
    badge: 0,
    messengerGroupId: null
  },
  support: {
    messages: null,
    badge: 0,
    messengerGroupId: null
  },
  notifTimer: {
    timer: null,
    speed: 1000
  },
  tokenData: {
    token: null,
    tokenTimer: false,
    verifyingToken: false
  },
  otpDataHolder: {
    userInfo: null,
    data: null
  },
  google: {
    code: null,
    scope: null
  },
  echo: null,
  currentPath: false,
  setUser(userID, username, email, type, status, profile, checkout, plan, notifSetting){
    if(userID === null){
      username = null
      email = null
      type = null
      status = null
      profile = null
      checkout = 0
      plan = null
      notifSetting = null
    }
    this.user.userID = userID * 1
    this.user.username = username
    this.user.email = email
    this.user.type = type
    this.user.status = status
    this.user.profile = profile
    this.user.checkout = checkout
    this.user.plan = plan
    this.user.notifSetting = notifSetting
    localStorage.setItem('account_id', this.user.userID)
  },
  setToken(token){
    this.tokenData.token = token
    localStorage.setItem('usertoken', token)
    if(token){
      setTimeout(() => {
        let vue = new Vue()
        vue.APIRequest('authenticate/refresh', {}, (response) => {
          this.setToken(response['token'])
        }, (response) => {
          this.deaunthenticate()
        })
      }, 1000 * 60 * 60) // 50min
    }
  },
  authenticate(username, password, callback, errorCallback){
    let vue = new Vue()
    let credentials = {
      username: username,
      password: password,
      status: 'VERIFIED'
    }
    vue.APIRequest('authenticate', credentials, (response) => {
      this.setToken(response.token)
      vue.APIRequest('authenticate/user', {}, (userInfo) => {
        let parameter = {
          'condition': [{
            'value': userInfo.id,
            'clause': '=',
            'column': 'id'
          }]
        }
        vue.APIRequest('accounts/retrieve', parameter).then(response => {
          if(response.data.length > 0){
            this.otpDataHolder.userInfo = userInfo
            this.otpDataHolder.data = response.data
            this.checkOtp(response.data[0].notification_settings)
          }
        })
        // this.retrieveNotifications(userInfo.id)
        this.retrieveMessages(userInfo.id, userInfo.account_type)
        this.connect()
        if(callback){
          callback(userInfo)
        }
      })
    }, (response, status) => {
      if(errorCallback){
        errorCallback(response, status)
      }
    })
  },
  checkAuthentication(callback){
    this.tokenData.verifyingToken = true
    let token = localStorage.getItem('usertoken')
    if(token){
      this.setToken(token)
      let vue = new Vue()
      vue.APIRequest('authenticate/user', {}, (userInfo) => {
        let parameter = {
          'condition': [{
            'value': userInfo.id,
            'clause': '=',
            'column': 'id'
          }]
        }
        vue.APIRequest('accounts/retrieve', parameter).then(response => {
          let profile = response.data[0].account_profile
          let checkout = response.data[0].checkout
          let plan = response.data[0].plan
          let notifSetting = response.data[0].notification_settings
          this.setUser(userInfo.id, userInfo.username, userInfo.email, userInfo.account_type, userInfo.status, profile, checkout, plan, notifSetting)
        }).done(response => {
          this.tokenData.verifyingToken = false
          let location = window.location.href
          this.connect()
          if(this.currentPath){
            // ROUTER.push(this.currentPath)
          }else{
            window.location.href = location
          }
        })
        // this.retrieveNotifications(userInfo.id)
        this.retrieveMessages(userInfo.id, userInfo.account_type)
        this.getGoogleCode()
      }, (response) => {
        this.setToken(null)
        this.tokenData.verifyingToken = false
        ROUTER.push({
          path: this.currentPath
        })
      })
      return true
    }else{
      this.tokenData.verifyingToken = false
      this.setUser(null)
      return false
    }

  },
  deaunthenticate(){
    localStorage.removeItem('usertoken')
    localStorage.removeItem('account_id')
    localStorage.removeItem('google_code')
    localStorage.removeItem('google_scope')
    this.setUser(null)
    let vue = new Vue()
    vue.APIRequest('authenticate/invalidate')
    this.clearNotifTimer()
    this.tokenData.token = null
    ROUTER.go('/')
  },
  retrieveNotifications(accountId){
    let vue = new Vue()
    let parameter = {
      'account_id': accountId
    }
    vue.APIRequest('notifications/retrieve', parameter).then(response => {
      if(response.data.length > 0){
        this.user.notifications.data = response.data
        this.user.notifications.current = response.notification_current
        if(this.user.notifications.current > 0){
          // this.playNotificationSound()
        }
      }else{
        this.user.notifications.data = null
        this.user.notifications.current = null
      }
    })
  },
  retrieveMessages(accountId, type){
    let vue = new Vue()
    let parameter = {
      account_id: accountId,
      account_type: type
    }
    vue.APIRequest('messenger_groups/retrieve_summary', parameter).then(response => {
      this.user.messages.data = response.data
      this.user.messages.totalUnreadMessages = response.total_unread_messages
    })
    console.log(this.user.messages.data)
  },
  startNotifTimer(accountId){
    if(this.notifTimer.timer === null){
      this.notifTimer.timer = window.setInterval(() => {
        if(accountId !== null){
          this.retrieveNotifications(accountId)
        }
      }, this.notifTimer.speed)
    }
  },
  clearNotifTimer(){
    if(this.notifTimer.timer !== null){
      window.clearInterval(this.notifTimer.timer)
      this.notifTimer.timer = null
    }
  },
  playNotificationSound(){
    let audio = require('../../assets/audio/notification.mp3')
    let sound = new Howl({
      src: [audio]
    })
    sound.play()
  },
  checkPlan(){
    if(this.user.plan !== null){
      if(this.user.plan.title === 'Expired' && this.user.type !== 'ADMIN'){
        ROUTER.push('/plan')
      }
    }
  },
  redirect(path){
    ROUTER.push(path)
  },
  validateEmail(email){
    let reg = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+.[a-zA-Z0-9]*$/
    if(reg.test(email) === false){
      return false
    }else{
      return true
    }
  },
  checkOtp(setting){
    if(setting !== null){
      if(parseInt(setting.email_otp) === 1 || parseInt(setting.sms_otp) === 1){
        // ask otp code here
        $('#otpModal').modal({
          backdrop: 'static',
          keyboard: true,
          show: true
        })
      }else{
        this.proceedToLogin()
      }
    }else{
      this.proceedToLogin()
    }
  },
  proceedToLogin(){
    let userInfo = this.otpDataHolder.userInfo
    let data = this.otpDataHolder.data
    let profile = data[0].account_profile
    let checkout = data[0].checkout
    let plan = data[0].plan
    let notifSetting = data[0].notification_settings
    this.setUser(userInfo.id, userInfo.username, userInfo.email, userInfo.account_type, userInfo.status, profile, checkout, plan, notifSetting)
    ROUTER.push('/marketplace')
  },
  setGoogleCode(code, scope){
    localStorage.setItem('google_code', code)
    localStorage.setItem('google_scope', scope)
    this.google.code = code
    this.google.scope = scope
  },
  getGoogleCode(){
    this.google.code = localStorage.getItem('google_code')
    this.google.scope = localStorage.getItem('google_scope')
  },
  connect(){
    if(!this.echo){
      this.echo = new Echo({
        broadcaster: 'pusher',
        key: Config.PUSHER_KEY,
        cluster: 'ap1',
        encrypted: true,
        auth: {
          headers: {
            Authorization: 'Bearer' + this.tokenData.token
          }
        }
      })
      $.ajaxSetup({
        beforeSend: function() {}
      })
    }
    this.echo.channel('paprint-call').listen('Call', (response) => {
      let action = parseInt(response.user.action)
      let sender = response.user.sender
      let receiver = response.user.receiver
      this.audio.senderUser = sender
      this.audio.receiverUser = receiver
      if(sender.id !== this.user.userID){
        this.audio.receiverId = sender.id
      }
      if(action === 2 && receiver.id === this.user.userID){
        this.triggerAudioCall(0, null)
      } else if(action === 1 && receiver.id === this.user.userID){
        this.triggerAudioCall(1, null)
        this.startAudioCallTimer()
      } else if(action === 0 && receiver.id === this.user.userID){
        this.endAudioCallTimer()
      }
    })
    this.echo.channel('idfactory').listen('Message', (response) => {
      console.log(response)
      if(parseInt(response.message.account_id) !== this.user.userID && response.message.type === 'support'){
        this.playNotificationSound()
        if(this.support.messengerGroupId !== parseInt(response.message.messenger_group_id) && this.support.messengerGroupId !== null){
          this.support.badge++
        }
        if(!this.support.messages){
          this.support.messages = []
          this.support.messages.push(response.message)
        }else{
          if(this.support.messengerGroupId === parseInt(response.message.messenger_group_id)){
            this.support.messages.push(response.message)
          }
        }
      }else if(parseInt(response.message.account_id) !== this.user.userID && response.message.type !== 'support'){
        this.playNotificationSound()
        if(this.messenger.messengerGroupId !== parseInt(response.message.messenger_group_id) && this.messenger.messengerGroupId !== null){
          this.messenger.badge++
        }
        if(!this.messenger.messages){
          this.messenger.messages = []
          this.messenger.messages.push(response.message)
        }else{
          if(this.messenger.messengerGroupId === parseInt(response.message.messenger_group_id)){
            this.messenger.messages.push(response.message)
          }
        }
      }
    })
  },
  triggerAudioCall(params, receiver){
    $('#audio-call').css({'display': 'block'})
    let vue = new Vue()
    this.audio.status = params
    if (params === 2){
      let parameter = {
        receiver: receiver,
        sender: this.user.userID,
        action: 2
      }
      vue.APIRequest('audio_calls/send', parameter, (response) => {
        //
      })
    } else {
      this.playNotificationSound()
    }
  },
  startAudioCallTimer(){
    clearInterval(this.audio.timer)
    this.audio.seconds = 0
    this.audio.minutes = 0
    this.audio.hours = 0
    this.audio.timer = setInterval(() => {
      this.audio.seconds++
      if (this.audio.seconds === 60){
        this.audio.seconds = 0
        this.audio.minutes++
      }
      if (this.audio.minutes === 60){
        this.audio.minutes = 0
        this.audio.hours++
      }
      let s = this.audio.seconds.toString().padStart(2, '0')
      let m = this.audio.minutes.toString().padStart(2, '0')
      let h = this.audio.hours.toString().padStart(2, '0')
      console.log('counting')
      this.audio.timeDisplay = `${h}:${m}:${s}`
    }, 1000)
  },
  endAudioCallTimer(){
    clearInterval(this.audio.timer)
    this.audio.seconds = 0
    this.audio.minutes = 0
    this.audio.hours = 0
    $('#audio-call').css({'display': 'none'})
  }
}
