import Vue from 'vue'
import App from './App.vue'
import axios from "axios";
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import './assets/element-variables.scss';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCoffee, faPhoneSlash, faBug, faLightbulb } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'



import Home from './components/Home.vue';
import HeaderPart from './components/Header.vue';
import stepTile from './components/stepTile.vue';
import Step1 from './components/Step1.vue';
import Step2 from './components/Step2.vue';
import Step3 from './components/Step3.vue';
import Step4 from './components/Step4.vue';
import Step1Helper from './components/Step1-helper.vue';
import Step2Helper from './components/Step2-helper.vue';


Vue.component('Home', Home);
Vue.component('HeaderPart', HeaderPart);
Vue.component('stepTile', stepTile);
Vue.component('Step1', Step1);
Vue.component('Step2', Step2);
Vue.component('Step3', Step3);
Vue.component('Step4', Step4);
Vue.component('Step1-helper', Step1Helper);
Vue.component('Step2-helper', Step2Helper);


library.add(faCoffee);
library.add(faLightbulb);


Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.prototype.$http = axios;

Vue.config.productionTip = true;


Vue.use(ElementUI);

new Vue({
  render: h => h(App),
}).$mount('#app')
