<template>
   <div class="grid 2xl:grid-cols-4 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 mr-6 gap-5 text-center">
    <Widget size="small" maxWidth="full" >
      <div class="relative h-5" >
        <button @click="loadUsers" class="absolute right-0 " >  <span class="material-icons">refresh</span></button>
        
      </div>
      
      <h3 class="text-lg font-semibold mb-2 break-words">Users</h3>
    <div>
      <div v-for="user in users" :key="user.id" class="mb-2 ">
        {{ user.full_name }}
        <div class="border-b border-gray3 md-10 sm:mx-20 xl:mx-6 2xl:12 my-1 "></div>
      </div>
    </div>
   
    </Widget>
   </div>
</template>

<script setup>
import { ref, computed, defineProps } from 'vue';
import { Inertia, usePage } from '@inertiajs/inertia-vue3';
import { router } from "@inertiajs/vue3";
import Widget from '@/Widgets/Widget.vue';


const props = defineProps({
  users: Array
});


const users = ref(props.users);



const loadUsers = () => {
  router.get('/load-users', {}, {
    onSuccess: (page) => {
      users.value = page.props.users;

    }
  });
};
</script>