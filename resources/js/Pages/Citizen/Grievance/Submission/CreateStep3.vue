
<template>

    <Head title="Step-3" />

        
        <form @submit.prevent="submit">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <a href="javascript:history.go(-1)">
                        <i class="q-icon material-icons-outlined">
                                    arrow_back
                        </i>
                        Back
                    </a>
                     

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        
                        <div class="p-6 text-gray-900 ml-3">
                           
                            <div>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Final Step</h2>
                            </div>
                            <div class="mb-4" v-html="department.label">  
                            </div>
                             
                           <div class="column mb-4">
                                <label for="grievance">Text of Grievance/ Vuivaina thu (Max: 60,000 characters)</label>
                                <q-input 
                                    label=""
                                    v-model="form.grievance" 
                                    type='textarea' 
                                    class="border p-1" 
                                    id="grievance" 
                                    rows="5"/>
                                <div v-if="props.errors.grievance" v-text="props.errors.grievance" class="text-red-500 text-xs mt-3"></div>
                           </div>

                           <div>
                                <q-file
                                    v-model="form.files"
                                    label="Select to upload attachment"
                                    outlined
                                    use-chips
                                    multiple
                                    style="max-width: 300px;"
                                    accept=".jpg,.jpeg,.png,.gif,.pdf"                                    
                                    max-files="10"
                                    append
                                    @rejected="onRejected"
                                    
                                />
                                <div v-if="props.errors.files" v-text="props.errors.files" class="text-red-500 text-xs mt-3"></div>

                                <span>Maximum 8 files. Supported file: jpg, png and pdf. Max total size 8 mb</span>

                           </div>

                            <div class="mt-3">
                                <input type="checkbox" v-model="form.agree" name="agree" id="agree" class="" /> <label for="agree" class="">I agree to the rules and regulations of Mipui Aw, DP&AR Govt. of Mizoram </label>
                                <div v-if="props.errors.agree" v-text="props.errors.agree" class="text-red-500 text-xs mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="m-5">
                        <q-btn label="Submit" color="primary" @click="confirm = true" />
                    </div>
                </div>
            </div>
        </form>
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


</template> 

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';

const props= defineProps([
    'errors',
    'department',
    'randomQuote',

]);

const q=useQuasar()

const confirm=ref(false)
 
let form = useForm({
    grievance:'',
    agree:Boolean,
    files:[],
});

const submitForm=()=>{
    let quote = props.randomQuote.quote +' - '+props.randomQuote.speaker

    form.transform(data=>({
        department_id:props.department.value,
        grievance:form.grievance,
        agree:form.agree,
        files:form.files,

    })).post('/grievance/store',{
        onStart:()=>q.loading.show({
            message: quote
        }),
        onFinish:()=>{
            q.loading.hide()
        }
    })
}
 


const onRejected=(rejecteEntries)=>{
    q.notify({
        type:'negative',
        message:`${rejecteEntries.length} file(s) did not pass validation constraints`
    })
}
 

</script>
