<template>
<div>

    <h2 class="mb-3">Close Account</h2>

    <div class="row">
        <div class="col-12">
            <strong class="text-danger">Warning:</strong> Closing your account is irreversible. All of your data will be deleted.
        </div>
    </div>

    <div class="row my-3">
        <div class="col-12">
            <InputText
                id="current_password"
                type="password"
                label="Current password"
                v-model="current_password"
            />
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 mt-5">
            <button
                type="button"
                class="btn btn-danger btn-lg btn-block"
                :disabled="processing"
                @click="delete_account"
            >Delete Account</button>
        </div>
    </div>

</div>
</template>

<script>
    import InputText from '../InputText.vue';

    export default {

        name: 'CloseAccount',

        components: {
            InputText,
        },

        data() {
            return {
                processing: false,
                current_password: '',
            };
        },

        props: ['end_point'],

        methods: {

            delete_account() {

                this.processing = true;

                const redirect_timeout = 3000;

                if (!confirm('WARNING! Are you sure you want to delete your account. This Action cannot be undone!')) {
                    this.$store.commit('set_field_errors', null);
                    this.$store.commit('set_flash_message', null);

                    this.processing = false;

                    return false;
                }

                axios.delete(this.$props.end_point, {
                    data: { current_password: this.current_password }
                })
                .then(r => {
                    r = r.data;

                    this.$store.commit('set_flash_message', { class: 'warning', message: `Your account has been successfully deleted. Redirecting in ${redirect_timeout / 1000} seconds` });

                    // redirect after a few seconds
                    setTimeout(() => {
                        window.location = r.redirect;
                    }, redirect_timeout);

                }).catch(error => {

                    console.log(error);

                    let errors = error.response.data.errors;

                    this.$store.commit('set_field_errors', errors);
                    this.$store.commit('set_flash_message', { class: 'danger', message: error.response.data.message });

                }).then(() => {
                    // note we're not processing any more
                    this.processing = false;
                });
            }
        },
    }
</script>
