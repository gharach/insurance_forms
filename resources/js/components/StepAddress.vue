<template>
    <form @submit.prevent="handleSubmit" class="space-y-4">
        <div class="mb-4">
            <label for="streetAddress" class="block text-sm font-medium text-gray-700">Street Address</label>
            <input v-model="form.streetAddress" type="text" id="streetAddress" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
            <span v-if="errors.streetAddress" class="text-red-600 text-sm">{{ errors.streetAddress }}</span>
        </div>

        <div class="mb-4">
            <label for="apt" class="block text-sm font-medium text-gray-700">Apt, Suite, Bldg (optional)</label>
            <input v-model="form.apt" type="text" id="apt" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <input v-model="form.city" type="text" id="city" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                <span v-if="errors.city" class="text-red-600 text-sm">{{ errors.city }}</span>
            </div>

            <div class="mb-4">
                <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                <input v-model="form.state" type="text" id="state" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                <span v-if="errors.state" class="text-red-600 text-sm">{{ errors.state }}</span>
            </div>
        </div>

        <div class="mb-4">
            <label for="zipCode" class="block text-sm font-medium text-gray-700">Zip Code</label>
            <input v-model="form.zipCode" type="text" id="zipCode" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
            <span v-if="errors.zipCode" class="text-red-600 text-sm">{{ errors.zipCode }}</span>
        </div>

        <button
            type="submit"
            class="bg-blue-500 text-white p-2 rounded w-full"
        >
            Submit
        </button>
        <button
            type="button"
            @click="goBack"
            class="bg-white text-blue-500 p-2 font-bold rounded w-full"
        >
            Back
        </button>
    </form>
</template>

<script>
export default {
    emits: ['submit', 'goBack'],
    data() {
        return {
            form: {
                streetAddress: '',
                apt: '',
                city: '',
                state: '',
                zipCode: ''
            },
            errors: {}
        };
    },
    methods: {
        handleSubmit() {
            this.$emit('submit');
        },
        goBack() {
            this.$emit('goBack');
        }
    }
};
</script>
