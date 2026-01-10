<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/Auth/RegisterController';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Head, useForm } from '@inertiajs/vue3';
import { getLocalTimeZone } from '@internationalized/date';
import { computed, reactive, ref, watch } from 'vue';

const df = new Intl.DateTimeFormat('en-US', { dateStyle: 'long' });

const userType = ref<'farmer' | 'investor'>('farmer');
const currentStep = ref(0);

// Options for user type select
const userTypeOptions = [
    { value: 'farmer', label: 'Farmer' },
    { value: 'investor', label: 'Investor' },
];

const GenderOptions = [
    { value: 'male', label: 'Male' },
    { value: 'female', label: 'Female' },
    { value: 'other', label: 'Other' },
];

const CivilStatusOptions = [
    { value: 'single', label: 'Single' },
    { value: 'married', label: 'Married' },
    { value: 'widowed', label: 'Widowed' },
    { value: 'separated', label: 'Separated' },
    { value: 'divorced', label: 'Divorced' },
];

const IdTypeOptions = [
    { value: 'passport', label: 'Passport' },
    { value: 'drivers_license', label: 'Driver’s License' },
    { value: 'national_id', label: 'National ID' },
    { value: 'sss', label: 'SSS' },
    { value: 'philhealth', label: 'PhilHealth' },
    { value: 'tin', label: 'TIN' },
    { value: 'voters_id', label: 'Voter’s ID' },
];

interface Field {
    name: string;
    label: string;
    type: string;
    placeholder?: string;
    required?: boolean;
    autocomplete?: string;
    trailing?: boolean;
    step: number;
    options?: { value: string; label: string }[];
    accept?: string;
    help?: string;
}

// Define fields with step information
const fields: Record<string, Field[]> = {
    farmer: [
        { name: 'first_name', label: 'First Name', type: 'text', placeholder: 'Juan', required: true, autocomplete: 'given-name', step: 2 },
        { name: 'middle_name', label: 'Middle Name', type: 'text', placeholder: 'Dela', required: false, autocomplete: 'additional-name', step: 2 },
        { name: 'last_name', label: 'Last Name', type: 'text', placeholder: 'Cruz', required: true, autocomplete: 'family-name', step: 2 },
        { name: 'birthday', label: 'Birthday', type: 'date', required: true, autocomplete: 'bday', step: 2 },
        { name: 'gender', label: 'Gender', type: 'select', options: GenderOptions, required: true, step: 2 },
        { name: 'civil_status', label: 'Civil Status', type: 'select', options: CivilStatusOptions, required: true, step: 2 },

        { name: 'phone_number', label: 'Phone Number', type: 'tel', placeholder: '09123456789', required: true, autocomplete: 'tel', step: 3 },
        { name: 'email', label: 'Email', type: 'email', placeholder: 'juan@example.com', required: true, autocomplete: 'email', step: 3 },
        { name: 'address', label: 'Address', type: 'text', placeholder: '123 Street, City', required: true, autocomplete: 'street-address', step: 3 },

        {
            name: 'farming_background',
            label: 'Farming Background',
            type: 'textarea',
            placeholder: 'Describe your experience',
            required: false,
            step: 4,
        },
        { name: 'years_of_farming', label: 'Years of Farming', type: 'number', placeholder: '5', required: false, step: 4 },
        { name: 'familiarity_tree_cultivation', label: 'Familiarity with Tree Cultivation', type: 'checkbox', required: false, step: 4 },
        {
            name: 'password',
            label: 'Password',
            type: 'password',
            placeholder: 'Password',
            required: true,
            trailing: true,
            autocomplete: 'new-password',
            step: 5,
        },
        {
            name: 'password_confirmation',
            label: 'Confirm Password',
            type: 'password',
            placeholder: 'Confirm Password',
            required: true,
            trailing: true,
            autocomplete: 'new-password',
            step: 5,
        },
    ],

    investor: [
        { name: 'first_name', label: 'First Name', type: 'text', placeholder: 'Juan', required: true, autocomplete: 'given-name', step: 2 },
        { name: 'middle_name', label: 'Middle Name', type: 'text', placeholder: 'Dela', required: false, autocomplete: 'additional-name', step: 2 },
        { name: 'last_name', label: 'Last Name', type: 'text', placeholder: 'Cruz', required: true, autocomplete: 'family-name', step: 2 },
        { name: 'birthday', label: 'Birthday', type: 'date', required: true, autocomplete: 'bday', step: 2 },
        { name: 'gender', label: 'Gender', type: 'select', options: GenderOptions, required: true, step: 2 },
        { name: 'civil_status', label: 'Civil Status', type: 'select', options: CivilStatusOptions, required: true, step: 2 },

        { name: 'phone_number', label: 'Phone Number', type: 'tel', placeholder: '09123456789', required: true, autocomplete: 'tel', step: 3 },
        { name: 'email', label: 'Email', type: 'email', placeholder: 'juan@example.com', required: true, autocomplete: 'email', step: 3 },
        { name: 'address', label: 'Address', type: 'text', placeholder: '123 Street, City', required: true, autocomplete: 'street-address', step: 3 },

        { name: 'id_type', label: 'ID Type', type: 'select', options: IdTypeOptions, required: true, step: 4 },
        {
            name: 'id_front',
            label: 'ID Front',
            type: 'file',
            accept: 'image/*,.pdf',
            help: 'Upload a clear photo of the front of your ID',
            required: true,
            step: 4,
        },
        {
            name: 'id_back',
            label: 'ID Back',
            type: 'file',
            accept: 'image/*,.pdf',
            help: 'Upload a clear photo of the back of your ID',
            required: true,
            step: 4,
        },

        {
            name: 'password',
            label: 'Password',
            type: 'password',
            placeholder: 'Password',
            required: true,
            trailing: true,
            autocomplete: 'new-password',
            step: 5,
        },
        {
            name: 'password_confirmation',
            label: 'Confirm Password',
            type: 'password',
            placeholder: 'Confirm Password',
            required: true,
            trailing: true,
            autocomplete: 'new-password',
            step: 5,
        },
    ],
};

// Define steps for each user type
const stepItems: Record<string, { title: string; description?: string; icon?: string }[]> = {
    farmer: [
        { title: 'Account Type', description: 'Choose your role', icon: 'i-lucide-user' },
        { title: 'Personal Info', description: 'Name details', icon: 'i-lucide-id-card' },
        { title: 'Contact & Details', description: 'Contact information', icon: 'i-lucide-phone' },
        { title: 'Farming Background', description: 'Your experience', icon: 'i-lucide-sprout' },
        { title: 'Security', description: 'Password setup', icon: 'i-lucide-lock' },
    ],
    investor: [
        { title: 'Account Type', description: 'Choose your role', icon: 'i-lucide-user' },
        { title: 'Personal Info', description: 'Name details', icon: 'i-lucide-id-card' },
        { title: 'Contact & Details', description: 'Contact information', icon: 'i-lucide-phone' },
        { title: 'ID Verification', description: 'Upload your ID', icon: 'i-lucide-file-check' },
        { title: 'Security', description: 'Password setup', icon: 'i-lucide-lock' },
    ],
};

// Get current step items based on user type
const currentStepItems = computed(() => stepItems[userType.value]);

// Get total steps for current user type
const totalSteps = computed(() => stepItems[userType.value].length);

// Filter fields by current step
const currentStepFields = computed(() => {
    if (currentStep.value === 0) {
        return [];
    }
    return fields[userType.value].filter((field) => field.step === currentStep.value + 1);
});

// Initialize form with all fields for the current user type
// function initializeForm(type: 'farmer' | 'investor') {
//     const formData: Record<string, any> = {};
//     fields[type].forEach((field) => {
//         formData[field.name] = '';
//     });
//     return formData;
// }
function initializeForm(type: 'farmer' | 'investor') {
    const formData: Record<string, any> = {};
    fields[type].forEach((field) => {
        if (field.type === 'file') {
            formData[field.name] = null;
        } else if (field.type === 'checkbox') {
            formData[field.name] = false;
        } else {
            formData[field.name] = '';
        }
    });
    return formData;
}

const form = useForm(initializeForm(userType.value));

const showPasswordFields = reactive<Record<string, boolean>>({});
fields[userType.value].forEach((f) => {
    if (f.type === 'password') showPasswordFields[f.name] = false;
});

// Track the maximum step reached
const maxReachedStep = ref(0);

// Watch for userType change and reinitialize form
watch(userType, (newType) => {
    // Get the new form structure
    const newFormData = initializeForm(newType);

    // Reset the form with new data
    form.defaults(newFormData).reset();

    // Reset password visibility toggles
    Object.keys(showPasswordFields).forEach((k) => delete showPasswordFields[k]);
    fields[newType].forEach((f) => {
        if (f.type === 'password') showPasswordFields[f.name] = false;
    });

    currentStep.value = 0;
    maxReachedStep.value = 0;
});

// Validate current step fields
const isCurrentStepValid = computed(() => {
    if (currentStep.value === 0) {
        return true;
    }

    const stepFields = currentStepFields.value;
    for (const field of stepFields) {
        if (field.required && !form[field.name]) {
            return false;
        }
    }
    return true;
});

// Go to next step
function nextStep() {
    if (isCurrentStepValid.value && currentStep.value < totalSteps.value - 1) {
        currentStep.value++;
        if (currentStep.value > maxReachedStep.value) {
            maxReachedStep.value = currentStep.value;
        }
    }
}

// Go to previous step
function prevStep() {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
}

// Watch for manual stepper clicks and validate
watch(currentStep, (newStep, oldStep) => {
    // Only validate if user clicked on stepper (not using next/prev buttons)
    if (Math.abs(newStep - oldStep) !== 1 || newStep < oldStep) {
        return; // Allow going back or using buttons
    }

    // Prevent skipping ahead past max reached step
    if (newStep > maxReachedStep.value + 1) {
        currentStep.value = oldStep;
    }
});

function submit() {
    form.transform((data) => ({
        ...data,
        user_type: userType.value,
    })).post(store.url(), {
        onError: (errors) => {
            const errorFieldNames = Object.keys(errors);
            if (errorFieldNames.length > 0) {
                const firstErrorField = errorFieldNames[0];

                const fieldWithError = fields[userType.value].find((f) => f.name === firstErrorField);

                if (fieldWithError) {
                    currentStep.value = fieldWithError.step - 1;
                }
            }
        },
    });
}
</script>

<template>
    <Head title="Register" />

    <AuthLayout>
        <h2 class="mb-4 text-center text-2xl font-semibold">Create an account</h2>

        <!-- Stepper -->
        <div class="mb-8">
            <UStepper disabled v-model="currentStep" :items="currentStepItems" />
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <!-- Step 1: User type selector -->
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

                <!-- Other steps: Render only current step fields -->
                <template v-else v-for="field in currentStepFields" :key="field.name">
                    <UFormField :name="field.name" :error="form.errors[field.name]" :label="field.label">
                        <!-- Select fields -->
                        <USelect
                            v-if="field.type === 'select'"
                            class="w-full"
                            v-model="form[field.name]"
                            :items="field.options"
                            option-attribute="label"
                            value-attribute="value"
                            :placeholder="`Select ${field.label.toLowerCase()}`"
                        />

                        <!-- Date picker fields -->
                        <UPopover v-else-if="field.type === 'date'">
                            <UButton color="neutral" variant="subtle" icon="i-lucide-calendar" block>
                                {{ form[field.name] ? df.format(form[field.name].toDate(getLocalTimeZone())) : 'Select a date' }}
                            </UButton>

                            <template #content>
                                <UCalendar v-model="form[field.name]" class="p-2" />
                            </template>
                        </UPopover>

                        <!-- File upload fields -->
                        <UFileUpload
                            v-else-if="field.type === 'file'"
                            v-model="form[field.name]"
                            :accept="field.accept"
                            :help="field.help"
                            class="w-full object-contain"
                        />

                        <!-- Textarea fields -->
                        <UTextarea
                            v-else-if="field.type === 'textarea'"
                            class="w-full"
                            v-model="form[field.name]"
                            :placeholder="field.placeholder"
                            :required="field.required"
                            :rows="4"
                        />

                        <!-- Checkbox fields -->
                        <UCheckbox v-else-if="field.type === 'checkbox'" class="w-full" v-model="form[field.name]" :label="field.label" />

                        <UInput
                            v-else
                            v-model="form[field.name]"
                            class="w-full"
                            :type="
                                field.type === 'password' && showPasswordFields[field.name] !== undefined
                                    ? showPasswordFields[field.name]
                                        ? 'text'
                                        : 'password'
                                    : field.type
                            "
                            :autocomplete="field.autocomplete || 'off'"
                            :placeholder="field.placeholder"
                            :required="field.required"
                            :ui="field.trailing ? { trailing: 'pe-1' } : {}"
                        >
                            <template #trailing v-if="field.trailing">
                                <UButton
                                    color="neutral"
                                    variant="link"
                                    size="sm"
                                    :icon="showPasswordFields[field.name] ? 'i-lucide-eye-off' : 'i-lucide-eye'"
                                    :aria-label="showPasswordFields[field.name] ? 'Hide password' : 'Show password'"
                                    :aria-pressed="showPasswordFields[field.name]"
                                    @click="showPasswordFields[field.name] = !showPasswordFields[field.name]"
                                />
                            </template>
                        </UInput>
                    </UFormField>
                </template>

                <!-- Navigation buttons -->
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
