import Vue from 'vue';
import SideBar from './components/profile/SideBar.vue';

import EditProfile from './components/profile/EditProfile.vue';
import EmailSettings from './components/profile/EmailSettings.vue';
import ChangePassword from './components/profile/ChangePassword.vue';
import CloseAccount from './components/profile/CloseAccount.vue';


Vue.prototype.$base_url = '/profile';


new Vue({
    el: '#app',

    data: {
        current_tab: 'edit-profile',
    },

    components: {
        SideBar,

        // central sections
        EditProfile,
        EmailSettings,
        ChangePassword,
        CloseAccount,
    },

    mounted() {

        this.set_tab();

    },

    methods: {

        set_tab(tab) {

            if (tab) {
                this.current_tab = tab;
            } else if (window.location.hash) {
                this.current_tab = window.location.hash.substring(1);
            }
        },

    }
});
