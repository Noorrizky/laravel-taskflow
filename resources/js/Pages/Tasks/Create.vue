<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    project: Object
});

const form = useForm({
    title: '',
    description: '',
    priority: 'medium',
    due_date: ''
});

const submit = () => {
    // We post to the nested route
    form.post(route('projects.tasks.store', props.project.id));
};
</script>

<template>
    <Head title="New Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Task for {{ project.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit">
                        
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Task Title</label>
                            <input v-model="form.title" type="text" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea v-model="form.description" rows="3" class="border-gray-300 rounded-md shadow-sm w-full mt-1"></textarea>
                        </div>

                        <div class="flex gap-4 mb-6">
                            <div class="w-1/2">
                                <label class="block font-medium text-sm text-gray-700">Priority</label>
                                <select v-model="form.priority" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label class="block font-medium text-sm text-gray-700">Due Date</label>
                                <input v-model="form.due_date" type="date" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <Link :href="route('projects.show', project.id)" class="text-gray-600 underline text-sm mr-4">Cancel</Link>
                            <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Add Task
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>