<template>
    <div class="flex flex-col min-h-screen">
        <header class="bg-purple shadow p-8 flex justify-center items-center ">
            <h1 class="font-sans font-medium text-3xl">Microsoft Chat Web App</h1>
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        </header>
        <div class="flex flex-1">
            <Sidebar />
            <main class="flex-1 bg-gray p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
</script>