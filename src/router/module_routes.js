import AUTH from 'services/auth'
let CONFIG = require('config.js')
let beforeEnter = (to, from, next) => {
  // TODO Redirect if no token when token is required in meta.tokenRequired
  AUTH.currentPath = to.path
  let userID = parseInt(localStorage.getItem('account_id'))
  let token = localStorage.getItem('usertoken')
  if(token !== null && userID > 0){
    if(to.path === '/' || to.path === '/'){
      next({path: '/templates'})
    }else{
      next()
    }
  }else if(to.meta.tokenRequired === true){
    next({path: '/'})
  }else{
    next()
  }
}
var devRoutes = []
let paprint = require('./dev_routes/paprint.js')
devRoutes = devRoutes.concat(paprint.default.routes)
for(let x = 0; x < devRoutes.length; x++){
  devRoutes[x]['beforeEnter'] = beforeEnter
}
let routes = [
  {
    path: '/',
    name: 'home',
    component: resolve => require(['modules/home/Landing.vue'], resolve),
    beforeEnter: beforeEnter
  }
]
// if(CONFIG.default.IS_DEV){
routes = routes.concat(devRoutes)
// }
export default{
  routes: routes
}
