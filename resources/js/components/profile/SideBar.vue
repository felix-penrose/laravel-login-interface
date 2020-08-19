<template>

    <div class="list-group side_bar">

        <a class="list-group-item list-group-item-action"
            href="#edit-profile"
            :class="current_tab == 'edit-profile' ? 'active' : ''"
            @click="$emit('set-tab', 'edit-profile')"
        >Edit Profle</a>

        <a class="list-group-item list-group-item-action"
            href="#email-settings"
            :class="current_tab == 'email-settings' ? 'active' : ''"
            @click="$emit('set-tab', 'email-settings')"
        >Email settings</a>

        <a class="list-group-item list-group-item-action"
            href="#change-password"
            :class="current_tab == 'change-password' ? 'active' : ''"
            @click="$emit('set-tab', 'change-password')"
        >Change Password</a>

        <a class="list-group-item list-group-item-action"
            href="#close-account"
            :class="current_tab == 'close-account' ? 'active' : ''"
            @click="$emit('set-tab', 'close-account')"
        >Close Account</a>
    </div>

</template>

<script>
    export default {

        props: ['current_tab'],

        name: 'SideBar',

        mounted() {

        },

        methods: {

        },
    }
</script>
