/**
 * This file loads the Vue App
 * We use vuetify, vue-router, vuex and axios
 */

require('./bootstrap')
require('vuetify/dist/vuetify.min.css')

window.axios = require('axios')
// Global axios headers
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

import Vue from 'vue'
import Vuetify from 'vuetify'
import router from './router'
import { store } from './store'
import App from '@components/App'

// Event Bus
window.Bus = new Vue()

Vue.use(Vuetify)

Vue.config.productionTip = false
if ('production' === process.env.MIX_APP_ENV) {
  Vue.config.devtools = false
  Vue.config.debug = false
  Vue.config.silent = true
}

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App),
  created() {
    console.debug('APP created')
  }
})
