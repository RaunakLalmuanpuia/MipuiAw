<template>
<Head  title="Edit User"></Head>

<form @submit.prevent="submit">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <q-btn  href="#" onclick="history.back();return false;" color="primary" label="Back" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-gray-900 ml-3">
                    Edit Nodal Officer 
                    <div class="ml-3 mb-5">
                        <div class="mb-8 flex justify-center">
                            Edit Nodal Officer
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
                            <q-input v-model="form.mobile" 
                            label="Mobile" 
                            counter 
                            maxlength="10"  
                            mask="##########"
                            :rules="[val => val.length ==10 || 'Must be 10 digits']"
                            />
                            <div v-if="form.errors.mobile" v-text="form.errors.mobile" class="text-red-500 text-xs mt-3"></div>
                        </div>
                       
                        <div>
                            <q-input v-model="form.password" label="Password (Leave blank to retain password)"   />
                            <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-3"></div>  
                        </div>

                        <div>
                            <q-select
                                label="Gender"
                                v-model="form.gender"
                                :options="gender"
                                style="width: 250px;"
                            /> <div v-if="form.errors.gender" v-text="form.errors.gender" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <div>
                            <q-input v-model="form.designation" label="Designation"   />
                            <div v-if="form.errors.designation" v-text="form.errors.designation" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <div>
                            <q-input v-model="form.address" label="Office Address"   />
                            <div v-if="form.errors.address" v-text="form.errors.address" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <div>
                            <q-input v-model="form.pincode" label="Pincode"   />
                            <div v-if="form.errors.pincode" v-text="form.errors.pincode" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <div>
                            <q-input v-model="form.alternate_mobile" label="Alternate mobile (Optional)"   />
                            <div v-if="form.errors.alternate_mobile" v-text="form.errors.alternate_mobile" class="text-red-500 text-xs mt-3"></div>
                        </div>

                        <!-- <div>
                            <q-input v-model="form.notification" label="Notification"   />
                            <div v-if="form.errors.notification" v-text="form.errors.notification" class="text-red-500 text-xs mt-3"></div>
                        </div> -->

                        <div>
                            <!-- <q-input v-model="form.active" label="Active"   /> -->
                            <q-select
                                v-model="form.active"
                                label="Active"
                                :options="active"
                                style="width: 250px;"
                                map-options
                            />

                            <div v-if="form.errors.active" v-text="form.errors.active" class="text-red-500 text-xs mt-3"></div>
                        </div>

                    </div>
                    <div class="mt-2">
                        <div style="min-width: 250px; max-width: 300px">
                            <q-select
                            v-model="form.role"
                            input-debounce="0"
                            label="Roles"
                            :options="roles"
                            style="width: 250px"
                            behavior="menu"
                            />
                        </div>
                    </div>

                    <div class="mt-3">
                        <q-select
                            
                            v-model="form.department"
                            use-input
                            input-debounce="0"
                            label="Department"
                            :options="options"
                            @filter="filterFn"
                            style="width: 250px"
                            behavior="menu"
                            
                        />
                        <div v-if="form.errors.department" v-text="form.errors.department" class="text-red-500 text-xs mt-3"></div>
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
 import { useForm,Head } from '@inertiajs/vue3';
 import {ref} from 'vue'

 const props = defineProps([
    'roles',
    'stateNodalOfficer',
    'departments',
    'myDepartment',
    'myRole',
    'referer',

 ])

 const active=[{label:'Yes',value:1},{label:'No',value:0}]
 const options=ref(props.departments)
 const gender=['Female','Male']

 const roles=ref(props.roles)
 //const 
 //const modal = ref(false)

 const form = useForm({

    name: props.stateNodalOfficer.name,
    email:props.stateNodalOfficer.email,
    role_id:props.stateNodalOfficer.role_id,
    mobile:props.stateNodalOfficer.mobile,
    password:props.stateNodalOfficer.password,
    gender:props.stateNodalOfficer.gender,
    designation:props.stateNodalOfficer.designation,
    address:props.stateNodalOfficer.address,
    pincode:props.stateNodalOfficer.pincode,
    alternate_mobile:props.stateNodalOfficer.alternate_mobile,
    notification:props.stateNodalOfficer.notification,
    active:props.stateNodalOfficer.active==1?active[0]:active[1],

    role:props.myRole,
    department:props.myDepartment,
    referer:props.referer,
 })
 
 const submit=e=>{
    //form.transform(data=>({newDepartment:data.myDepartment.value,...data})).put(route('nodal.update',props.stateNodalOfficer.id));

    form.put(route('nodal.update',props.stateNodalOfficer.id))
 }

const filterFn=(val,update)=>{
    if(val){
        update(() => {
            options.value=props.departments.filter(item=>item.label.toLowerCase().includes(val.toLowerCase()))
        })
        return
    }
    update(() =>{
        options.value=props.departments
    })
}

 
</script>