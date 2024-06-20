<template>
  <div class="grid 2xl:grid-cols-1 lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 mr-6 gap-5 text-center">
    <Widget size="small" maxWidth="full" >
      <div class="flex flex-col items-center min-h-screen bg-white">
    <div class="w-full max-w-2xl">
      <div class="flex items-center justify-between p-4 bg-purple text-white shadow rounded-xl ">
        <h1 class="text-xl font-semibold">Chats</h1>
        <button @click="reloadChats" class="text-white hover:text-gray3">
          <span class="material-icons">refresh</span>
        </button>
      </div>

      <div class="p-4">
        <div class="mb-4">
          <label for="from_date" class="block text-sm font-medium text-gray2">From Date:</label>
          <input type="date" id="from_date" v-model="filters.from_date" class="mt-1  w-40 px-3 py-2 border border-gray3 rounded-md shadow-sm focus:outline-none focus:ring-purple focus:border-purple sm:text-sm">
        </div>
        <div class="mb-4">
          <label for="to_date" class="block text-sm font-medium text-gray2">To Date:</label>
          <input type="date" id="to_date" v-model="filters.to_date" class="mt-1 w-40  px-3 py-2 border border-gray3 rounded-md shadow-sm focus:outline-none focus:ring-purple focus:border-purple sm:text-sm">
        </div>
        <button @click="loadChats" class="mb-4 px-4 py-2 bg-purple text-white font-semibold rounded-md shadow-md hover:bg-purple-heavy focus:outline-none focus:ring-2 focus:ring-purple focus:ring-opacity-75">Load Chats</button>

        <div v-if="Object.keys(visibleConversations).length > 0" class="space-y-4">
          <div v-for="(chats, key) in visibleConversations" :key="String(key)" class="mb-4">
  
            <h2 class="text-lg font-semibold mb-6 border-b mx-40 mt-10 p-2"> {{ getUserNames(key) }} </h2>
            <div v-for="chat in chats" :key="chat.id" :class="isLeft(chat) ? 'flex justify-start' : 'flex justify-end'">
              <div :class="isLeft(chat) ? 'bg-gray2 text-gray rounded-e-xl rounded-es-xl' : 'bg-purple text-white rounded-l-xl rounded-tr-xl'" class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border border-gray3 ">
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                  <span class="text-sm font-semibold">{{ chat.user_from.full_name }}</span>
                  <span class="text-sm font-normal">{{ new Date(chat.datetime).toLocaleString() }}</span>
                </div>
                <p class="text-sm font-normal py-2.5">{{ chat.chat_text }}</p>
                <span class="text-sm font-normal">Delivered</span>
              </div>
            </div>
          </div>
          <button v-if="Object.keys(conversations).length > visibleConversationCount" @click="showMore" class="mt-4 px-4 py-2 bg-gray2 text-white font-semibold rounded-md shadow-md hover:bg-gray3 focus:outline-none focus:ring-2 focus:ring-purple focus:ring-opacity-75">Show More</button>
        </div>
        <p v-else>No chats available.</p>
      </div>
    </div>
  </div>
    </Widget>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { defineProps, reactive, computed } from 'vue';
import Widget from '@/Widgets/Widget.vue';


const props = defineProps({
  conversations: Object,
  filters: Object
});

const conversations = ref(props.conversations);
const filters = reactive({ ...props.filters });
const visibleConversationCount = ref(1);

const visibleConversations = computed(() => {
  return Object.fromEntries(Object.entries(conversations.value).slice(0, visibleConversationCount.value));
});

const loadChats = () => {
  router.get('/chats', filters, {
    onSuccess: (page) => {
      conversations.value = page.props.conversations;
      visibleConversationCount.value = 1; // Reset visible conversations count
    },
    onError: (error) => {
      console.error('Error loading chats:', error);
    }
  });
};

const reloadChats = () => {
  router.get('/load-chats', filters, {
    onSuccess: (page) => {
      conversations.value = page.props.conversations;
      visibleConversationCount.value = 1; // Reset visible conversations count
    },
    onError: (error) => {
      console.error('Error loading chats:', error);
    }
  });
};

const showMore = () => {
  visibleConversationCount.value += 1;
};

const getUserNames = (key) => {
  const [userFromId, userToId] = String(key).split('-').map(Number);
  const userFrom = conversations.value[String(key)][0].user_from.full_name;
  const userTo = conversations.value[String(key)][0].user_to.full_name;
  return `${userFrom} - ${userTo}`;
};

const isLeft = (chat) => {
  // Here, we use the user_from_id to determine alignment
  return chat.user_from_id < chat.user_to_id;
};
</script>

<style scoped>
.flex {
  display: flex;
}

.flex-1 {
  flex: 1;
}

.justify-end {
  justify-content: flex-end;
}

.justify-start {
  justify-content: flex-start;
}

.bg-purple {
  background-color: #5961c3;
}

.bg-gray2 {
  background-color: #374151;
}

.text-white {
  color: #ffffff;
}

.text-gray {
  color: #fafafa;
}

.border-gray3 {
  border-color: #d1d5db;
}
</style>