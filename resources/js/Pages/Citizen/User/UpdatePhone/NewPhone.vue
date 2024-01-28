<template>
    <Head title="Update Phone" />
    <div class="m-5">
        <Link class="full-width border" onclick="history.back();return false;"  >
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
        <div class="border shadow">
            <div class="row p-3 bg-grey-4 text-h5 " >
                <div  :class="$q.screen.xs ? 'col-12':'col-8'">
                      Update Phone Number
                </div>
                 
            </div>
            
            <div>
                <div class="p-5">
                      
                 <div>
                    Old Phone : {{ props.CURRENT_USER.mobile }} 
                 </div> 
                 <div>
                    New Phone : <q-input outlined dense 
                    v-model="new_mobile" 
                    style="width: 300px;" 
                    mask="##########"
                    :rules="[val => val.length ==10 || 'Must be 10 digits']"
                    maxlength="10"
                    required
                    :error="!props.errors.new_mobile===false"
                    :error-message="props.errors.new_mobile"
                    />
                 </div>


                 <q-btn color="primary" class="mt-2"   @click="sentOtpClick()">
                    Send OTP
                 </q-btn>
                  
                  
                 
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { useForm,Head,router,usePage} from "@inertiajs/vue3";
import {ref,onMounted,computed} from 'vue';
import { date, useQuasar } from "quasar";
 
const q = useQuasar()
  
const new_mobile =ref('')
const isReadOnly = ref(false)

const props = defineProps([
    'CURRENT_USER','errors'
])

const user_otp = ref('')
const showOtpField = ref(false)

let form = useForm({
    new_mobilex:'',
    
    
})

const sentOtpClick=()=>{
  

   form.transform(data=>({
    new_mobile:new_mobile.value,
    

   })).get('/generateOtpForMobileUpdate',{
    onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{
            q.loading.hide()
        },
        onSuccess:()=> {
           
            q.notify({
                message: 'OTP Request Successfully',
                icon:'check',
                iconColor:'blue'
            });
        }
   })
} 

</script>