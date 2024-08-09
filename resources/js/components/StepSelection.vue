<template>
    <form @submit.prevent="handleSubmit" class="space-y-4">
        <div class="space-y-4">
            <div v-for="(option, index) in options" :key="index" class="flex items-center">
                <input
                    type="radio"
                    :id="'option' + index"
                    :value="option.value"
                    v-model="selection"
                    class="hidden"
                />
                <label
                    :for="'option' + index"
                    class="cursor-pointer block p-4 border border-gray-300 rounded w-full text-center"
                    :class="{
                        'bg-blue-100 border-blue-500': selection === option.value,
                        'bg-white': selection !== option.value
                    }"
                >
                    {{ option.label }}
                </label>
            </div>
        </div>

        <button
            type="submit"
            class="bg-blue-500 text-white p-2 rounded w-full"
            :disabled="selection === null"
        >
            Continue
        </button>
    </form>
</template>

<script>
export default {
    props: {
        value: Number
    },
    emits: ['select'],
    data() {
        return {
            selection: this.value,
            options: [
                { value: 0, label: 'Home' },
                { value: 1, label: 'Auto' },
                { value: 2, label: 'Recreational Vehicle' }
            ]
        };
    },
    methods: {
        handleSubmit() {
            if (this.selection !== null) {
                this.$emit('select');
            }
        }
    }
};
</script>
