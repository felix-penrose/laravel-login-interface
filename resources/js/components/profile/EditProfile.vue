<template>
<div>

    <h2>Edit Profile</h2>

    <div class="row">
        <div class="col-12 col-sm-5 col-md-4 col-lg-3">
            <img :src="('https://picsum.photos/200')" alt="profile image" class="img-thumbnail rounded mx-auto d-block">
        </div>

        <div class="col-12 col-sm-7 col-md-8 col-lg-9">
            <InputText
                id="first_name"
                label="First name"
                v-model="this.$store.state.user.first_name"
                v-on:update-store-value="update_value"
            />

            <InputText
                id="last_name"
                label="Last name"
                v-model="this.$store.state.user.last_name"
                v-on:update-store-value="update_value"
            />

            <InputText
                id="email"
                label="Email address"
                v-model="this.$store.state.user.email"
                v-on:update-store-value="update_value"
            />
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <InputText
                id="username"
                label="Username"
                v-model="this.$store.state.user.username"
                v-on:update-store-value="update_value"
            />
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <InputText
                id="personal_site"
                label="Personal Site"
                v-model="this.$store.state.user.personal_site"
                v-on:update-store-value="update_value"
            />

            <InputText
                id="instagram_username"
                label="Instagram username"
                prepend="@"
                v-model="this.$store.state.user.instagram_username"
                v-on:update-store-value="update_value"
            />
        </div>

        <div class="col-12 col-md-6">
            <InputText
                id="location"
                label="Location"
                v-model="this.$store.state.user.location"
                v-on:update-store-value="update_value"
            />

            <InputText
                id="twitter_username"
                label="Twitter username"
                prepend="@"
                v-model="this.$store.state.user.twitter_username"
                v-on:update-store-value="update_value"
            />
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 mt-5">
            <button
                type="button"
                class="btn btn-primary btn-lg btn-block"
                :disabled="processing"
                @click="$emit('update-user', 'edit_profile')"
            >Update Account</button>
        </div>
    </div>

</div>
</template>

<script>
    import InputText from '../InputText.vue';

    export default {

        props: ['processing'],

        components: {
            InputText,
        },

        name: 'EditProfile',

        methods: {

            update_value(data) {
                this.$store.commit('update_user_key', data);
            },
        },
    }
</script>
