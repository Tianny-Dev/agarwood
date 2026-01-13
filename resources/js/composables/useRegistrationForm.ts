import { ref, computed, watch, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import type { RegistrationConfig, UserType } from '@/types/registration';

export function useRegistrationForm(config: RegistrationConfig) {
  const userType = ref<UserType>('farmer');
  const currentStep = ref(0);
  const maxReachedStep = ref(0);
  const showPasswordFields = reactive<Record<string, boolean>>({});

  // Get current configuration
  const currentConfig = computed(() => config[userType.value]);
  const currentStepItems = computed(() => currentConfig.value.steps);
  const totalSteps = computed(() => currentStepItems.value.length);
  
  // Get fields for current step
  const currentStepFields = computed(() => {
    if (currentStep.value === 0) return [];
    return currentConfig.value.fields.filter(
      field => field.step === currentStep.value + 1
    );
  });

  // Initialize form data
  const initializeForm = (type: UserType) => {
    const formData: Record<string, any> = {};
    config[type].fields.forEach(field => {
      formData[field.name] = field.type === 'file' ? null 
        : field.type === 'checkbox' ? false 
        : '';
    });
    return formData;
  };

  const form = useForm(initializeForm(userType.value));

  // Validation
  const isCurrentStepValid = computed(() => {
    if (currentStep.value === 0) return true;
    return currentStepFields.value.every(
      field => !field.required || !!form[field.name]
    );
  });

  // Navigation
  const nextStep = () => {
    if (isCurrentStepValid.value && currentStep.value < totalSteps.value - 1) {
      currentStep.value++;
      maxReachedStep.value = Math.max(maxReachedStep.value, currentStep.value);
    }
  };

  const prevStep = () => {
    if (currentStep.value > 0) currentStep.value--;
  };

  // Reset on user type change
  watch(userType, (newType) => {
    form.defaults(initializeForm(newType)).reset();
    Object.keys(showPasswordFields).forEach(k => delete showPasswordFields[k]);
    currentStep.value = 0;
    maxReachedStep.value = 0;
  });

  // Prevent skipping steps
  watch(currentStep, (newStep, oldStep) => {
    if (Math.abs(newStep - oldStep) !== 1 || newStep < oldStep) return;
    if (newStep > maxReachedStep.value + 1) {
      currentStep.value = oldStep;
    }
  });

  const submit = (url: string) => {
    form.transform(data => ({ ...data, user_type: userType.value }))
      .post(url, {
        onError: (errors) => {
          const firstErrorField = Object.keys(errors)[0];
          const fieldWithError = currentConfig.value.fields.find(
            f => f.name === firstErrorField
          );
          if (fieldWithError) {
            currentStep.value = fieldWithError.step - 1;
          }
        },
      });
  };

  return {
    userType,
    currentStep,
    maxReachedStep,
    form,
    showPasswordFields,
    currentStepItems,
    currentStepFields,
    totalSteps,
    isCurrentStepValid,
    nextStep,
    prevStep,
    submit,
  };
}