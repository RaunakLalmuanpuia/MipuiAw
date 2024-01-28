<template>
    <Head  title="Create Quote"></Head>

        <div class="">
            <form @submit.prevent="submit">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h4 class="mb-2">Create Quote</h4>
                        <q-btn  href="#" onclick="history.back();return false;" color="primary" label="Back" />

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            
                            <div class="p-6 text-gray-900 ml-3">
                                <div class="ml-3 mb-5">
                                    <div class="mb-8 flex justify-center">
                                        Add Quote
                                    </div>
                                </div>
                                <div>
                                    <q-input v-model="form.quote" label="Quote"   />
                                    <div v-if="form.errors.quote" v-text="form.errors.quote" class="text-red-500 text-xs mt-3"></div>
                                </div>
                                <div>
                                    <q-input v-model="form.speaker" label="Speaker"   />
                                    <div v-if="form.errors.speaker" v-text="form.errors.speaker" class="text-red-500 text-xs mt-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    
</template>
<script setup>
import { useForm,Head } from '@inertiajs/vue3';
import { ref,onMounted } from 'vue';
import { useQuasar } from 'quasar';

let isDepartmentOfficer=ref(true)
const q=useQuasar()

const props = defineProps({
    errors:Object,
    quote:'',
    speaker:'',
})

let form = useForm({
    quote:'',
    speaker:'',
})

let submit=()=>{
    form.transform((data) => ({
        ...data,
    })).post('/admin/quote',{
        onStart:()=>q.loading.show({
            message: "Loading..."
        }),
        onFinish:()=>{
            q.loading.hide()
        }
    })
}


</script>