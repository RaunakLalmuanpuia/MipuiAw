<template>
<Head  title="Edit User"></Head>

<form @submit.prevent="submit">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="mb-2">Edit Sub Nodal Officer</h3>
            <q-btn  href="#" onclick="history.back();return false;" color="primary" label="Back" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-gray-900 ml-3">
                    Edit State Nodal Officer 
                    <div class="ml-3 mb-5">
                        <div class="mb-8 flex justify-center">
                            Edit State Nodal Officer
                        </div>
                    </div>
                    <div>
                        <div>
                            <q-input v-model="form.name" label="Full Name" :dense="dense" />
                            <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-3"></div>
                        </div>
                        
                        <div>
                            <q-input v-model="form.email" label="Email" :dense="dense" />
                            <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-3"></div>
                        </div>
                        
                        <div>
                            <q-input v-model="form.mobile" label="Mobile" :dense="dense" />
                            <div v-if="form.errors.mobile" v-text="form.errors.mobile" class="text-red-500 text-xs mt-3"></div>  
                        </div>

                        <div>
                            <q-select
                                        label="Gender"
                                        v-model="form.gender"
                                        :options="gender"
                                        style="width: 250px;"
                                    />
                            <div v-if="form.errors.gender" v-text="form.errors.gender" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <div>
                            <q-input v-model="form.designation" label="Designation" :dense="dense" />
                            <div v-if="form.errors.designation" v-text="form.errors.designation" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <div>
                            <q-input v-model="form.address" label="Office Address" :dense="dense" />
                            <div v-if="form.errors.address" v-text="form.errors.address" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <div>
                            <q-input v-model="form.pincode" label="Pincode" :dense="dense" />
                            <div v-if="form.errors.pincode" v-text="form.errors.pincode" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <div>
                            <q-input v-model="form.alternate_mobile" label="Alternate mobile (Optional)" :dense="dense" />
                            <div v-if="form.errors.alternate_mobile" v-text="form.errors.alternate_mobile" class="text-red-500 text-xs mt-3"></div>
                        </div>


                        <!-- <div>
                            <q-input v-model="form.notification" label="Notification" :dense="dense" />
                            <div v-if="form.errors.notification" v-text="form.errors.notification" class="text-red-500 text-xs mt-3"></div>
                        </div> -->

                        <div>
                            <q-select
                                label="Active"
                                v-model="form.active"
                                :options="active"
                                style="width: 250px;"
                                map-options
                            />                            
                            <div v-if="form.errors.active" v-text="form.errors.active" class="text-red-500 text-xs mt-3"></div>
                        </div>



                    </div>
                    <!-- <div class="mt-2">
                        <div style="min-width: 250px; max-width: 300px">
                            <q-select
                            filled
                            v-model="form.userRoles"
                            multiple
                            :options="roles"
                            
                            use-chips
                            stack-label
                            label="Roles"
                            option-label="name"
                            option-value="id"
                            />
                        </div>
                    </div> -->

                    <div class="mt-3">
                        <q-select
                            filled
                            v-model="form.subDepartment"
                            use-input
                            input-debounce="0"
                            label="Sub-Department"
                            :options="options"
                            @filter="filterFn"
                            style="width: 250px"
                            behavior="menu"
                            
                        />
                        <div v-if="form.errors.subDepartment" v-text="form.errors.subDepartment" class="text-red-500 text-xs mt-3"></div>
                    </div>
 
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
</template>

<script setup>
 import { useForm ,Head} from '@inertiajs/vue3';
 import {ref} from 'vue'

 const props = defineProps([
    'roles',
    'subNodalOfficer',
    'subDepartment',
    'currentSubDepartment',

 ])

 const modelMultiple='';

 const options=ref(props.subDepartment)
 const gender = ['Female','Male']
 const active=[{label:'Yes',value:1},{label:'No',value:0}]

 const form = useForm({
    
    name: props.subNodalOfficer.name,
    email:props.subNodalOfficer.email,
    userRoles:props.subNodalOfficer.roles,
    mobile:props.subNodalOfficer.mobile,
    gender:props.subNodalOfficer.gender,
    designation:props.subNodalOfficer.designation,
    address:props.subNodalOfficer.address,
    pincode:props.subNodalOfficer.pincode,
    alternate_mobile:props.subNodalOfficer.alternate_mobile,
    notification:props.subNodalOfficer.notification,
    active:props.subNodalOfficer.active==1?active[0]:active[1],
   
    role_id:props.roles.name,
    subDepartment:props.currentSubDepartment,
    department:props.subNodalOfficer.department,
 })
 
 const submit=e=>{
    form.put(route('departmentnodal.update',props.subNodalOfficer.id))
 }

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