<template>
    <Head  title="Create Category"></Head>

        <div class="">
            <form @submit.prevent="submit">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h4 class="mb-2">Create Category</h4>
                        <q-btn  href="#" onclick="history.back();return false;" color="primary" label="Back" />

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            
                            <div class="p-6 text-gray-900 ml-3">
                                <div class="ml-3 mb-5">
                                    <div class="mb-8 flex justify-center">
                                        Add Category
                                    </div>
                                </div>
                                <div>
                                    <q-input v-model="form.name" label="Category Name"   />
                                    <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-3"></div>
                                </div>
                                <div v-show=isDepartmentOfficer >
                                    <q-select 
                                  
                                    v-model="form.department" 
                                    :options="departments" 
                                    label="-- Select department --"
                                />
                                <div v-if="form.errors.department" v-text="form.errors.department" class="text-red-500 text-xs mt-3"></div>

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
    departments:'',
    CURRENT_USER:'',

})

let form = useForm({
    name:'',
    department:'',
    errors:'',
    
})

var mDepartmentID=''

onMounted(()=>{
    
        if(props.CURRENT_USER.role_id==3){
 
        console.log("09876596t")

        isDepartmentOfficer.value=false
        console.log(isDepartmentOfficer)

        mDepartmentID=props.CURRENT_USER.department_id

        }
})


const departmentSelect=(val)=>{
    //mDepartmentID=1234
    
    mDepartmentID=form.department
}

let submit=()=>{


    if(props.CURRENT_USER.role_id==1||props.CURRENT_USER.role_id==2){
            mDepartmentID=form.department.value
    }
    //form.post('/admin/category');
    form.transform((data) => ({
        ...data,
        department:mDepartmentID
    })).post('/admin/category',{
        onStart:()=>q.loading.show({
            message:'Creating...'
        }),
        onFinish:()=>{q.loading.hide()}
    })

}


</script>