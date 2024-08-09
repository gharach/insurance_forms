<template>
    <div class="text-2xl font-bold mb-4">
        Step {{ step + 1 }}: {{ stepTitles[step] }}
    </div>
</template>

<script>
export default {
    props: {
        step: Number
    },
    computed: {
        stepTitles() {
            return ['Select Option', 'Personal Information', 'Address'];
        }
    }
};
</script>
