<template>
    <div class="flex flex-col md:flex-row min-h-screen">
        <ImageSection :currentImage="currentImage" @after-leave="onImageFadeOutComplete" />
        <div class="md:w-1/2 p-6 flex flex-col justify-center bg-white">
            <Header :step="step" />
            <Message :message="message" :success="success" />
            <StepSelection v-if="step === 0" @select="handleSelection" />
            <StepPersonalInfo v-if="step === 1" :isComplete="isPersonalInfoComplete" @continue="handleContinue" @goBack="goBack" />
            <StepAddress v-if="step === 2" @submit="submitForm" @goBack="goBack" />
        </div>
    </div>
</template>

<script>
import { ref, computed } from 'vue';
import axios from 'axios';
import StepSelection from './components/StepSelection.vue';
import StepPersonalInfo from './components/StepPersonalInfo.vue';
import StepAddress from './components/StepAddress.vue';
import Header from './components/Header.vue';
import Message from './components/Message.vue';
import ImageSection from './components/ImageSection.vue';

export default {
    components: { StepSelection, StepPersonalInfo, StepAddress, Header, Message, ImageSection },
    setup() {
        const step = ref(0);
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
            selection: null
        });
        const errors = ref({});
        const message = ref('');
        const success = ref(false);
        const fadingOut = ref(false);

        const images = [
            '/images/0.png',
            '/images/1.png',
            '/images/2.png'
        ];
        const currentImage = computed(() => images[step.value]);

        const isPersonalInfoComplete = computed(() => {
            return form.value.firstName && form.value.lastName && form.value.email && form.value.phone && form.value.contactPreference;
        });

        const handleSelection = () => {
            if (form.value.selection !== null) step.value = 1;
        };

        const handleContinue = () => {
            if (isPersonalInfoComplete.value) step.value = 2;
        };

        const goBack = () => {
            if (step.value === 2) step.value = 1;
            else if (step.value === 1) step.value = 0;
        };

        const submitForm = () => {
            axios.post('/api/personal-info', form.value)
                .then(response => {
                    message.value = response.data.message;
                    success.value = true;
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
                    step.value = 0;
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
            currentImage,
            isPersonalInfoComplete,
            handleSelection,
            handleContinue,
            goBack,
            submitForm,
            onImageFadeOutComplete
        };
    }
};
</script>

<style scoped>
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
