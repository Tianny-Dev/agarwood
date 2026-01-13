<script setup lang="ts">
import type { Field } from '@/types/registration';
import { getLocalTimeZone } from '@internationalized/date';

defineProps<{
    field: Field;
    modelValue: any;
    error?: string;
    showPassword?: boolean;
}>();

const emit = defineEmits<{
    'update:modelValue': [value: any];
    'toggle-password': [];
}>();

const df = new Intl.DateTimeFormat('en-US', { dateStyle: 'long' });
</script>

<template>
    <UFormField :name="field.name" :error="error" :label="field.label">
        <!-- Select -->
        <USelect
            v-if="field.type === 'select'"
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
            :items="field.options"
            option-attribute="label"
            value-attribute="value"
            :placeholder="`Select ${field.label.toLowerCase()}`"
            class="w-full"
        />

        <!-- Date Picker -->
        <UPopover v-else-if="field.type === 'date'">
            <UButton color="neutral" variant="subtle" icon="i-lucide-calendar" block>
                {{ modelValue ? df.format(modelValue.toDate(getLocalTimeZone())) : 'Select a date' }}
            </UButton>
            <template #content>
                <UCalendar :model-value="modelValue" @update:model-value="emit('update:modelValue', $event)" class="p-2" />
            </template>
        </UPopover>

        <!-- File Upload -->
        <UFileUpload
            v-else-if="field.type === 'file'"
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
            :accept="field.accept"
            :help="field.help"
            class="w-full"
        />

        <!-- Textarea -->
        <UTextarea
            v-else-if="field.type === 'textarea'"
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
            :placeholder="field.placeholder"
            :required="field.required"
            :rows="4"
            class="w-full"
        />

        <!-- Checkbox -->
        <UCheckbox
            v-else-if="field.type === 'checkbox'"
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
            :label="field.label"
            class="w-full"
        />

        <!-- Input (text, email, password, etc) -->
        <UInput
            v-else
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
            :type="field.type === 'password' && showPassword !== undefined ? (showPassword ? 'text' : 'password') : field.type"
            :autocomplete="field.autocomplete || 'off'"
            :placeholder="field.placeholder"
            :required="field.required"
            :ui="field.trailing ? { trailing: 'pe-1' } : {}"
            class="w-full"
        >
            <template #trailing v-if="field.trailing">
                <UButton
                    color="neutral"
                    variant="link"
                    size="sm"
                    :icon="showPassword ? 'i-lucide-eye-off' : 'i-lucide-eye'"
                    @click="emit('toggle-password')"
                />
            </template>
        </UInput>
    </UFormField>
</template>
