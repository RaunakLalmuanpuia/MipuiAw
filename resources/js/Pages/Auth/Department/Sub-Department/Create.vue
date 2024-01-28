<template>
    <Head  title="Create Sub Organization"></Head>

    <div  >
        <form @submit.prevent="submit">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h5 class="mb-2">Create Sub Organization for <b>{{ departmentName }}</b></h5>
                    <q-btn  href="#" onclick="history.back();return false;" color="primary" label="Back" />

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        
                        <div class="p-6 text-gray-900 ml-3">
                            
                            <div class="ml-3 mb-5">
                                <div class="mb-8 flex justify-center">
                                    Add Sub Organization
                                </div>
                            </div>
                            <div>
                                <q-input v-model="form.organization_name" label="Enter Sub Organization" :dense="dense" />
                                <div v-if="form.errors.organization_name" v-text="form.errors.organization_name" class="text-red-500 text-xs mt-3"></div>
                            </div>
                            <div>
                                <q-input v-model="form.organization_code" label="Department Code" :dense="dense" />
                                <div v-if="form.errors.organization_code" v-text="form.errors.organization_code" class="text-red-500 text-xs mt-3"></div>
                            </div>
                            <div>
                                <q-input v-model="form.organization_type" label="Department Type" :dense="dense" />
                                <div v-if="form.errors.organization_type" v-text="form.errors.organization_type" class="text-red-500 text-xs mt-3"></div>
                            </div>
                            <div>
                                <q-input v-model="form.organization_address" label="Department Address" :dense="dense" />
                                <div v-if="form.errors.organization_address" v-text="form.errors.organization_address" class="text-red-500 text-xs mt-3"></div>
                            </div>
                            <div>
                                <q-input v-model="form.pincode" label="Pincode" :dense="dense" />
                                <div v-if="form.errors.pincode" v-text="form.errors.pincode" class="text-red-500 text-xs mt-3"></div>
                            </div>


                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    errors:Object,
    departmentName:'',
    departmentId:'',
});

let form = useForm({
    organization_name:'',
    organization_code:'',
    organization_type:'',
    organization_address:'',
    pincode:'',
    department_id:props.departmentId,
});

let submit=()=>{
    form.post('/subdepartment');
};

</script>