<template>
    <form @submit.prevent="handleContinue" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                <input v-model="form.firstName" type="text" id="firstName" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                <span v-if="errors.firstName" class="text-red-600 text-sm">{{ errors.firstName }}</span>
            </div>

            <div class="mb-4">
                <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input v-model="form.lastName" type="text" id="lastName" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                <span v-if="errors.lastName" class="text-red-600 text-sm">{{ errors.lastName }}</span>
            </div>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input v-model="form.email" type="email" id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
            <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input v-model="form.phone" type="text" id="phone" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
            <span v-if="errors.phone" class="text-red-600 text-sm">{{ errors.phone }}</span>
        </div>

        <div class="mb-4">
            <label for="contactPreference" class="block text-sm font-medium text-gray-700">Contact Preference</label>
            <select v-model="form.contactPreference" id="contactPreference" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                <option value="email" selected>Email</option>
                <option value="phone">Phone</option>
            </select>
            <span v-if="errors.contactPreference" class="text-red-600 text-sm">{{ errors.contactPreference }}</span>
        </div>

        <button
            type="submit"
            :disabled="!isComplete"
            class="bg-blue-500 text-white p-2 rounded w-full"
        >
            Continue
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
    props: {
        isComplete: Boolean
    },
    emits: ['continue', 'goBack'],
    data() {
        return {
            form: {
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
                contactPreference: 'email'
            },
            errors: {}
        };
    },
    methods: {
        handleContinue() {
            if (this.isComplete) {
                this.$emit('continue');
            }
        },
        goBack() {
            this.$emit('goBack');
        }
    }
};
</script>
