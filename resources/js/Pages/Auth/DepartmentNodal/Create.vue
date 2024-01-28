<template>
    <Head  title="Create User"></Head>
        <form @submit.prevent="submit">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h3 class="mb-2">Create Suborganization Nodal Officer</h3>
                    <h4 class="mb-3">Department Name: {{ departmentName.organization_name  }}</h4>
                    <q-btn  href="#" onclick="history.back();return false;" color="primary" label="Back" />

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                        <div class="p-6 text-gray-900 ml-3">
                            Create Suborganization Nodal Officer 
                            <div class="ml-3 mb-5">
                                <div class="mb-8 flex justify-center">
                                    Add Suborganization Nodal Officer
                                </div>
                            </div>
                            <div>
                                <div>
                                    <q-input v-model="form.name" label="Full Name"   />
                                    <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.email" label="Email"   />
                                    <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-3"></div>
                                </div>
                                <div>
                                    <q-input v-model="form.password" label="Password"   />
                                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input 
                                    v-model="form.mobile" 
                                    label="Mobile" 
                                    mask="##########"
                                    :rules="[val => val.length ==10 || 'Must be 10 digits']"
                                    maxlength="10"
                                    counter
                                 />
                                    <div v-if="form.errors.mobile" v-text="form.errors.mobile" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-select
                                        label="Gender"
                                        v-model="form.gender"
                                        :options="gender"
                                        style="width: 250px;"
                                    />                                    <div v-if="form.errors.gender" v-text="form.errors.gender" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.designation" label="Designation"   />
                                    <div v-if="form.errors.designation" v-text="form.errors.designation" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.address" label="Office Address"  />
                                    <div v-if="form.errors.address" v-text="form.errors.address" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.pincode" label="Pincode"   />
                                    <div v-if="form.errors.pincode" v-text="form.errors.pincode" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.alternate_mobile" label="Alternate mobile (Optional)"  />
                                    <div v-if="form.errors.alternate_mobile" v-text="form.errors.alternate_mobile" class="text-red-500 text-xs mt-3"></div>
                                </div>

<!--                            NOTIFICATION HI NOTIFICATION SMS/EMAIL A OPT-OUT THEIH NA TUR A TIH DEUH A NIA, TI LEH HRIH LO MAI ANG
                                <div>
                                    <q-input v-model="form.notification" label="Notification"  />
                                    <div v-if="form.errors.notification" v-text="form.errors.notification" class="text-red-500 text-xs mt-3"></div>
                                </div> -->

                                <div>
                                    <q-select
                                        label="Active"
                                        v-model="form.active"
                                        :options="active"
                                        style="width: 250px;"
                                    />                                    <div v-if="form.errors.active" v-text="form.errors.active" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div class="mt-3">
                                    <q-select
                                        v-model="form.subDepartment"
                                        use-input
                                        input-debounce="0"
                                        label="Sub-Office"
                                        :options="options"
                                        @filter="filterFn"
                                        style="width: 250px"
                                        behavior="menu"
                                    />
                                    <div v-if="form.errors.subDepartment" v-text="form.errors.subDepartment" class="text-red-500 text-xs mt-3"></div>
                                </div>
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
 
</template>


<script setup>
import { useForm,Head } from '@inertiajs/vue3';
import {ref} from 'vue';

const props = defineProps([
    // 'departments',
    'departmentName',
    'subDepartment',
    
]);

const options=ref(props.subDepartment)
const gender=['Female','Male']
const active=[{label:'Yes',value:1},{label:'No',value:0}]

// const options=ref(props.departments)

let form = useForm({
    name:'',email:'',password:'',
    mobile:'',gender:'',designation:'',
    address:'',pincode:'',alternate_mobile:'',
    notification:'',active:'',
    subDepartment:'',
    department_id:props.departmentName.id
});

let submit=()=>{
    //form.transform(data=>({department_id:data.departmentName.id,...data})).post('/admin/departmentnodal');
    form.post('/admin/departmentnodal',{
        preserveScroll:true
    });
};

const filterFn=(val,update)=>{
    if(val){
        update(() => {
            options.value=props.subDepartment.filter(item=>item.label.toLowerCase().includes(val.toLowerCase()))
        })
        return
    }
    update(() =>{
        options.value=props.subDepartment
    })
}

 

</script>