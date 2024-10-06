<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const form = useForm({
    name: "",
    description: "",
    price: "",
    image: null,
});

const submit = () => {
    form.post(route("products.store"));
};
</script>

<template>
    <AppLayout title="Crear Producto">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Producto
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="py-12">
                        <div
                            class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"
                        >
                            <section>
                                <form
                                    @submit.prevent="submit"
                                    class="mt-6 space-y-6"
                                >
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
                                        <InputLabel
                                            for="description"
                                            value="Descripcion"
                                        />

                                        <TextArea
                                            id="description"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.description"
                                        />

                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.description"
                                        />
                                    </div>

                                    <div>
                                        <InputLabel
                                            for="price"
                                            value="Precio (Bs)"
                                        />

                                        <TextInput
                                            id="price"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="form.price"
                                            required
                                        />

                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.price"
                                        />
                                    </div>
                                    <div>
                                        <InputLabel
                                            for="image"
                                            value="Imagen"
                                        />

                                        <input
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            type="file"
                                            @input="
                                                form.image =
                                                    $event.target.files[0]
                                            "
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

                                    <div class="flex items-center gap-4">
                                        <PrimaryButton
                                            :disabled="form.processing"
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
                                                Guardado
                                            </p>
                                        </Transition>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
