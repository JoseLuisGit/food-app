<script setup>
import { useForm } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryLink from "@/Components/PrimaryLink.vue";
import Pagination from "@/Components/Pagination.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    extras: Object,
    filters: Object,
    message: String,
});

const filters = {
    filter: props.filters.filter,
};
const form = useForm(filters);

const deleteTrade = (id) => {
    if (confirm("Are you sure you want to move this to trash")) {
        form.delete(route("extras.destroy", { id: id }), {
            preserveScroll: true,
        });
    }
};

const getImageUrl = (image) => {
    return route("file-image", { name: image });
};
</script>

<template>
    <AppLayout title="Extras">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800">
                <a :href="route('extras.index')">Extras</a>
            </h2>
            <PrimaryLink :href="route('extras.create')" class="max-w-xl ml-2"
                >Crear Extra</PrimaryLink
            >
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    v-if="props.message"
                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert"
                >
                    <span class="font-medium">
                        {{ props.message }}
                    </span>
                </div>
                <div class="bg-white rounded-md shadow overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">ID</th>
                                <th class="pb-4 pt-6 px-6">Nombre</th>
                                <th class="pb-4 pt-6 px-6">Precio (Bs)</th>
                                <th class="pb-4 pt-6 px-6">Tipo</th>
                                <th class="pb-4 pt-6 px-6">Image</th>
                                <th class="pb-4 pt-6 px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="entry in props.extras.data"
                                :key="entry.extra_id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <td class="border-t">
                                    <span
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    >
                                        {{ entry.extra_id }}
                                    </span>
                                </td>
                                <td class="border-t">
                                    <span
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    >
                                        {{ entry.name }}
                                    </span>
                                </td>
                                <td class="border-t">
                                    <span
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    >
                                        {{ entry.price }} Bs.
                                    </span>
                                </td>
                                <td class="border-t">
                                    <span
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    >
                                        {{ entry.type }}
                                    </span>
                                </td>
                                <td class="border-t">
                                    <span
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    >
                                        <img
                                            :src="getImageUrl(entry.image)"
                                            height="300"
                                            width="300"
                                            :alt="entry.name"
                                        />
                                    </span>
                                </td>
                                <td class="border-t">
                                    <PrimaryLink
                                        :href="
                                            route('extras.show', {
                                                id: entry.extra_id,
                                            })
                                        "
                                        class="max-w-xl ml-2"
                                        >Ver</PrimaryLink
                                    >
                                    <PrimaryLink
                                        :href="
                                            route('extras.edit', {
                                                id: entry.extra_id,
                                            })
                                        "
                                        class="max-w-xl ml-2"
                                        >Editar</PrimaryLink
                                    >
                                    <DangerButton
                                        class="ml-3"
                                        @click="deleteTrade(entry.extra_id)"
                                    >
                                        Eliminar
                                    </DangerButton>
                                </td>
                            </tr>
                            <tr v-if="props.extras.data.length === 0">
                                <td class="px-6 py-4 border-t" colspan="4">
                                    No hay datos.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <pagination class="mt-6" :links="props.extras.links" />
            </div>
        </div>
    </AppLayout>
</template>
