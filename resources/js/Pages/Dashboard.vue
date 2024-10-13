<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryLink from "@/Components/PrimaryLink.vue";
import { ref } from "vue";
import TextInput from "../Components/TextInput.vue";
import axios from "axios";
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide } from 'vue3-carousel'

const props = defineProps({
    products: Object,
});

const displayingProduct = ref(false);
const currentProduct = ref(null);
const extras = ref([]);
const selectedExtras = ref([]); // [{extra_id, name, quantity, price}]

const addExtras = (extra) => {
    selectedExtras.value.push({
        extra_id: extra.extra_id,
        name: extra.name,
        quantity: 1,
        price: extra.price,
    });
};

const removeExtras = (extra) => {
    selectedExtras.value.splice(
        selectedExtras.value.findIndex((e) => e.extra_id === extra.extra_id),
        1
    );
};

const calculateTotal = () => {
    let sum = 0;
    selectedExtras.value.forEach(num => {
        sum += num.price * num.quantity;
    });
    return sum + currentProduct.value.price;
};

const existExtras = (extra) => {
    return selectedExtras.value.find((e) => e.extra_id === extra.extra_id);
};

const getImageUrl = (image) => {
    return route("file-image", { name: image });
};

const getExtrasByType = (type) => {
    axios.get(route("extras.type", { type: type })).then((response) => {
        extras.value = response.data.extras;
    });
};

</script>

<template>
    <AppLayout title="Productos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <p class="mt-6 text-gray-900 leading-relaxed">
                                Puede seleccionar el producto...
                            </p>
                        </div>
                        <div class="p-10 bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8"
                            v-for="product in props.products">
                            <div class="max-w-sm rounded overflow-hidden shadow-lg cursor-pointer" @click="
                                currentProduct = product;
                            displayingProduct = true;
                            getExtrasByType(product.type);
                            " :key="product.product_id">
                                <img class="w-full" :src="getImageUrl(product.image)" alt="Sunset in the mountains" />
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2">
                                        {{ product.name }} - {{ product.type }}
                                    </div>
                                    <p class="text-gray-700 text-base">
                                        {{ product.description }}
                                    </p>
                                </div>
                                <div class="px-6 pt-4 pb-2">
                                    <span
                                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{
                                            product.price }} Bs.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <DialogModal :show="displayingProduct" @close="displayingProduct = false">
            <template #title> {{ currentProduct.name }} </template>

            <template #content>
                <div v-if="currentProduct">
                    <div class="rounded overflow-hidden shadow-lg">
                        <div class="flex justify-center">
                            <img class="w-2/4" :src="getImageUrl(currentProduct.image)" :alt="currentProduct.name" />
                        </div>

                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">
                                {{ currentProduct.name }} -
                                {{ currentProduct.type }}
                            </div>
                            <p class="text-gray-700 text-base">
                                {{ currentProduct.description }}
                            </p>
                        </div>
                        <div class="px-6 pt-4 pb-2">
                            <h2 class="text-xl font-semibold">Extras</h2>
                            <Carousel :items-to-show="4" :breakpoints="breakpoints">
                                <Slide v-for="extra in extras" :key="extra.extra_id">
                                    <div
                                        class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-96">
                                        <div class="relative m-2.5 overflow-hidden text-white rounded-md">
                                            <img width="200" :src="getImageUrl(extra.image)" :alt="extra.name" />
                                        </div>
                                        <div class="p-4">
                                            <h6 class="mb-2 text-slate-800 text-xl font-semibold">
                                                {{ extra.name }}
                                            </h6>
                                            <p class="text-slate-600 leading-normal font-light">
                                                {{ extra.price }} Bs.
                                            </p>
                                        </div>
                                        <div class="px-4 pb-4 pt-0 mt-2">
                                            <PrimaryButton v-if="!existExtras(extra)" @click="addExtras(extra)">
                                                Agregar
                                            </PrimaryButton>
                                            <DangerButton v-if="existExtras(extra)" @click="removeExtras(extra)">
                                                Eliminar
                                            </DangerButton>
                                        </div>
                                    </div>

                                </Slide>
                            </Carousel>
                        </div>

                        <table class="table-auto w-full">
                            <thead>
                                <tr class="text-left font-bold">
                                    <th class="pb-4 pt-6 px-6">Nombre</th>
                                    <th class="pb-4 pt-6 px-6">Cantidad</th>
                                    <th class="pb-4 pt-6 px-6">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="entry in selectedExtras" :key="entry.extra_id"
                                    class="hover:bg-gray-100 focus-within:bg-gray-100">
                                    <td class="border-t">
                                        <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                                            {{ entry.name }}
                                        </span>
                                    </td>
                                    <td class="border-t">
                                        <TextInput id="quantity" type="number" class="mt-1 block w-full"
                                            v-model="entry.quantity" />
                                    </td>
                                    <td class="border-t">
                                        <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                                            {{ entry.price * entry.quantity }}
                                            Bs.
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="px-6 pt-4 pb-2">
                            <h2 class="text-xl font-semibold">
                                Total:
                                {{
                                    calculateTotal()
                                }}
                                Bs.
                            </h2>
                        </div>
                        <div class="px-6 pt-4 pb-2">
                            <PrimaryLink :href="route('generate-pdf', {productId: currentProduct.product_id, details: selectedExtras})" target="_blank">
                                Imprimir
                            </PrimaryLink>
                        </div>
                    </div>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="displayingProduct = false">
                    Close
                </SecondaryButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>
<style>
.carousel__item {
    min-height: 200px;
    width: 100%;
    font-size: 20px;
    border-radius: 8px;
}

.carousel__slide {
    padding: 10px;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
    border: 5px solid white;
}
</style>