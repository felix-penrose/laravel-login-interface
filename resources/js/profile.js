import Vue from 'vue';
import SideBar from './components/profile/SideBar.vue';

// Vue.prototype.$base_url = '/core/ajax/piggy-bank';
// Vue.prototype.$phone_no = PHONE_NO;

new Vue({
    el: '#app',

    components: {
        SideBar,
    },
});
