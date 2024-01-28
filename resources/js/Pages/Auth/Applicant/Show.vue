<template>
    <Head title="Applicant Details" />
    <div class="m-5">
        <q-btn  class="mb-3" href="#" onclick="history.back();return false;" color="grey-4" text-color="black" label="Back" />
       

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
                            Full Name
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.name}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Mobile
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.mobile}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Email
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.email}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Gender
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.gender}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Residential Address
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.address}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Pincode
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.pincode}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            Alternate Mobile (Optional)
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.alternate_mobile}}
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div :class="$q.screen.xs ? 'col-12':'col-4'">
                            District
                        </div>
                        <div :class="$q.screen.xs ? 'col-12':'col-8'">
                            {{ props.user.district}}
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
                </div>
            </div>
        </div>
    </div>
    
<!-- MODALS -->
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

                        <q-input
                            name="mobile"
                             
                            v-model="form.mobile"
                            :error="!form.errors.mobile===false"
                            :error-message="form.errors.mobile"
                            label="Mobile">
                        </q-input>

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
                            label="Residential Address">
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
                        
                        <q-input
                            name="password"
                             
                            v-model="form.password"
                            :error="!form.errors.password===false"
                            :error-message="form.errors.password"
                            label="Password (Leave blank to retain current password)">
                            
                        </q-input>
                        
                        <q-btn label="Update" dense color="black" type="submit"
                                :disable="form.processing"/>
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
const districts=[  'Aizawl','Lunglei','Champhai','Kolasib','Serchhip','Mamit','Siaha','Lawngtlai','Khawzawl','Saitual','Hnahthial',]
const active=[{label:'Yes',value:1},{label:'No',value:0}]



const page = usePage()
const q = useQuasar()
const modal = ref(false)

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
    password:'',
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
    console.log("Im the only one: "+e)
    form.put(route('applicant.update',form.id),{
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



</script>


