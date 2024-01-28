<template>
    <Head title="Closed" />
    
    <div class="container">
        <a href="javascript:history.go(-1)">
            <i class="q-icon material-icons-outlined">
                        arrow_back
            </i>
            Back
        </a>

        <h3 class="ml-5">Delete Grievance only if it is necessary</h3>
      
        <p class="text-h5 text-red-6 ml-5">Caution : Data Deletion Alert - May Impact Other Users' Data</p>

        <div v-if="x_message" class="bg-green-2 border-green-9 mt-5 p-4   border-2" >
            <div class="text-green-9 text-h6 text-bold">
                Success!
            </div>
            <div class="text-grey-9" v-html="x_message"></div>
            

        </div>

            <form @submit.prevent="submit">
                <div class="py-3">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 ml-3">
                            
                                <div class="column mb-4">
                                    <label for="grievance">Registration Number :</label>
                                    <q-input 
                                        outlined
                                        label="Registration Number"
                                        v-model="form.registrationNumber" 
                                        
                                        />
                                    <!-- <div v-if="props.errors.grievance" v-text="props.errors.grievance" class="text-red-500 text-xs mt-3"></div> -->
                                </div>
                                <div class="">
                                    <q-btn label="Search" color="primary" @click="confirm = true" />
                                </div>
                            </div>
                        </div>
                        
                        <div v-if="props.grievanceDetails">
                 
                            <p class="text-h5 mt-2">Grievance Details</p>     
                            <div class="border shadow">
                        
                                <div>
                                    <div class="p-5">
                                        <div class="row m-3">
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                Registration Number
                                            </div>
                                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                {{ props.grievanceRequestForDelete.registration_number}}
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        <div class="row m-3">
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                Name
                                            </div>
                                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                {{ props.grievanceRequestForDelete.applicant_name}}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row m-3">
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                Date of receipt
                                            </div>
                                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                {{ date.formatDate(props.grievanceRequestForDelete.date_of_receipt,'DD MMM YYYY, hh:mm A') }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row m-3">
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                Residential Address
                                            </div>
                                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                {{ props.grievanceRequestForDelete.applicant_address}}
                                            </div>
                                        
                                        </div>
                                        <hr>
                                        
                                        <div class="row m-3">
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                District
                                            </div>
                                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                {{ props.grievanceRequestForDelete.applicant_district}}

                                            </div>
                                            
                                        </div>
                                        <hr>
                                        <div class="row m-3">
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                Mobile Number
                                            </div>
                                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                {{ props.grievanceRequestForDelete.applicant_mobile}}

                                            </div>
                                        
                                        </div>
                                        <hr>
                                        <div class="row m-3">
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                Email ID
                                            </div>
                                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                {{ props.grievanceRequestForDelete.applicant_email}}

                                            </div>
                                            
                                        </div>

                                        <hr>
                                        <div class="row m-3">
                                            
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                            Department
                                            </div>
                                            <div  :class="$q.screen.xs ? 'col-12':'col-8'" style="white-space:pre-line">
                                                {{ props.grievanceRequestForDelete.department.organization_name }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row m-3">
                                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                Grievance Description
                                            </div>
                                            <div :class="$q.screen.xs ? 'col-12':'col-8'" style="white-space:pre-line">
                                                {{ props.grievanceRequestForDelete.grievance_description}}
                                                
                                            </div>
                                            <div class="mt-10">
                                                <q-btn color="red" icon-right="delete" @click="confirm_delete=true" label="Delete" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="props.grievanceRequestForDelete==false">
                            <p>Not Found!</p>
                        </div>

                        
                    </div>
                </div>
            </form>
        <div class="q-pa-md">

           
        </div>
    </div>

    <q-dialog v-model="confirm">
        <q-card>
            <q-card-section class="row items-center">
            <q-avatar icon="done" color="primary" text-color="white" />
            <span class="q-ml-sm">Are you sure you want to submit?</span>
            </q-card-section>

            <q-card-actions align="right">
            <q-btn flat label="Cancel" color="primary" v-close-popup />
            <q-btn flat label="Submit" @click="submitForm" color="primary" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-dialog v-model="confirm_delete">
        <q-card>
            <q-card-section class="row items-center">
                <q-avatar icon="delete" color="red" text-color="white" />
                <span class="q-ml-sm">Type the below text to delete?</span>
            </q-card-section>
            <q-card-section>
                <div>
                    Type: <b>{{ matchingText }}</b>

                </div>
                <div>
                    <q-input v-model="deleteConfirm.text" dense/>
                </div>
            </q-card-section>
        
            <q-card-actions  align="right">
                <q-btn flat label="Cancel" color="primary" v-close-popup />
                <q-btn v-show="deleteConfirm.text===matchingText" flat label="Delete" @click="submitFormDelete" color="primary" v-close-popup />
            </q-card-actions>


        </q-card>
    </q-dialog>
</template>


<script setup>
import {ref,computed} from 'vue';
import {router, useForm,Head,usePage} from "@inertiajs/vue3";
import { date } from "quasar";
import { useQuasar } from 'quasar';

const q=useQuasar()
const page = usePage()

const x_message = computed(() =>page.props.flash.message)

const props = defineProps([
    'grievances','search','error',
    'grievanceDetails','grievanceRequestForDelete',
          
])
  
const matchingText='Delete'+ Math.floor(Math.random() * (111 - 999 + 1)) + 111
const confirm=ref(false)
const confirm_delete=ref(false)

let deleteConfirm = useForm({
    text:'',
})

let form = useForm({
    registrationNumber:'',
     
});

const submitForm=()=>{
     form.transform(data=>({
        registrationNumber:form.registrationNumber,
    })).post('/dashboarddeleteShow',{
        onStart:()=>q.loading.show({message:'Searching...'}),
        onFinish:()=>{
            q.loading.hide()
        }
    })
}

const submitFormDelete=()=>{
     form.transform(data=>({
        registrationNumber:form.registrationNumber,
    })).post('/dashboarddeleteDestroy',{
        onStart:()=>q.loading.show({message:'Deleting...'}),
        onFinish:()=>{
            q.loading.hide()
        }
    })
}

</script>