<template>
    <div class="grid 2xl:grid-cols-1 lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 mr-6 gap-5 text-center mb-4">
      <Widget size="small" maxWidth="full" title="Hello">
        <!-- Staff content goes here -->
        <p>Welcome the Microsoft Chat Web App!</p>
        <p>Below is a quick guide on how to navigate to the app</p>
      </Widget>
    </div>
      <div class="grid 2xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 mr-6 gap-5 ">
      <Widget size="small" maxWidth="full" title="Users Feature">
        <p>The users feature allows you to view all the users listed in Microsoft Azure’s “Microsoft Entra ID.” You can navigate to the users page by clicking the user icon on the navbar.  <span class="ml-3 mt-2 p-0.5 bg-midnight material-icons text-white dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">person</span></p>
        <br>
        <p>On the users page, you will see a list of all the users currently stored in the SQL database server in Microsoft Azure.</p>
        <p>If no users are displayed, you can press the “Reload Users” button <span class="material-icons ml-3 mt-2 p-0.5 bg-white material-icons text-black dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">refresh </span> 
        &nbsp;to automatically fetch the users from Microsoft Entra ID, save them to the database, and display them on the web page.  </p>
      </Widget>
      <Widget size="small" maxWidth="full" title="Chats Feature">
        <p> The chats feature allows you to view all chat conversations between users listed in Microsoft Azure’s “Microsoft Entra ID” and saved in the SQL database server. You can navigate to the chats page by clicking the chat icon on the navbar. <span class="ml-3 mt-2 p-1 bg-midnight material-icons text-white dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">chat</span></p>
        <br>
        <p>On the chats page, you have the option to select the “From” and “To” dates to display all chats between users within that period. All chats are saved in the SQL database server in Microsoft Azure. If no chats are displayed, you can generate and load the chats into the database by pressing the “Reload Chats” icon.<span class="material-icons ml-3 mt-2 p-0.5 bg-white material-icons text-black dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">refresh </span> </p>
        
      </Widget>
    </div>
</template>
  
<script setup>
  import Widget from '@/Widgets/Widget.vue';
</script>