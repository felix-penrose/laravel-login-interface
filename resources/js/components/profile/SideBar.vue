<template>
    <ul class="list-group side_bar">
    <li class="list-group-item"><a href="#">Edit Profle</a></li>
    <li class="list-group-item"><a href="#email-settings">Email settings</a></li>
    <li class="list-group-item"><a href="#change-password">Change Password</a></li>
    <li class="list-group-item"><a href="#close-account">Close Account</a></li>
</ul>

</template>

<script>
    export default {

        name: 'SideBar',

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
