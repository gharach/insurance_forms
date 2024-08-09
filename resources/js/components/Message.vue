<template>
    <div v-if="message" :class="{'text-green-500': success, 'text-red-500': !success}" class="mb-4">
        {{ message }}
    </div>
</template>

<script>
export default {
    props: {
        message: String,
        success: Boolean
    }
};
</script>
