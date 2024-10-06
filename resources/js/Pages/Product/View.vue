<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
const props = defineProps({
    product: Object,
});
const getImageUrl = (image) => {
    return route("file-image", { name: image });
};
</script>
<template>
    <AppLayout :title="props.product.name">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ props.product.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="py-12">
                        <div
                            class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"
                        >
                            <h1 class="text-2xl">{{ props.product.name }}</h1>
                            <div>
                                {{ props.product.description }}
                            </div>
                            <div>
                                {{ props.product.price }} Bs.
                            </div>
                            <div>
                                <img
                                    :src="getImageUrl(props.product.image)"
                                    height="500"
                                    width="500"
                                    :alt="props.product.name"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
