<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import { watch, reactive, onMounted, computed } from 'vue';

const { activities, avaiableAggregations } = defineProps({
    activities: {
        type: Array,
        required: true,
    },
    avaiableAggregations: {
        type: Array,
        required: true,
    },
});

const queryParams = usePage().props.ziggy.query;

const params = reactive({
    aggregations: queryParams.aggregations || [],
});

const tableHeaders = computed(() => Object.keys(activities[0]));

const isAggregationActive = (aggregation) => {
    return params.aggregations.includes(aggregation);
}

const formattedDate = (strDate) =>
    new Intl.DateTimeFormat('it-IT', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(new Date(strDate));

const debounce = (func, wait) => {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
};

onMounted(() => {
    activities.forEach((activity) => {
        if (activity.date) {
            activity.date = formattedDate(activity.date);
        }
    });
});

watch(
    params,
    debounce(() => {
        router.get(route('home', [queryParams, params]), {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }, 300)
);
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen">
        <div class="container mx-auto flex flex-col gap-y-6 pt-10">
            <h1 class="text-3xl font-bold text-center">Table with Activities</h1>

   
            <div class="flex gap-x-2 items-center" id="buttonsWrapper">
                <h2 class="block text-lg">
                    Aggrega le attivita' in base alle seguenti categorie:
                </h2>
                <template v-for="aggregation in avaiableAggregations">
                    <label 
                        :for="aggregation" 
                        class="relative inline-flex items-center cursor-pointer text-white  hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:hover:bg-purple-700 dark:focus:ring-purple-900 border border-purple-700 dark:border-purple-600"
                        :class="{ 'bg-purple-700 dark:bg-purple-600' : isAggregationActive(aggregation) }"    
                    >
                        <input 
                            type="checkbox" 
                            :name="aggregation" 
                            :value="aggregation" 
                            v-model="params.aggregations" 
                            :id="aggregation"
                            class="hidden"
                        >
                        {{ aggregation }}
                    </label>
                </template>
            </div>    

            <div class="relative overflow-x-auto" id="tableWrapper">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th
                                v-for="key in tableHeaders"
                                scope="col"
                                class="px-6 py-3 font-medium"
                            >
                                {{ key }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="activity in activities"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <td
                                v-for="key in Object.keys(activity)"
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ activity[key] }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
