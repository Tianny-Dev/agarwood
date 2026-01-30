<script setup lang="ts">
import { update } from '@/actions/App/Http/Controllers/Settings/ProfileController';
import Layout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/SettingsLayout.vue';
import { send } from '@/routes/verification';
import { Head } from '@inertiajs/vue3';
import type { FormSubmitEvent } from '@nuxt/ui';
import * as z from 'zod';

defineOptions({ layout: Layout });

defineProps<{
    mustVerifyEmail: boolean;
    status?: string;
}>();

const fileRef = ref<HTMLInputElement>();

const profileSchema = z.object({
    first_name: z.string().min(2, 'Too short'),
    middle_name: z.string().min(2, 'Too short'),
    last_name: z.string().min(2, 'Too short'),
    email: z.email('Invalid email'),
    avatar: z.string().optional(),
});

type ProfileSchema = z.output<typeof profileSchema>;
const auth = useAuth();

const profile = reactive<Partial<ProfileSchema>>({
    first_name: auth.value.user.first_name,
    middle_name: auth.value.user.middle_name,
    last_name: auth.value.user.last_name,
    email: auth.value.user.email,
    avatar: undefined,
});

const form = useForm<Partial<ProfileSchema>>({
    first_name: '',
    middle_name: '',
    last_name: '',
    email: '',
    avatar: undefined,
});

const toast = useToast();
async function onSubmit(event: FormSubmitEvent<ProfileSchema>) {
    form.first_name = event.data.first_name;
    form.middle_name = event.data.middle_name;
    form.last_name = event.data.last_name;
    form.email = event.data.email;
    form.avatar = event.data.avatar;

    form.submit(update(), {
        onSuccess: () => {
            toast.add({
                title: 'Success',
                description: 'Your settings have been updated.',
                icon: 'i-lucide-check',
                color: 'success',
            });
        },

        onError: (errors) => {
            toast.add({
                title: 'Error',
                description: Object.values(errors)[0] ?? 'Something went wrong.',
                icon: 'i-lucide-x',
                color: 'error',
            });
        },
    });
}

function onFileChange(e: Event) {
    const input = e.target as HTMLInputElement;

    if (!input.files?.length) {
        return;
    }

    profile.avatar = URL.createObjectURL(input.files[0]);
}

function onFileClick() {
    fileRef.value?.click();
}
</script>

<template>
    <SettingsLayout>
        <Head title="Profile settings" />

        <UForm id="settings" :schema="profileSchema" :state="profile" @submit="onSubmit">
            <UPageCard
                title="Profile"
                description="These informations will be displayed publicly."
                variant="naked"
                orientation="horizontal"
                class="mb-4"
            >
                <UButton form="settings" label="Save changes" color="primary" type="submit" class="w-fit lg:ms-auto" />
            </UPageCard>

            <UPageCard variant="subtle">
                <UFormField name="first_name" label="First Name" required class="flex items-start justify-between gap-4 max-sm:flex-col">
                    <UInput v-model="profile.first_name" autocomplete="off" />
                </UFormField>

                <UFormField name="middle_name" label="Middle Name" required class="flex items-start justify-between gap-4 max-sm:flex-col">
                    <UInput v-model="profile.middle_name" autocomplete="off" />
                </UFormField>

                <UFormField name="last_name" label="Last Name" required class="flex items-start justify-between gap-4 max-sm:flex-col">
                    <UInput v-model="profile.last_name" autocomplete="off" />
                </UFormField>

                <USeparator />
                <UFormField name="email" label="Email" required class="flex items-start justify-between gap-4 max-sm:flex-col">
                    <template #description>
                        <p class="text-muted">Used to sign in, for email receipts and product updates.</p>
                        <div v-if="mustVerifyEmail && !auth.user.email_verified_at">
                            <p class="text-muted">
                                Your email address is unverified.
                                <TextLink :href="send()" as="button" class="text-sm font-medium text-primary">
                                    Click here to resend the verification email.
                                </TextLink>
                            </p>

                            <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                                A new verification link has been sent to your email address.
                            </div>
                        </div>
                    </template>
                    <UInput v-model="profile.email" type="email" autocomplete="off" />
                </UFormField>
                <USeparator />
                <UFormField
                    name="avatar"
                    label="Avatar"
                    description="JPG, GIF or PNG. 1MB Max."
                    class="flex justify-between gap-4 max-sm:flex-col sm:items-center"
                >
                    <div class="flex flex-wrap items-center gap-3">
                        <UAvatar :src="profile.avatar" :alt="profile.first_name" size="lg" />
                        <UButton label="Choose" color="primary" @click="onFileClick" />
                        <input ref="fileRef" type="file" class="hidden" accept=".jpg, .jpeg, .png, .gif" @change="onFileChange" />
                    </div>
                </UFormField>
            </UPageCard>
        </UForm>
    </SettingsLayout>
</template>
