<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from '@inertiajs/vue3';

// Props come automatically from the Controller
defineProps({
    projects: Array,
});

const deleteProject = (id) => {
    if (confirm("Are you sure you want to delete this project?")) {
        router.delete(route("projects.destroy", id));
    }
};
</script>

<template>
    <Head title="My Projects" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    My Projects
                </h2>
                <Link
                    :href="route('projects.create')"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition"
                >
                    + New Project
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <Link
                        v-for="project in projects"
                        :key="project.id"
                        :href="route('projects.show', project.id)"
                        class="block h-full"
                    >
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition h-full flex flex-col"
                        >
                            <div class="p-6 flex-1">
                                <div
                                    class="flex justify-between items-start mb-4"
                                >
                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ project.name }}
                                    </h3>

                                    <div class="flex items-center gap-2">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full border bg-gray-50 text-gray-600"
                                        >
                                            {{ project.status }}
                                        </span>

                                        <button
                                            @click.prevent="
                                                deleteProject(project.id)
                                            "
                                            class="text-gray-400 hover:text-red-500 transition"
                                            title="Delete Project"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <p
                                    class="text-gray-600 text-sm mb-4 line-clamp-3"
                                >
                                    {{ project.description }}
                                </p>
                            </div>

                            <div
                                class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500"
                            >
                                <span class="flex items-center gap-1">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                                        />
                                    </svg>
                                    {{ project.tasks_count }} Tasks
                                </span>
                                <span class="text-xs">
                                    {{
                                        new Date(
                                            project.created_at
                                        ).toLocaleDateString()
                                    }}
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>

                <div v-if="projects.length === 0" class="text-center py-12">
                    <div class="text-gray-400 mb-2">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-12 w-12 mx-auto"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">
                        No projects yet
                    </h3>
                    <p class="text-gray-500">
                        Get started by creating your first project.
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
