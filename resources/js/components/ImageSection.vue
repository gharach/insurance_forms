<template>
    <transition name="fade" @after-leave="afterLeave">
        <img v-if="currentImage" :src="currentImage" alt="Step Image" class="w-full h-full object-cover transition-opacity duration-500" />
    </transition>
</template>

<script>
export default {
    props: {
        currentImage: String
    },
    emits: ['after-leave'],
    methods: {
        afterLeave() {
            this.$emit('after-leave');
        }
    }
};
</script>
