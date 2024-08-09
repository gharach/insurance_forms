<template>
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Image Section -->
        <div
            class="md:w-1/2 bg-gray-100 flex items-center justify-center relative"
            :class="{ 'opacity-0': fadingOut, 'opacity-100': !fadingOut }"
        >
            <transition name="fade" @after-leave="onImageFadeOutComplete">
                <img
                    :src="currentImage"
                    alt="Decorative Image"
                    class="w-full h-screen object-cover object-bottom transition-opacity duration-500 ease-in-out"
                />
            </transition>
            <!-- Loader (Optional) -->
            <div v-if="fadingOut" class="absolute inset-0 flex items-center justify-center bg-white opacity-75">
                <div class="loader">Loading...</div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="md:w-1/2 p-6 flex flex-col justify-center bg-white">
            <!-- Header and Introductory Text -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold mb-2">
                    {{ step === 0 ? 'Let’s Get Started' : step === 1 ? 'Personal Info' : 'Address Information' }}
                </h1>
                <p class="text-lg text-gray-700">
                    {{ step === 0 ? 'Please select' : step === 1 ? 'We can help with ...' : 'Provide your address details below.' }}
                </p>
            </div>

            <!-- Message Display -->
            <div v-if="message" class="p-4 mb-4 rounded" :class="{'bg-green-500': success, 'bg-red-500': !success}">
                {{ message }}
            </div>

            <!-- Step 0: Selection Form -->
            <form v-if="step === 0" @submit.prevent="handleSelection" class="space-y-4">
                <div class="space-y-4">
                    <div v-for="(option, index) in options" :key="index" class="flex items-center">
                        <input
                            type="radio"
                            :id="'option' + index"
                            :value="option.value"
                            v-model="form.selection"
                            class="hidden"
                        />
                        <label
                            :for="'option' + index"
                            class="cursor-pointer block p-4 border border-blue-300 rounded w-full text-left font-bold text-white bg-gradient-to-r from-blue-900 to-blue-700"
                            :class="{
                                'border-4 bg-blue-100 border-blue-500': form.selection === option.value,
                                'bg-white': form.selection !== option.value
                            }"
                        >
                            {{ option.label }}
                        </label>
                    </div>
                </div>

                <button
                    type="submit"
                    class="bg-blue-500 text-white p-2 rounded w-full"
                    :disabled="form.selection === null"
                >
                    Continue
                </button>
            </form>

            <!-- Personal Info Form -->
            <form v-if="step === 1" @submit.prevent="handleContinue" class="space-y-4">
                <!-- Row 1: First Name and Last Name -->
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

                <!-- Row 2: Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input v-model="form.email" type="email" id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                    <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
                </div>

                <!-- Row 3: Phone Number -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input v-model="form.phone" type="text" id="phone" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                    <span v-if="errors.phone" class="text-red-600 text-sm">{{ errors.phone }}</span>
                </div>

                <!-- Row 4: Contact Preference -->
                <div class="mb-4">
                    <label for="contactPreference" class="block text-sm font-medium text-gray-700">Contact Preference</label>
                    <select v-model="form.contactPreference" id="contactPreference" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <option value="email" selected>Email</option>
                        <option value="phone">Phone</option>
                    </select>
                    <span v-if="errors.contactPreference" class="text-red-600 text-sm">{{ errors.contactPreference }}</span>
                </div>

                <!-- Buttons: Continue and Back -->
                <div class="flex flex-col gap-4">
                    <button
                        type="submit"
                        :disabled="!isPersonalInfoComplete"
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
                </div>
            </form>

            <!-- Address Form -->
            <form v-if="step === 2" @submit.prevent="submitForm" class="space-y-4">
                <!-- Row 1: Street Address and Apt -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="streetAddress" class="block text-sm font-medium text-gray-700">Street Address</label>
                        <input v-model="form.streetAddress" type="text" id="streetAddress" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                        <span v-if="errors.streetAddress" class="text-red-600 text-sm">{{ errors.streetAddress }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="apt" class="block text-sm font-medium text-gray-700">Apt/Ste</label>
                        <input v-model="form.apt" type="text" id="apt" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                        <span v-if="errors.apt" class="text-red-600 text-sm">{{ errors.apt }}</span>
                    </div>
                </div>

                <!-- Row 2: City, State, and Zip Code -->
                <div class="grid grid-cols-1 gap-4">
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

                    <div class="mb-4">
                        <label for="zipCode" class="block text-sm font-medium text-gray-700">Zip Code</label>
                        <input v-model="form.zipCode" type="text" id="zipCode" class="mt-1 block w-full p-2 border border-gray-300 rounded" />
                        <span v-if="errors.zipCode" class="text-red-600 text-sm">{{ errors.zipCode }}</span>
                    </div>
                </div>

                <!-- Buttons: Submit and Back -->
                <div class="flex flex-col gap-4">
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
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { ref, computed } from 'vue';

export default {
    setup() {
        const step = ref(0); // Initialize with step 0
        const form = ref({
            firstName: '',
            lastName: '',
            email: '',
            streetAddress: '',
            apt: '',
            city: '',
            state: '',
            zipCode: '',
            phone: '',
            contactPreference: 'email',
            selection: null // For Step 0
        });

        const errors = ref({});
        const message = ref('');
        const success = ref(false);
        const fadingOut = ref(false);

        // Images for each step
        const images = [
            '/images/0.png', // Step 0 image
            '/images/1.png',
            '/images/2.png'
        ];
        const currentImage = computed(() => images[step.value]);

        // Options for Step 0
        const options = [
            { value: 0, label: 'Home' },
            { value: 1, label: 'Auto' },
            { value: 2, label: 'Recreational Vehicle' }
        ];

        // Computed property to check if personal info is complete
        const isPersonalInfoComplete = computed(() => {
            return form.value.firstName && form.value.lastName && form.value.email && form.value.phone && form.value.contactPreference;
        });

        // Function to handle selection in Step 0 and move to Step 1
        const handleSelection = () => {
            if (form.value.selection !== null) {
                step.value = 1;
            }
        };

        // Function to move to the address form
        const handleContinue = () => {
            if (isPersonalInfoComplete.value) {
                step.value = 2;
            }
        };

        // Function to go back between steps
        const goBack = () => {
            if (step.value === 2) {
                step.value = 1;
            } else if (step.value === 1) {
                step.value = 0;
            }
        };

        // Function to submit the full form
        const submitForm = () => {
            console.log('Submitting data:', form.value);
            axios.post('/api/personal-info', form.value)
                .then(response => {
                    message.value = response.data.message;
                    success.value = true;
                    // Optionally clear the form
                    form.value = {
                        firstName: '',
                        lastName: '',
                        email: '',
                        streetAddress: '',
                        apt: '',
                        city: '',
                        state: '',
                        zipCode: '',
                        phone: '',
                        contactPreference: 'email',
                        selection: null
                    };
                    step.value = 0; // Reset to step 0
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        errors.value = error.response.data.errors;
                        message.value = 'Please correct the errors in the form.';
                        success.value = false;
                    } else {
                        message.value = 'An unexpected error occurred.';
                        success.value = false;
                    }
                });
        };

        // Function to handle image fade-out completion
        const onImageFadeOutComplete = () => {
            fadingOut.value = false;
        };

        return {
            step,
            form,
            errors,
            message,
            success,
            fadingOut,
            options,
            isPersonalInfoComplete,
            handleSelection,
            handleContinue,
            goBack,
            submitForm,
            currentImage
        };
    }
};
</script>

<style scoped>
/* Add any additional custom styles here */
.loader {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    border-top: 4px solid #3498db;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
