import Vue from 'vue';
import Vuex from 'vuex';

import FlashMessage from './components/FlashMessage.vue';
import SideBar from './components/profile/SideBar.vue';

import EditProfile from './components/profile/EditProfile.vue';
import CloseAccount from './components/profile/CloseAccount.vue';

Vue.use(Vuex);

const store = new Vuex.Store({

    state: {
        user: {},
        flash_message: null,
        field_errors: null,
    },

    mutations: {
        update(state, user) {
            state.user = user;
        },

        update_user_key(state, data) {
            state.user[data.id] = data.value;
        },

        set_flash_message(state, data) {
            state.flash_message = data;
        },

        set_field_errors(state, errors) {
            state.field_errors = errors;
        }
    }
});


const api_url = '/u/profile';


new Vue({
    el: '#app',
    store,

    data: {
        current_tab: 'edit-profile',
        processing: false,
    },

    components: {
        FlashMessage,
        SideBar,

        // central sections
        EditProfile,
        CloseAccount,
    },

    mounted() {
        this.set_tab();
        this.fetch_user();
    },


    methods: {

        set_user(user) {
            this.$store.commit('update', user);
        },


        set_tab(tab) {
            if (tab) {
                this.current_tab = tab;
            } else if (window.location.hash) {
                this.current_tab = window.location.hash.substring(1);
            }

            this.$store.commit('set_flash_message', null);
            this.$store.commit('set_field_errors', null);
        },


        fetch_user() {
            this.processing = true;

            // make ajax call
            axios.get(api_url)
            .then(r => {
                r = r.data;

                // set global user object
                this.set_user({
                    first_name: r.first_name,
                    last_name: r.last_name,
                    email: r.email,
                    username: r.username,
                    personal_site: r.personal_site,
                    location: r.location,
                    instagram_username: r.instagram_username,
                    twitter_username: r.twitter_username,
                });

            }).catch(error => {

                this.$store.commit('set_flash_message', { class: 'danger', message: error });

            }).then(() => {
                // note we're not processing any more
                this.processing = false;
            });
        },


        update_user(section) {

            this.processing = true;

            let end_point;

            switch (section) {
                case 'edit_profile': end_point = api_url; break;
                case 'email_settings': end_point = api_url + '/email-settings'; break;
                case 'change_password': end_point = api_url + '/password'; break;

                default: end_point = api_url;
            }

            axios.put(end_point, this.$store.state.user)
            .then(r => {
                r = r.data;

                this.$store.commit('set_field_errors', null);
                this.$store.commit('set_flash_message', { class: 'success', message: 'Profile successfully updated' });

                // hide the message after a few seconds
                setTimeout(() => {
                    this.$store.commit('set_flash_message', null);
                }, 3000);

            }).catch(error => {
                let errors = error.response.data.errors;

                this.$store.commit('set_field_errors', errors);
                this.$store.commit('set_flash_message', { class: 'danger', message: error.response.data.message });

            }).then(() => {
                // note we're not processing any more
                this.processing = false;
            });
        },
    }
});
