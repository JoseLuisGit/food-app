<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import { useForm } from "@inertiajs/vue3";
import Dropdown from "../../Components/Dropdown.vue";

const props = defineProps({
    extra: Object,
});

const form = useForm({
    _method: "put",
    id: props.extra.extra_id,
    name: props.extra.name,
    price: props.extra.price,
    image: props.extra.image,
    type: props.extra.type,
});
const types = ["Pizza", "Pastel"];
const submit = () => {
    const formData = new FormData();
    formData.append("id", form.id);
    formData.append("name", form.name);
    formData.append("price", form.price);
    formData.append("image", form.image);
    formData.append("type", form.type);

    form.post(route("extras.update", props.extra.extra_id), {
        forceFormData: true,
        body: formData,
    });
};

const getImageUrl = (image) => {
    return route("file-image", { name: image });
};

const handleFileChange = (event) => {
    form.image = event.target.files[0];
};
</script>

<template>
    <AppLayout title="Editar Extra">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Extra
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section>
                    <form @submit.prevent="submit" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="Nombre" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div>
                            <InputLabel for="price" value="Precio (Bs)" />

                            <TextInput
                                id="price"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.price"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.price"
                            />
                        </div>

                        <div>
                            <InputLabel for="type" value="Tipo" />

                            <Dropdown>
                                <template #trigger>
                                    <div class="relative">
                                        <button
                                            type="button"
                                            class="inline-flex justify-between w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            id="options-menu"
                                            aria-haspopup="true"
                                            aria-expanded="true"
                                        >
                                            <span v-if="form.type === ''"
                                                >Seleccionar Tipo</span
                                            >
                                            <span v-else>{{ form.type }}</span>
                                            <svg
                                                class="-mr-1 ml-2 h-5 w-5"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5 8a1 1 0 011.707 0L10 11.293l3.293-3.294a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4A1 1 0 015 8z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template #content>
                                    <div class="py-1" role="none">
                                        <button
                                            v-for="type in types"
                                            type="button"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                            role="menuitem"
                                            @click="form.type = type"
                                        >
                                            {{ type }}
                                        </button>
                                    </div>
                                </template>
                            </Dropdown>
                            <InputError
                                class="mt-2"
                                :message="form.errors.type"
                            />
                        </div>

                        <div>
                            <InputLabel for="image" value="Imagen" />

                            <input
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                type="file"
                                @change="handleFileChange"
                            />

                            <progress
                                v-if="form.progress"
                                :value="form.progress.percentage"
                                max="100"
                            >
                                {{ form.progress.percentage }}%
                            </progress>

                            <InputError
                                class="mt-2"
                                :message="form.errors.image"
                            />
                        </div>
                        <div>
                            <img
                                :src="getImageUrl(form.image)"
                                height="500"
                                width="500"
                                :alt="form.name"
                            />
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing"
                                >Guardar</PrimaryButton
                            >

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p
                                    v-if="form.recentlySuccessful"
                                    class="text-sm text-gray-600"
                                >
                                    Guardado.
                                </p>
                            </Transition>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AppLayout>
</template>
