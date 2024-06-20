<template>
  <div class="sm:max-md:hidden sidebar  bg-midnight text-white w-20  shadow">
    
    <ul class="flex-col">
      <SidebarLink href="/" icon="home" label="Home" iconColor="white" />
      <SidebarLink href="/users" icon="person" label="Users" iconColor="white" />
      <SidebarLink href="/chats" icon="chat" label="Chats" iconColor="white" />
    </ul>
  </div>


  <div class="md:hidden fixed z-50 mt-10 w-full h-14  -translate-x-1/2 bg-midnight border border-gray2 bottom-0 left-1/2">
    <div class="grid h-full max-w-lg grid-cols-3 mx-auto">
      <Link href="/" class="inline-flex flex-col items-center justify-center  hover:bg-purple-heavy  group">
        <span class="material-icons text-white dark:text-gray3 group-hover:text-blue-600 dark:group-hover:text-blue-500">home</span>
        <span class="sr-only">Home</span>
      </Link>
      <Link href="/users" class="inline-flex flex-col items-center justify-center  hover:bg-purple-heavy  group">
        <span class="material-icons text-white dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">person</span>
        <span class="sr-only">Users</span>
      </Link>
      <Link href="/chats" class="inline-flex flex-col items-center justify-center   hover:bg-purple-heavy  group">
        <span class="material-icons text-white dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">chat</span>
        <span class="sr-only">Chats</span>
      </Link>
    </div>
  </div>
</template>

<script setup>
import SidebarLink from '@/Layouts/SidebarLink.vue';
import { Link } from "@inertiajs/vue3";
</script>
