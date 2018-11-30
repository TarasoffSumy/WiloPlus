import Vue from 'vue'
import App from './App.vue'
import axios from "axios";

// import iView from 'iview';
// import locale from "iview/dist/locale/en-US";
// import 'iview/dist/styles/iview.css';

// import '../my-theme/index.less';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import './assets/element-variables.scss';

import Home from './components/Home.vue';
import HeaderPart from './components/Header.vue';
import stepTile from './components/stepTile.vue';
import Step1 from './components/Step1.vue';
import Step2 from './components/Step2.vue';
import Step3 from './components/Step3.vue';
import Step4 from './components/Step4.vue';
import Step1Helper from './components/Step1-helper.vue';


Vue.component('Home', Home);
Vue.component('HeaderPart', HeaderPart);
Vue.component('stepTile', stepTile);
Vue.component('Step1', Step1);
Vue.component('Step2', Step2);
Vue.component('Step3', Step3);
Vue.component('Step4', Step4);
Vue.component('Step1-helper', Step1Helper);

Vue.prototype.$http = axios;

Vue.config.productionTip = true;


Vue.use(ElementUI);
// Vue.use(iView, {
//   locale
// });

new Vue({
  render: h => h(App),
}).$mount('#app')
