import Vue from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import '@/helper'
import 'bootstrap/dist/css/bootstrap.css'
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'

axios.defaults.baseURL = 'http://localhost:8000/'

axios.interceptors.request.use((config) => {
  if (localStorage.getItem('api_token')) {
    config.headers = {
      'Authorization': 'Bearer ' + localStorage.getItem('api_token')
    }
  }

  return config
});

Vue.prototype.$http = axios;

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
