<script setup lang="ts">
import { computed, ref, watch } from 'vue';

const emit = defineEmits(['onChangePage', 'onChangeRowsPerPage'])

const props = defineProps<{
    loading?: boolean,
    perPage: number,
    pageLength: number,
    currentPage: number,
    total: number,
}>();

const pageLength = ref(props.pageLength);

const paginationFrom = computed(() => {
    if (props.currentPage) {
        return (props.currentPage - 1) * props.perPage + 1;
    }
    return 0;
});

const paginationTo = computed(() => {
    if (props.currentPage) {
        return Math.min((props.currentPage - 1) * props.perPage + pageLength.value, props.total);
    }

    return 0;
});

const paginationLastPage = computed(() => {
    let total = 0;
    if (props.total && props.perPage) {
        total = Math.ceil(props.total / props.perPage) + 1;
    }
    return total;
});

const paginationPrevPage = computed(() => {
    if (props.currentPage) {
        return props.currentPage - 1;
    }
    return 0;
});

const paginationNextPage = computed(() => {
    if (props.currentPage) {
        return props.currentPage + 1;
    }
    return 0;
});

const onChangePage = (page: number) => {
    emit("onChangePage", page);
};

const onChangeRowsPerPage = () => {
    emit("onChangeRowsPerPage", pageLength.value);
}
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <span>Rows per page</span>
            <div class="pageLength">
                <select v-model="pageLength" @change="onChangeRowsPerPage">
                    <option v-for="item in [5, 10, 20, 30, 50]" :selected="item === pageLength">{{item}}</option>
                </select>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <span v-if="paginationFrom && paginationTo">{{paginationFrom}}-{{paginationTo}} / {{total}}</span>
            <div class="flex items-center">
                <button :disabled="paginationPrevPage < 1" @click="onChangePage(1)" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span>First page</span>
                </button>
                <button :disabled="paginationPrevPage < 1" @click="onChangePage(paginationPrevPage)" class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">
                    <span>Prev</span>
                </button>
                <button :disabled="paginationNextPage >= paginationLastPage" @click="onChangePage(paginationNextPage)" class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">
                    <span>Next</span>
                </button>
                <button :disabled="paginationNextPage >= paginationLastPage" @click="onChangePage(paginationLastPage -1)" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span>Last page</span>
                </button>
            </div>
        </div>
    </div>
</template>