import { ref } from 'vue';
import { defineStore } from 'pinia';

export const usePageBuilderStore = defineStore('pageBuilder', () => {
    const blocks = ref<Array<string>>([]);

    const addBlock = (id: string) => {
        blocks.value.push(id)
    }

    return { blocks, addBlock }
})
