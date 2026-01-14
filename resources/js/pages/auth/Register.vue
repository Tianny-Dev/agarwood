<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/Auth/RegisterController';
import RegistrationStepContent from '@/components/auth/RegistrationStepContent.vue';
import { useRegistrationForm } from '@/composables/useRegistrationForm';
import { registrationConfig } from '@/config/registration';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Head } from '@inertiajs/vue3';

const userTypeOptions = [
    { value: 'farmer', label: 'Farmer' },
    { value: 'investor', label: 'Investor' },
    { value: 'partner', label: 'Partner' },
];

const {
    userType,
    currentStep,
    form,
    showPasswordFields,
    currentStepItems,
    currentStepFields,
    totalSteps,
    isCurrentStepValid,
    nextStep,
    prevStep,
    submit,
} = useRegistrationForm(registrationConfig);

const handleSubmit = () => submit(store.url());
</script>

<template>
    <Head title="Register" />

    <AuthLayout>
        <!-- <h2 class="mb-4 text-center text-2xl font-semibold">Create an account</h2> -->
        <h2 class="mb-4 text-center text-2xl font-semibold">
            {{ userType ? `Create ${userType.charAt(0).toUpperCase() + userType.slice(1)} Account` : 'Create an Account' }}
        </h2>

        <div class="mb-8">
            <UStepper disabled v-model="currentStep" :items="currentStepItems" />
        </div>

        <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <!-- Step 1: User Type Selection -->
                <div v-if="currentStep === 0">
                    <UFormField label="Account Type" name="user_type">
                        <USelect
                            v-model="userType"
                            :items="userTypeOptions"
                            option-attribute="label"
                            value-attribute="value"
                            placeholder="Select account type"
                            class="w-full"
                        />
                    </UFormField>
                </div>

                <!-- Other Steps: Dynamic Fields -->
                <template v-else>
                    <RegistrationStepContent
                        v-for="field in currentStepFields"
                        :key="field.name"
                        :field="field"
                        v-model="form[field.name]"
                        :error="form.errors[field.name]"
                        :show-password="showPasswordFields[field.name]"
                        @toggle-password="showPasswordFields[field.name] = !showPasswordFields[field.name]"
                    />
                </template>

                <!-- Navigation Buttons -->
                <div class="mt-4 flex gap-3">
                    <UButton v-if="currentStep > 0" variant="outline" @click="prevStep" class="flex flex-1 items-center justify-center">
                        Previous
                    </UButton>

                    <UButton
                        v-if="currentStep < totalSteps - 1"
                        @click="nextStep"
                        :disabled="!isCurrentStepValid"
                        class="flex flex-1 items-center justify-center"
                    >
                        Next
                    </UButton>

                    <UButton v-else :loading="form.processing" type="submit" class="flex flex-1 items-center justify-center"> Register </UButton>
                </div>
            </div>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account?
            <TextLink :href="login()" class="text-sm font-medium text-primary">Log In</TextLink>
        </p>
    </AuthLayout>
</template>
