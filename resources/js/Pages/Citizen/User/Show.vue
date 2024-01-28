<template>
    <Head title="Applicant Details" />
    <div class="m-5">
        <Link class="full-width border" :href="route('citizen.dashboard')" >
            <div class="row mt-3 ">
                <q-item-section avatar>
                    <i class="q-icon material-icons-outlined">
                        arrow_back
                    </i>
                    </q-item-section>
                    <q-item-section>
                        Back
                </q-item-section>
            </div>  
        </Link>
        <div v-if="x_message" class="bg-green-2 border-green-9 mt-5 p-4 mb-3  border-2" >
            <div class="text-green-9 text-h6 text-bold">
                Success!
            </div>
            <div class="text-grey-9">
                {{ x_message }}    
            </div>
        </div>
        <div class="border shadow">
            <div class="row p-3 bg-grey-4 text-h5 " >
                <div  :class="$q.screen.xs ? 'col-12':'col-8'">
                    {{ props.user.name}}'s Detail
                </div>
                <div class="m-1" :class="$q.screen.xs ? 'col-12':'col-1'">
                    <q-btn label="Edit" color="primary" @click="openEditModal(props.user)" />
                </div>
                 
            </div>
            
            <div>
                <div class="p-5">
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Name
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.name??'-'}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Mobile
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.mobile??'-'}} 
                            <span @click="$inertia.get(route('mobile.change'))" class="ml-5 text-blue cursor-pointer" style="text-decoration: underline;">Edit Mobile</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Email
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.email??'-'}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Gender
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.gender??'-'}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Address
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.address??'-'}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Pincode
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.pincode??'-'}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Alternate Mobile (Optional)
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.alternate_mobile??'-'}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            District
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.district??'-'}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Active
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            <div v-if="props.user.active==0">
                                <q-chip color="red" text-color="white" label="No" />
                            </div>
                            <div v-else-if="props.user.active==1">
                                <q-chip color="green" text-color="white" label="Yes" />
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Password
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                <q-btn label="Change Password"  @click="changePasswordModal=true"  />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- MODALS EDIT -->
<q-dialog v-model="modal">
    <q-card>
        <q-toolbar>
            <q-toolbar-title><span class="text-weight-bold">Edit Details</span></q-toolbar-title>
            <q-btn flat round dense icon="close" v-close-popup/>
        </q-toolbar>

        <q-card-section>
            <form @submit.prevent="submit" method="post">
                <div class="q-pa-md">
                    <div class="q-gutter-x-md column" style="width: 400px">
                        <q-input
                            name="name"
                             
                            v-model="form.name"
                            :error="!form.errors.name===false"
                            :error-message="form.errors.name"
                            label="Full Name">
                        </q-input>
                        <div v-if="CURRENT_USER.role_id!=5">
                            <q-input 
                            name="mobile"
                            mask="##########"
                            :rules="[val => val.length ==10 || 'Must be 10 digits']"
                            maxlength="10"
                            v-model="form.mobile"
                            :error="!form.errors.mobile===false"
                            :error-message="form.errors.mobile"
                            label="Mobile">
                        </q-input> 
                        </div>
                        

                        <q-input
                            name="email"
                             
                            v-model="form.email"
                            :error="!form.errors.email===false"
                            :error-message="form.errors.email"
                            label="Email">
                        </q-input>

                        <q-select
                            v-model="form.gender"  
                            input-debounce="0"
                            label="Gender"
                            :options="gender"
                            :error="!form.errors.gender===false"
                            :error-message="form.errors.gender"
                            style="width: 250px"
                        >
                        </q-select>

                        <q-input
                            name="address"
                             
                            v-model="form.address"
                            :error="!form.errors.address===false"
                            :error-message="form.errors.address"
                            label="Address">
                        </q-input>

                        <q-input
                            name="pincode"
                             
                            v-model="form.pincode"
                            :error="!form.errors.pincode===false"
                            :error-message="form.errors.pincode"
                            label="Pincode">
                        </q-input>

                        <q-input
                            name="alternate_mobile"
                             
                            v-model="form.alternate_mobile"
                            :error="!form.errors.name===false"
                            :error-message="form.errors.alternate_mobile"
                            label="Alternate Mobile (Optional)">
                        </q-input>

                        <q-select
                            v-model="form.district"  
                            input-debounce="0"
                            label="District"
                            :options="districts"
                            :error="!form.errors.district===false"
                            :error-message="form.errors.district"
                            style="width: 250px"
                        >
                        </q-select>

                        <q-select
                            v-model="form.active"  
                            input-debounce="0"
                            label="Active"
                            :options="active"
                            :error="!form.errors.active===false"
                            :error-message="form.errors.active"
                            style="width: 250px"
                            
                        >
                        </q-select>
                        
                        <q-btn label="Update" dense color="black" type="submit"
                                :disable="form.processing"/>
                    </div>
                </div>
            </form>
        </q-card-section>
    </q-card>
</q-dialog>

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
                            name="current_password"
                            v-model="passwordForm.current_password"
                            :error="!passwordForm.errors.current_password===false"
                            :error-message="passwordForm.errors.current_password"
                            label="Current Password"
                            required
                            :type="isPwdOld ? 'password' : 'text'"
                            >
                            <template v-slot:append>
                                <q-icon
                                    :name="isPwdOld ? 'visibility_off' : 'visibility'"
                                    class="cursor-pointer"
                                    @click="isPwdOld = !isPwdOld"
                                />
                            </template>
                        </q-input>
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
                            :type="isPwdConfirm ? 'password' : 'text'"
                            >
                            <template v-slot:append>
                            <q-icon
                                :name="isPwdConfirm ? 'visibility_off' : 'visibility'"
                                class="cursor-pointer"
                                @click="isPwdConfirm = !isPwdConfirm"
                            />
                            </template>
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
import { useForm,Head,router,usePage} from "@inertiajs/vue3";
import {ref,onMounted,computed} from 'vue';
import { date, useQuasar } from "quasar";


const gender =['Female','Male']
const districts=['Aizawl','Lunglei','Champhai','Kolasib','Serchhip','Mamit','Siaha','Lawngtlai','Khawzawl','Saitual','Hnahthial',]
const active=[{label:'Yes',value:1},{label:'No',value:0}]

const page = usePage()
const q = useQuasar()

const x_message = computed(() => page.props.flash.message)
const CURRENT_USER = computed(() => page.props.CURRENT_USER)

const modal = ref(false)
const changePasswordModal = ref(false)
 
const isPwdOld = ref(false)
const isPwd = ref(true)
const isPwdConfirm = ref(true)

const form = useForm({
    id:'',
    email:'',
    name:'',
    mobile:'',
    gender:'',
    address:'',
    pincode:'',
    alternate_mobile:'',
    district:'',
    active:'',
})
const passwordForm = useForm({
    current_password:'',
    password:'',
    password_confirmation:'',
}) 

const props = defineProps([
    'user',
])

const openEditModal=e=>{
    modal.value=true
    form.id = e.id
    form.name = e.name
    form.mobile = e.mobile
    form.email = e.email
    form.gender = e.gender
    form.address = e.address
    form.pincode = e.pincode
    form.alternate_mobile = e.alternate_mobile
    form.district = e.district
    form.active = e.active==1?active[0]:active[1]

    
}

const submit=e=>{
    form.put(route('user.details.update',form.id),{
        onSuccess:() => {
            modal.value= false
            q.notify({
                    message: 'User Updated',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                });
        }
    })
}

const submitChangePassword=e=>{
    passwordForm.post(route('password.change'),{
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


</script>


