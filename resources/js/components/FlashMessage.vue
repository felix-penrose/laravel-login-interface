<template>
<div>

<div :class="['alert', 'alert-' + class_name]" role="alert">
    <slot></slot>
</div>

</div>
</template>

<script>
    export default {

        name: 'FlashMessage',
        props: [
            'class_name',
        ],

    }
</script>
