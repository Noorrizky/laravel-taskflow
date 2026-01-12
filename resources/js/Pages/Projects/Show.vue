<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3"; // <--- Added router
import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
    project: Object
});
const toggleStatus = (task) => {
    const newStatus = task.status === "completed" ? "pending" : "completed";

    router.patch(
        route("tasks.update", task.id),
        {
            status: newStatus,
        },
        {
            preserveScroll: true, // Keeps the user at the same scroll position
        }
    );
};
const deleteTask = (id) => {
    if (confirm("Delete this task?")) {
        router.delete(route("tasks.destroy", id), {
            preserveScroll: true,
        });
    }
};
onMounted(() => {
    // Listen to 'projects.X'
    Echo.channel(`projects.${props.project.id}`)
        .listen('TaskCreated', (e) => {
            // "e.task" contains the new task data from the backend
            // Add it to the list dynamically
            props.project.tasks.push(e.task);
        });
});

// Clean up listener when leaving page
onUnmounted(() => {
    Echo.leave(`projects.${props.project.id}`);
});
</script>

<template>
    <Head :title="project.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ project.name }}
                </h2>
                <Link
                    :href="route('projects.index')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    &larr; Back to Projects
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6"
                >
                    <div class="p-6 text-gray-900">
                        <p class="text-gray-600">{{ project.description }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-700">Tasks</h3>
                    <Link
                        :href="route('projects.tasks.create', project.id)"
                        class="bg-gray-800 text-white text-xs px-3 py-2 rounded hover:bg-gray-700 transition"
                    >
                        + Add Task
                    </Link>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <li
                        v-for="task in project.tasks"
                        :key="task.id"
                        class="p-4 hover:bg-gray-50 flex justify-between items-center transition group"
                    >
                        <div class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                :checked="task.status === 'completed'"
                                @change="toggleStatus(task)"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer h-5 w-5"
                            />
                            <span
                                class="font-medium text-gray-800 transition"
                                :class="{
                                    'line-through text-gray-400':
                                        task.status === 'completed',
                                }"
                            >
                                {{ task.title }}
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span
                                class="text-xs text-gray-500 px-2 py-1 bg-gray-100 rounded border uppercase"
                            >
                                {{ task.priority }}
                            </span>

                            <button
                                @click="deleteTask(task.id)"
                                class="text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition"
                            >
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
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </li>

                    <div
                        v-if="project.tasks.length === 0"
                        class="p-6 text-center text-gray-500"
                    >
                        No tasks yet.
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
