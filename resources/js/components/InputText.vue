<template>
<div>

<label :for="id">{{ label }}</label>

<div class="input-group mb-3">
    <div v-if="prepend" class="input-group-prepend">
        <span class="input-group-text">{{ prepend }}</span>
    </div>

    <input
        :type="type || 'text'"
        :id="id"
        class="form-control"
        :class="(get_error() && 'is-invalid')"
        :value="value"
        :aria-label="placeholder"
        :placeholder="placeholder"
        @input="handle_input"
    >

    <div v-if="append" class="input-group-append">
        <span class="input-group-text">{{ append }}</span>
    </div>

    <div v-if="get_error()" class="invalid-feedback">
        {{ get_error() }}
    </div>
</div>

</div>
</template>

<script>
    export default {
        name: 'InputText',
        props: [
            'id',
            'type',
            'label',
            'value',
            'prepend',
            'append',
            'placeholder',
        ],

        methods: {

            get_error() {
                return this.$store.state.field_errors && this.$store.state.field_errors[this.$props.id] && this.$store.state.field_errors[this.$props.id][0];
            },

            handle_input(e) {

                this.$emit('update-store-value', { id: this.$props.id, value: e.target.value });

                this.$emit('input', e.target.value);
            }
        },
    }
</script>
