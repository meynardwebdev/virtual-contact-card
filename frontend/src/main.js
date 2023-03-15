import Vue from 'vue'
import VueRouter from 'vue-router';
import App from './App.vue'
import routes from './router/index'
import {tools} from './plugins/utils.js';

Vue.prototype.$tools = tools;
Vue.use(VueRouter);

new Vue({
  render: h => h(App),
  router: new VueRouter(routes)
}).$mount('#app')
