<template>
  <div v-if="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">
        {{ modalType === "add" ? "Add" : "Edit" }}
        {{ activeTable.charAt(0).toUpperCase() + activeTable.slice(1) }}
      </h3>
      <form @submit.prevent="saveData">
        <!-- Name Input for 'students' Table -->
        <div v-if="activeTable === 'students'" class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input
            v-model="modalData.name"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          />
        </div>

        <!-- Grade Level Dropdown for 'students' Table -->
        <div v-if="activeTable === 'students'" class="mb-4">
          <label for="gradeLevel" class="block text-sm font-medium text-gray-700">Grade Level</label>
          <select
            v-model="modalData.gradeLevel"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          >
            <option value="" disabled>Select Grade Level</option>
            <option v-for="grade in gradeLevels" :key="grade" :value="grade">{{ grade }}</option>
          </select>
        </div>

        <!-- Section Dropdown for 'students' Table -->
        <div v-if="activeTable === 'students'" class="mb-4">
          <label for="section" class="block text-sm font-medium text-gray-700">Section</label>
          <select
            v-model="modalData.section"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          >
            <option value="" disabled>Select Section</option>
            <option v-for="section in sections" :key="section.id" :value="section.section">{{ section.section }}</option>
          </select>
        </div>

        <!-- LRN Input for 'students' Table -->
        <div v-if="activeTable === 'students'" class="mb-4">
          <label for="lrn" class="block text-sm font-medium text-gray-700">LRN</label>
          <input
            v-model="modalData.lrn"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          />
        </div>

        <!-- Section Name and Grade Level for 'sections' Table -->
        <div v-if="activeTable === 'sections'" class="mb-4">
  <label for="sectionName" class="block text-sm font-medium text-gray-700">Section</label>
  <input
    v-model="modalData.section"
    type="text"
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
    placeholder="Enter section name"
  />
</div>


        <div v-if="activeTable === 'sections'" class="mb-4">
          <label for="gradeLevel" class="block text-sm font-medium text-gray-700">Grade Level</label>
          <select
            v-model="modalData.gradeLevel"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          >
            <option value="" disabled>Select Grade Level</option>
            <option v-for="grade in gradeLevels" :key="grade" :value="grade">{{ grade }}</option>
          </select>
        </div>

        <!-- Subject Input for 'subjects' Table -->
        <div v-if="activeTable === 'subjects'" class="mb-4">
          <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
          <input
            v-model="modalData.subject"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          />
        </div>

        <!-- Modal Buttons -->
        <div class="flex justify-end gap-4">
          <button
            @click="closeModal"
            type="button"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="!isFormValid || isLoading"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 disabled:opacity-50"
          >
            {{ isLoading ? "Saving..." : "Save" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showModal: {
      type: Boolean,
      required: true
    },
    modalType: {
      type: String,
      required: true
    },
    activeTable: {
      type: String,
      required: true
    },
    gradeLevels: {
      type: Array,
      default: () => []
    },
    sections: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      isLoading: false,
      modalData: {
        name: '',
        gradeLevel: '',
        section: '',
        lrn: '',
        subject: ''
      }
    };
  },
  computed: {
    isFormValid() {
      if (this.activeTable === 'students') {
        return this.modalData.name && this.modalData.gradeLevel && this.modalData.section && this.modalData.lrn;
      }
      if (this.activeTable === 'sections') {
        return this.modalData.section && this.modalData.gradeLevel;
      }
      if (this.activeTable === 'subjects') {
        return this.modalData.subject;
      }
      return false;
    }
  },
  methods: {
    async saveData() {
      if (!this.isFormValid) {
        alert('Please complete all required fields.');
        return;
      }

      this.isLoading = true;
      await new Promise(resolve => setTimeout(resolve, 1000)); // Simulate save operation
      this.$emit('save', this.modalData);
      this.isLoading = false;
      this.closeModal();
    },
    closeModal() {
      this.modalData = {
        name: '',
        gradeLevel: '',
        section: '',
        lrn: '',
        subject: ''
      };
      this.$emit('close');
    }
  }
};
</script>

<style scoped>
input, select {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 0.375rem;
  outline: none;
  transition: border-color 0.2s;
}

input:focus, select:focus {
  border-color: #3b82f6;
}

button:hover {
  transform: scale(1.02);
}
</style>
