<script setup>
  import { ref, onMounted, onUnmounted } from "vue";

  const emit = defineEmits(['update:modelValue']);

  const {options , modelValue} = defineProps({
    options: {
      type: Array,
      required: true,
    },
    placeholder: {
      type: String,
      required: false,
      default: "Select options",
    },
    modelValue: {
      type: Array,
      required: true,
    },
  })

  const selectedOptions = ref(modelValue);
  const showList = ref(false);
  const boxContainer = ref(null);
  
  function toggleDropdown() {
    showList.value = !showList.value;

    if (!showList.value) {
      emitChange();
    }
  }
  
  function isSelected(option) {
    return modelValue.includes(option);
  }
  
  function clickOutside(event) {
    if (
      !boxContainer.value.contains(event.target)
    ) {
        emitChange();
        showList.value = false;
    }
  }

  function emitChange() {
    emit('update:modelValue', selectedOptions.value)
  }
  
  onMounted(() => {
    window.addEventListener("click", clickOutside);
  });
  
  onUnmounted(() => {
    window.removeEventListener("click", clickOutside);
  });
</script>
<template>
    <div>
      <div
        class="relative min-w-96"
        aria-haspopup="listbox"
        role="combobox"
        :aria-expanded="showList"
      >
        <div ref="boxContainer">
          <button
            @click="toggleDropdown"
            class="relative flex w-full items-center rounded-lg border border-slate-300 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-900"
            aria-controls="tags-dropdown"
            aria-labelledby="tags-label"
          >
            <div class="flex items-center gap-2">
              <template v-if="selectedOptions.length > 0">
                <span
                  v-for="option in selectedOptions"
                  :key="option"
                  class="inline-flex items-center rounded bg-purple-100 px-2 py-0.5 text-xs font-medium dark:bg-purple-500 capitalize dark:text-white"
                >
                  {{ option }}
                </span>
              </template>
              <p v-else>{{ placeholder }}</p>
            </div>
            <span
              class="absolute right-3 top-1/2 -translate-y-1/2"
              aria-hidden="true"
            >
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    width="24" height="24" 
                    viewBox="0 0 24 24" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    class="size-6 transition-transform duration-500"
                    :class="showList ? 'rotate-180' : 'rotate-0 '"
                >
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </span>
          </button>
  
          <div
            v-show="showList"
            class="absolute z-10 mt-1 w-full overflow-hidden rounded-lg border border-slate-300 bg-white shadow-md dark:border-slate-600 dark:bg-slate-900"
            id="tags-dropdown"
          >
            <div class="max-h-96 overflow-y-auto">
              <label
                v-for="option in options"
                :key="option"
                :for="option"
                class="flex cursor-pointer items-center gap-3 px-3 py-2 hover:bg-purple-500 hover:text-white focus:outline-none"
                role="option"
                :aria-selected="isSelected(option)"
                tabindex="0"
              >
                <input
                  type="checkbox"
                  :id="option"
                  :checked="isSelected(option)"
                  class="size-4 cursor-pointer accent-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-400"
                  :aria-checked="isSelected(option)"
                  :value="option"
                  v-model="selectedOptions"
                  />
                <span class="pointer-events-none capitalize">{{ option }}</span>
              </label>
            </div>
            <div
              class="border-t border-slate-300 px-3 py-2 text-right dark:border-slate-600"
            >
              <button
                @click="toggleDropdown"
                class="rounded-md bg-purple-500 px-3 py-1 text-white hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-300"
              >
                Aggrega
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  

  
  