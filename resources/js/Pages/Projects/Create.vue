<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    slug: '',
    description: ''
});

// Auto-generate slug from name
const generateSlug = () => {
    form.slug = form.name
        .toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
};

const submit = () => {
    form.post(route('projects.store'));
};
</script>

<template>
    <Head title="Create Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Project</h2>
        </template>

        <div class="py-12">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit">
                        
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Project Name</label>
                            <input 
                                v-model="form.name" 
                                @input="generateSlug"
                                type="text" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1"
                            >
                            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Slug (URL)</label>
                            <input 
                                v-model="form.slug" 
                                type="text" 
                                class="bg-gray-100 border-gray-300 rounded-md shadow-sm w-full mt-1 text-gray-600"
                            >
                            <div v-if="form.errors.slug" class="text-red-500 text-sm mt-1">{{ form.errors.slug }}</div>
                        </div>

                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea 
                                v-model="form.description" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1"
                                rows="3"
                            ></textarea>
                        </div>

                        <div class="flex items-center justify-end">
                            <Link :href="route('projects.index')" class="text-gray-600 underline text-sm mr-4">Cancel</Link>
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition disabled:opacity-50"
                            >
                                Create Project
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>