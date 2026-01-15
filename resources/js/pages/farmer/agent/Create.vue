<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import { store } from '@/routes/farmer/agents';
import { useForm } from '@inertiajs/vue3';
import { getLocalTimeZone } from '@internationalized/date';
import { computed, reactive, ref } from 'vue';

defineOptions({ layout: Layout });

const df = new Intl.DateTimeFormat('en-US', { dateStyle: 'long' });

const currentStep = ref(0);
const userType = ref<'agent'>('agent'); // currently only agent

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

const fields: Record<string, Field[]> = {
    agent: [
        { name: 'first_name', label: 'First Name', type: 'text', placeholder: 'Juan', required: true, autocomplete: 'given-name', step: 1 },
        { name: 'middle_name', label: 'Middle Name', type: 'text', placeholder: 'Dela', required: false, autocomplete: 'additional-name', step: 1 },
        { name: 'last_name', label: 'Last Name', type: 'text', placeholder: 'Cruz', required: true, autocomplete: 'family-name', step: 1 },
        { name: 'birthday', label: 'Birthday', type: 'date', required: true, autocomplete: 'bday', step: 1 },
        { name: 'gender', label: 'Gender', type: 'select', options: GenderOptions, required: true, step: 1 },
        { name: 'civil_status', label: 'Civil Status', type: 'select', options: CivilStatusOptions, required: true, step: 1 },

        { name: 'phone_number', label: 'Phone Number', type: 'tel', placeholder: '09123456789', required: true, autocomplete: 'tel', step: 2 },
        { name: 'email', label: 'Email', type: 'email', placeholder: 'juan@example.com', required: true, autocomplete: 'email', step: 2 },
        { name: 'address', label: 'Address', type: 'text', placeholder: '123 Street, City', required: true, autocomplete: 'street-address', step: 2 },

        {
            name: 'password',
            label: 'Password',
            type: 'password',
            placeholder: 'Password',
            required: true,
            trailing: true,
            autocomplete: 'new-password',
            step: 3,
        },
        {
            name: 'password_confirmation',
            label: 'Confirm Password',
            type: 'password',
            placeholder: 'Confirm Password',
            required: true,
            trailing: true,
            autocomplete: 'new-password',
            step: 3,
        },
    ],
};

const stepItems: Record<string, { title: string; description?: string; icon?: string }[]> = {
    agent: [
        { title: 'Personal Info', description: 'Name details', icon: 'i-lucide-id-card' },
        { title: 'Contact & Details', description: 'Contact information', icon: 'i-lucide-phone' },
        { title: 'Security', description: 'Password setup', icon: 'i-lucide-lock' },
    ],
};

const currentStepItems = computed(() => stepItems[userType.value]);
const totalSteps = computed(() => stepItems[userType.value].length);

function initializeForm(type: 'agent') {
    const formData: Record<string, any> = {};
    fields[type].forEach((field) => {
        formData[field.name] = '';
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

// reactive form
const form = useForm(initializeForm(userType.value));

// reactive object to toggle password visibility
const showPasswordFields = reactive<Record<string, boolean>>({});

// fields for current step
const currentStepFields = computed(() => fields[userType.value].filter((f) => f.step === currentStep.value + 1));

// computed to check if current step is valid
const isCurrentStepValid = computed(() => {
    return currentStepFields.value.every((f) => {
        if (f.required) {
            const value = form[f.name];
            return value !== '' && value !== null;
        }
        return true;
    });
});

function nextStep() {
    if (currentStep.value < totalSteps.value - 1) currentStep.value++;
}

function prevStep() {
    if (currentStep.value > 0) currentStep.value--;
}

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
    <UDashboardPanel id="agents">
        <template #header>
            <UDashboardNavbar title="Agents">
                <template #leading>
                    <UDashboardSidebarCollapse as="button" />
                </template>
                <template #right>
                    <AgentsAddModal />
                </template>
            </UDashboardNavbar>
        </template>

        <template #body>
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold">Add Agent</h2>

                <UButton :href="`/farmer/agents`" variant="outline" icon="i-lucide-arrow-left" size="sm"> Back </UButton>
            </div>

            <!-- Stepper -->
            <div class="mb-8">
                <UStepper v-model="currentStep" :items="currentStepItems" />
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <!-- Render fields for the current step -->
                    <template v-for="field in currentStepFields" :key="field.name">
                        <UFormField :name="field.name" :error="form.errors[field.name]" :label="field.label">
                            <!-- Select -->
                            <USelect
                                v-if="field.type === 'select'"
                                class="w-full"
                                v-model="form[field.name]"
                                :items="field.options"
                                option-attribute="label"
                                value-attribute="value"
                                :placeholder="`Select ${field.label.toLowerCase()}`"
                            />

                            <!-- Date picker -->
                            <UPopover v-else-if="field.type === 'date'">
                                <UButton color="neutral" variant="subtle" icon="i-lucide-calendar" block>
                                    {{ form[field.name] ? df.format(form[field.name].toDate(getLocalTimeZone())) : 'Select a date' }}
                                </UButton>

                                <template #content>
                                    <UCalendar v-model="form[field.name]" class="p-2" />
                                </template>
                            </UPopover>

                            <!-- File upload -->
                            <UFileUpload
                                v-else-if="field.type === 'file'"
                                v-model="form[field.name]"
                                :accept="field.accept"
                                :help="field.help"
                                class="w-full object-contain"
                            />

                            <!-- Textarea -->
                            <UTextarea
                                v-else-if="field.type === 'textarea'"
                                class="w-full"
                                v-model="form[field.name]"
                                :placeholder="field.placeholder"
                                :required="field.required"
                                :rows="4"
                            />

                            <!-- Checkbox -->
                            <UCheckbox v-else-if="field.type === 'checkbox'" class="w-full" v-model="form[field.name]" :label="field.label" />

                            <!-- Password / Text / Tel / Email / Default -->
                            <UInput
                                v-else
                                v-model="form[field.name]"
                                class="w-full"
                                :type="field.type === 'password' ? (showPasswordFields[field.name] ? 'text' : 'password') : field.type"
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
        </template>
    </UDashboardPanel>
</template>
