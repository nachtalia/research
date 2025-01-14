<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Define the props
defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Initialize form state with only lrn (no password)
const form = useForm({
    lrn: '',  // LRN for student login
    remember: false,
});

// Submit form data to the backend
const submit = () => {
    form.post(route('studentlogin.store'), {
        onFinish: () => form.reset(), // Reset form after submission
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Student Login" />

        <!-- Display status message -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <!-- LRN Field -->
            <div>
                <InputLabel for="lrn" value="LRN" />

                <TextInput
                    id="lrn"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lrn"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.lrn" />
            </div>

            <div class="flex items-center justify-end space-x-4 mt-4">
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-600 underline hover:text-gray-900 focus:ring-2 focus:ring-indigo-500"
                >
                    Teacher Login
                </Link>

                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
