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
                            <q-input v-model="form.mobile" 
                            label="Mobile" 
                            :dense="dense" 
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
                            />                            <div v-if="form.errors.gender" v-text="form.errors.gender" class="text-red-500 text-xs mt-3"></div>
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


                        <div>
                            <q-input v-model="form.notification" label="Notification" :dense="dense" />
                            <div v-if="form.errors.notification" v-text="form.errors.notification" class="text-red-500 text-xs mt-3"></div>
                        </div>

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

                    <div  v-show="props.stateNodalOfficer.role_id!=3"  class="mt-3">
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

                    <div class="mt-5">
                        <q-btn label="Change Password"  @click="openChangePasswordModal"  />

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

<!-- MODALS CHANGE PASSWORD -->
<q-dialog v-model="changePasswordModal" persistent>
    <q-card>
        <q-toolbar>
            <q-toolbar-title><span class="text-weight-bold">Change Password</span></q-toolbar-title>
            <q-btn flat round dense icon="close" v-close-popup/>
        </q-toolbar>

        <q-card-section>
            <form @submit.prevent="submit" method="post">
                <div class="q-pa-md">
                    <div class="q-gutter-x-md column" style="width: 400px">
                        
                        <q-input
                            name="password"
                            v-model="passwordForm.password"
                            :error="!passwordForm.errors.password===false"
                            :error-message="passwordForm.errors.password"
                            label="New Password"
                            required
                            :type="isPwd ? 'password' : 'text'"
                            >
                            <template v-slot:append>
                            <q-icon
                                :name="isPwd ? 'visibility_off' : 'visibility'"
                                class="cursor-pointer"
                                @click="isPwd = !isPwd"
                            />
                            </template>
                        </q-input>
                        <q-input
                            name="password_confirmation"
                            v-model="passwordForm.password_confirmation"
                            :error="!passwordForm.errors.password_confirmation===false"
                            :error-message="passwordForm.errors.password_confirmation"
                            label="New Password Confirmation"
                            required
                            >
                          
                        </q-input>
                          
                        
                        <q-btn label="Update" dense color="black" @click="submitChangePassword"
                                :disable="passwordForm.processing"/>
                    </div>
                </div>
            </form>
        </q-card-section>
    </q-card>
</q-dialog>
 
</template>

<script setup>
 import { useForm,Head } from '@inertiajs/vue3';
 import {ref} from 'vue'
 import { useQuasar } from "quasar";

 const q = useQuasar()

 const props = defineProps([
    'roles',
    'stateNodalOfficer',
    'subDepartment',
    'currentSubDepartment',
 ])

 const passwordForm = useForm({
    officer_id: props.stateNodalOfficer.id,
    password:'',
    password_confirmation:'',
})

 const modelMultiple='';
 const changePasswordModal = ref(false)

const openChangePasswordModal=e=>{
    changePasswordModal.value=true
    
}

const submitChangePassword=e=>{
    passwordForm.post(route('admin.officer.passsword.change'),{
        onSuccess:()=>{
            changePasswordModal.value=false
            q.notify({
                message:'Password Update Successfully',
                closeBtn: true,
                icon: 'check',
                iconColor: 'blue'
            })
        }
    })
}

 const options=ref(props.subDepartment)
 const active=[{label:'Yes',value:1},{label:'No',value:0}]
 const gender=['Female','Male']
 const form = useForm({
    
    name: props.stateNodalOfficer.name,
    email:props.stateNodalOfficer.email,
    role_id:props.stateNodalOfficer.role_id,
    mobile:props.stateNodalOfficer.mobile,
    gender:props.stateNodalOfficer.gender,
    designation:props.stateNodalOfficer.designation,
    address:props.stateNodalOfficer.address,
    pincode:props.stateNodalOfficer.pincode,
    alternate_mobile:props.stateNodalOfficer.alternate_mobile,
    notification:props.stateNodalOfficer.notification,
    active:props.stateNodalOfficer.active==1?active[0]:active[1],

    roles:props.roles.name,
    subDepartment:props.currentSubDepartment,
    department:props.stateNodalOfficer.department,
 })
 
 const submit=e=>{
    form.put(route('departmentnodal.update',props.stateNodalOfficer.id))
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