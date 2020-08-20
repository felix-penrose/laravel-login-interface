<template>
<div>

<label :for="id">{{ label }}</label>

<div class="input-group mb-3">
    <div v-if="prepend" class="input-group-prepend">
        <span class="input-group-text">{{ prepend }}</span>
    </div>

    <input
        type="text"
        :id="id"
        class="form-control"
        :value="value"
        :aria-label="placeholder"
        :placeholder="placeholder"
        @input="$emit('update-value', { id, value: $event.target.value });"
    >

    <div v-if="append" class="input-group-append">
        <span class="input-group-text">{{ append }}</span>
    </div>
</div>

</div>
</template>

<script>
    export default {

        name: 'InputText',
        props: [
            'id',
            'label',
            'value',
            'prepend',
            'append',
            'placeholder',
        ],

    }
</script>
