<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0"
    >
        <div
            v-if="canLogin"
            class="hidden fixed top-0 right-0 px-6 py-4 sm:block"
        >
            <Link
                v-if="$page.props.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 underline"
            >
                Home
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-lg text-gray-700 underline"
                >
                    Ingresar
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-lg text-gray-700 underline"
                >
                    Registrarse
                </Link>
            </template>
        </div>

        <div class="font-sans text-gray-900 antialiased">
            <div class="pt-4 bg-gray-100">
                <div
                    class="min-h-screen flex flex-col items-center pt-6 sm:pt-0"
                >
                    <div
                        class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose"
                    >
                        <div class="flex justify-center items-center">
                            <Link :href="'/'">
                                <svg
                                    class="w-16 h-16"
                                    viewBox="0 0 48 48"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M11.395 44.428C4.557 40.198 0 32.632 0 24 0 10.745 10.745 0 24 0a23.891 23.891 0 0113.997 4.502c-.2 17.907-11.097 33.245-26.602 39.926z"
                                        fill="#6875F5"
                                    />
                                    <path
                                        d="M14.134 45.885A23.914 23.914 0 0024 48c13.255 0 24-10.745 24-24 0-3.516-.756-6.856-2.115-9.866-4.659 15.143-16.608 27.092-31.75 31.751z"
                                        fill="#6875F5"
                                    />
                                </svg>
                            </Link>
                            <h1
                                class="m-0 pl-2 text-4xl font-bold text-gray-800"
                            >
                                Bienvenido a Food App!
                            </h1>
                        </div>

                        <p>
                            Esta es una aplicacion para ver los productos de la
                            tienda
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
