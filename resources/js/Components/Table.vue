<script setup>
    const {headers , data} = defineProps({
        headers: {
            type: Array,
            required: true,
        },
        data: {
            type: Array,
            required: true,
        },
    })

</script>
<template>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 table-auto">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th
                    v-for="key in headers"
                    scope="col"
                    class="px-6 py-3 font-medium"
                >
                    {{ key }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="activity in data"
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
</template>