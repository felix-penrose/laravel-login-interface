import Vue from 'vue';
import Vuex from 'vuex';

import SideBar from './components/profile/SideBar.vue';

import EditProfile from './components/profile/EditProfile.vue';
import EmailSettings from './components/profile/EmailSettings.vue';
import ChangePassword from './components/profile/ChangePassword.vue';
import CloseAccount from './components/profile/CloseAccount.vue';

Vue.use(Vuex);

const store = new Vuex.Store({

    state: {
        user: {},
    },

    mutations: {
        update(state, user) {
            state.user = user;
        },

        update_user_key(state, data) {

            console.log([data]);
            state.user[data.id] = data.value;
        }
    }
});


new Vue({
    el: '#app',
    store,

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
        this.get_user();
    },

    methods: {

        set_tab(tab) {

            if (tab) {
                this.current_tab = tab;
            } else if (window.location.hash) {
                this.current_tab = window.location.hash.substring(1);
            }
        },



        get_user() {

            // make ajax call
            // set global user object
            this.set_user({
                first_name: 'test',
                last_name: 'test',
                email: 'test@test.com',
                username: '',
                personal_site: '',
                location: '',
                instagram_username: '',
                twitter_username: '',
            });

        },


        set_user(user) {

            this.$store.commit('update', user);
        }

    }
});
