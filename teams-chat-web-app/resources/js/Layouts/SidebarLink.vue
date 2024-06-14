<template>
    <li class="py-5 flex justify-center items-center hover:bg-purple-heavy border-b border-gray2">
      <Link :href="href" class="flex items-center">
        <span class="material-icons " :class="iconColor">{{ icon }}</span>
        
      </Link>
    </li>
</template>
  
  <script setup>
  import { Link } from "@inertiajs/vue3";
  
  const props = defineProps({
    href: String,
    icon: String,
    label: String,
    iconColor: {
      type: String,
      default: 'text-white', // Default color is white
    },
  });
  </script>