<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import { watch, reactive, computed } from 'vue';
import Table from '@/Components/Table.vue';
import Multiselect from '@/Components/Multiselect.vue';

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

const updateAggregations = (aggs) => {
    params.aggregations = aggs;
}

watch(
    params,
    () => {
        router.get(route('home', [params]), {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-gray-900 dark:text-white/50 min-h-screen">
        <div class="container mx-auto flex flex-col gap-y-6 pt-10 px-2">
            <h1 class="text-3xl font-bold text-center">Table with Activities</h1>

            <div>
                <h2 class="block text-lg mb-2">
                    Aggrega le attivita' in base alle seguenti categorie:
                </h2>

                <div>
                    <Multiselect 
                        :options="avaiableAggregations"
                        placeholder="Select Aggregations"
                        :modelValue="params.aggregations"
                        @update:modelValue="($event) => updateAggregations($event)"
                    />
                </div>
            </div>

            <div class="relative overflow-x-auto" id="tableWrapper">
                <Table :headers="tableHeaders" :data="activities" />
            </div>
        </div>
    </div>
</template>
