import Vue from 'vue'
import VueSweetalert2 from 'vue-sweetalert2';
import { ToastPlugin, ModalPlugin } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'

import axios from 'axios'
import VueAxios from 'vue-axios'
import i18n from '@/plugins/i18n'
import router from './router'
import store from './store'
import App from './App.vue'
// import './Interceptors/axios'
// Global Components
import './global-components'

// 3rd party plugins
import '@/libs/portal-vue'
import '@/libs/toastification'

import 'sweetalert2/dist/sweetalert2.min.css';

axios.defaults.baseURL = 'http://localhost/tecnicatura/proyecto-pd/papi/public';

// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)

// Composition API
Vue.use(VueCompositionAPI)
Vue.use(VueAxios)
Vue.use(axios)
Vue.use(VueSweetalert2);

// import core styles
require('@core/scss/core.scss')

// import assets styles
require('@/assets/scss/style.scss')

Vue.config.productionTip = false

// Vue.prototype.$baseUrl = 'http://localhost/tecnicatura/proyecto-pd/papi/public';
// Vue.prototype.$baseUrlApi = 'http://localhost/tecnicatura/proyecto-pd/papi/public/api/v1';
Vue.prototype.$baseUrl = 'http://www.payday.com.uy/api';
Vue.prototype.$baseUrlApi = 'http://www.payday.com.uy/api/api/v1';

new Vue({
  i18n,
  router,
  store,
  render: h => h(App),
}).$mount('#app')
