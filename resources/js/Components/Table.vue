<template>
    <div class="bg-white shadow-sm rounded-lg p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">{{ title }}</h3>
        <button
          v-if="showAddButton"
          @click="emitAddAction"
          class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
          Add {{ title }}
        </button>
      </div>
      <table class="min-w-full border-collapse border border-gray-300">
        <thead>
          <tr>
            <th v-for="(header, index) in headers" :key="index" class="px-4 py-2 text-left border border-gray-300">
              {{ header }}
            </th>
            <th class="px-4 py-2 text-left border border-gray-300">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items" :key="item.id">
            <td v-for="header in headers" :key="header" class="px-4 py-2 border border-gray-300">
              {{ item[header.toLowerCase()] }}
            </td>
            <td class="px-4 py-2 border border-gray-300 flex gap-2">
              <button
                @click="emitEditAction(item)"
                class="bg-yellow-500 text-white px-4 py-1 rounded-lg hover:bg-yellow-600"
              >
                Edit
              </button>
              <button
                @click="emitDeleteAction(item)"
                class="bg-red-500 text-white px-4 py-1 rounded-lg hover:bg-red-600"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  
  // Define component props
  const { title, headers, items, showAddButton } = defineProps({
    title: String,
    headers: Array,
    items: Array,
    showAddButton: {
      type: Boolean,
      default: true,
    },
  });
  
  // Define the emit function
  const emit = defineEmits();
  
  // Emit actions
  const emitAddAction = () => {
    emit('add');
  };
  
  const emitEditAction = (item) => {
    emit('edit', item);
  };
  
  const emitDeleteAction = (item) => {
    emit('delete', item);
  };
  </script>
  
  
  <style scoped>
  /* Add any specific styles for the table component here */
  </style>
  