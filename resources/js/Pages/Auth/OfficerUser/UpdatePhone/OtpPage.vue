<template>
    <Head title="OTP Page" />
    <div v-if="props.error" class="bg-red-2 border-red-9 mt-5 p-4   border-2" >
        
        <div class="text-red-9 text-h6 text-bold">
            WARNING!
        </div>
        <div class="text-grey-9">
            {{ props.error }}    
        </div>
    </div>
    <div v-if="x_message_success" class="bg-green-2 border-green-9 mt-5 p-4   border-2" >
       
        <div class="text-green-9 text-h6 text-bold">
            Success!
        </div>
        <div class="text-grey-9">
            {{ x_message_success}}    
        </div>
    </div>
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
                      Enter OTP
                </div>
                 
            </div>
            
            <div>
                <div class="p-5">
                    <div>
                        New Phone : {{ props.new_mobile }} 
                    </div> 
                 <div >
                    OTP:
                     <q-input outlined dense 
                        v-model="userOtp" 
                        style="width: 300px;" 
                        mask="######"
                        :rules="[val => val.length ==6 || 'Must be 6 digits']"
                        maxlength="6"
                    />
                    <div v-show="resentOtpGate" class="cursor-pointer" @click="resentOtpClick()">
                    Resent OTP
                    </div>
                    <div>
                        Resent after : {{ minutes }}:{{ seconds }}

                    </div>
                    <div>
                        OTP Expires after 5 mins
                    </div>
                    <q-btn class="mt-2 cursor-pointer" @click="submitOtp()">
                        Submit
                    </q-btn>
            
                 </div>
                 
                </div>
            </div>
        </div>
    </div>
     
</template>

<script setup>

import { useForm,Head,router,usePage} from "@inertiajs/vue3";
import {ref,onMounted,computed} from 'vue';
import { date, useQuasar } from "quasar";
const minutes = ref(1); // initial minutes
const seconds = ref(0); // initial seconds
let resentOtpGate = ref(false)

const q = useQuasar()
const page = usePage()

const x_message = computed(() => page.props.flash.message)
const x_message_success = computed(() => page.props.flash.message_success)

const userOtp = ref('')

const props = defineProps([
    'verification_id', 'new_mobile','error'
])

const user_otp = ref('')
 
let form = useForm({
    new_mobile:'',
    userOtp:'',
    verification_id:''
})

const submitOtp=()=>{
  
   form.transform(data=>({
    new_mobile:props.new_mobile,
    userOtp:userOtp.value,
    verification_id:props.verification_id,

   })).post('/verificationForMobileUpdate',{
    onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{
            q.loading.hide()
        },
        onSuccess:()=> {
            
            
        }
   })
}
const resentOtpClick=()=>{
 
   form.get('/resentOtpForMobileUpdate/'+props.verification_id,{
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


// Start the countdown on component mount
onMounted(() => {
  const interval = setInterval(() => {
    if (seconds.value === 0) {
      if (minutes.value === 0) {
        clearInterval(interval);
      } else {
        minutes.value--;
        seconds.value = 59;
      }
    } else {
      seconds.value--;
    }
    if(seconds.value===0 && minutes.value===0){
      resentOtpGate=true
    }
  }, 1000);
});
  

</script>