<script setup>
import { ref, onMounted } from "vue";
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import FormModal from "@/Components/FormModal.vue";
import { useForm } from "@inertiajs/vue3";
import { Inertia } from '@inertiajs/inertia';

// Data for tables (to be populated with data fetched from the server)
const students = ref([]);
const sections = ref([]);
const subjects = ref([]);

const gradeLevels = ref([7, 8, 9, 10, 11, 12]);

// Modals and forms
const activeTable = ref(null);
const showModal = ref(false);
const modalData = ref({});
const modalType = ref("");

// Reset modal data and close modal
const closeModal = () => {
    modalData.value = {};
    showModal.value = false;
    modalType.value = "";
};

// Toggle active table
const toggleTable = (table) => {
    activeTable.value = activeTable.value === table ? null : table;
};

// Handle Add/Edit actions
const handleAction = (type, item = {}) => {
    modalType.value = type;
    modalData.value = { ...item };
    showModal.value = true;
};

// Handle saving data
const saveData = () => {
    const form = useForm({ ...modalData.value });

    // Adjust the API routes for your app structure
    const routes = {
        students: { add: '/students/create', edit: '/students/update' },
        sections: { add: '/sections/create', edit: '/sections/update' },
        subjects: { add: '/subjects/create', edit: '/subjects/update' }
    };

    const apiRoute = routes[activeTable.value][modalType.value];
    
    switch (modalType.value) {
        case "add":
            Inertia.post(apiRoute, form, {
                onSuccess: () => {
                    alert(`${activeTable.value.charAt(0).toUpperCase() + activeTable.value.slice(1)} successfully added!`);
                    closeModal();
                },
                onError: (errors) => {
                    console.error(errors);
                    alert(`Failed to add ${activeTable.value}.`);
                },
            });
            break;

        case "edit":
            Inertia.put(`${apiRoute}/${modalData.value.id}`, form, {
                onSuccess: () => {
                    alert(`${activeTable.value.charAt(0).toUpperCase() + activeTable.value.slice(1)} successfully updated!`);
                    closeModal();
                },
                onError: (errors) => {
                    console.error(errors);
                    alert(`Failed to update ${activeTable.value}.`);
                },
            });
            break;
    }
};

// Confirm delete with confirmation dialog
const confirmDelete = (type, item) => {
    const confirmed = confirm(`Are you sure you want to delete this ${type}?`);
    if (confirmed) {
        deleteItem(type, item);
    }
};

// Delete item from the respective list
const deleteItem = (type, item) => {
    const routes = {
        student: `/students/${item.id}/delete`,
        section: `/sections/${item.id}/delete`,
        subject: `/subjects/${item.id}/delete`
    };

    Inertia.delete(routes[type], {
        onSuccess: () => {
            if (type === "student") students.value = students.value.filter(student => student.id !== item.id);
            if (type === "section") sections.value = sections.value.filter(section => section.id !== item.id);
            if (type === "subject") subjects.value = subjects.value.filter(subject => subject.id !== item.id);
            alert(`${type.charAt(0).toUpperCase() + type.slice(1)} ${item.name} deleted.`);
        },
        onError: (errors) => {
            console.error(errors);
            alert(`Failed to delete ${type}.`);
        },
    });
};

// Fetch data on mount
onMounted(() => {
    // Make sure to replace these API calls with actual fetch from your server.
    students.value = [{ id: 1, name: "John Doe" }]; // Example, replace with real data
    sections.value = [{ id: 1, name: "Section A" }];
    subjects.value = [{ id: 1, name: "Math" }];
});
</script>




<template>
    <Head title="Dashboard" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
      </template>
  
      <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Students Card -->
            <div
              @click="toggleTable('students')"
              :class="['bg-yellow-500 shadow-sm rounded-lg p-6 cursor-pointer', activeTable === 'students' ? 'border-2 border-yellow-700' : '']"
            >
              <h3 class="text-lg font-semibold text-gray-800">Students</h3>
              <p class="mt-2 text-gray-600">Total: {{ students.length }}</p>
            </div>
  
            <!-- Sections Card -->
            <div
              @click="toggleTable('sections')"
              :class="['bg-blue-500 shadow-sm rounded-lg p-6 cursor-pointer', activeTable === 'sections' ? 'border-2 border-blue-700' : '']"
            >
              <h3 class="text-lg font-semibold text-gray-800">Sections</h3>
              <p class="mt-2 text-gray-600">Total: {{ sections.length }}</p>
            </div>
  
            <!-- Subjects Card -->
            <div
              @click="toggleTable('subjects')"
              :class="['bg-red-500 shadow-sm rounded-lg p-6 cursor-pointer', activeTable === 'subjects' ? 'border-2 border-red-700' : '']"
            >
              <h3 class="text-lg font-semibold text-gray-800">Subjects</h3>
              <p class="mt-2 text-gray-600">Total: {{ subjects.length }}</p>
            </div>
          </div>
  
          <!-- Conditionally render tables based on the active table -->
          <Table
            v-if="activeTable === 'students'"
            title="Students"
            :headers="['Name', 'LRN', 'Grade', 'Section']"
            :items="students"
            @add="handleAction('add')"
            @edit="handleAction('edit', $event)"
            @delete="confirmDelete('student', $event)"
          />
  
          <Table
            v-if="activeTable === 'sections'"
            title="Sections"
            :headers="['Section', 'Grade']"
            :items="sections"
            @add="handleAction('add')"
            @edit="handleAction('edit', $event)"
            @delete="confirmDelete('section', $event)"
          />
  
          <!-- Subjects Table -->
          <Table
            v-if="activeTable === 'subjects'"
            title="Subjects"
            :headers="['Subject']"
            :items="subjects"
            @add="handleAction('add')"
            @edit="handleAction('edit', $event)"
            @delete="confirmDelete('subject', $event)"
          />
        </div>
      </div>
  
      <!-- Modal -->
      <FormModal
        v-if="showModal"
        :showModal="showModal"
        :modalType="modalType"
        :activeTable="activeTable"
        :gradeLevels="gradeLevels"
        :sections="sections"
        @save="saveData"
        @close="closeModal"
      />
    </AuthenticatedLayout>
  </template>
  