<template>
 <Head title="OTP Confirmation" />
 <div class="row justify-center">
        <div class="col-6 border m-5 shadow-2">
             
            <div class="bg-grey-4 text-center text-2xl py-2">
                Enter OTP
            </div>
            <div class="p-5">   
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email" />
                        <q-input
                            input-class="text-center text-h4"
                            outlined
                            class="mt-1 block w-full "
                            v-model="form.userOtp"
                            required
                            autofocus
                            :rules="[val => val.length == 6]"
                            maxlength="6"
                            
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <q-btn color="primary" label="Register" @click="submit" />
                            
                        
                    </div>
                    <div>
                        Resent OTP: {{ minutes }}:{{ seconds }}
                        <div>
                          <Link class="full-width text-blue-7" :href="route('register')">
                              Back
                          </Link>
                        </div>
                        
                    </div>
                    <div v-show="resentOtpGate">
                      <Link class="full-width text-blue-7" :href="route('resentOtp',props.verification_id)">
                              Re-Sent OTP
                    </Link>
                    </div>
                </form>
            </div>
            <div v-show="props.error" class="text-center text-2xl text-red py-2">
                        Wrong OTP!
            </div>
        </div>
        
    </div>
 
</template>

<script setup>
import { usePage,Head, Link, useForm } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useQuasar } from 'quasar';

const q=useQuasar()

const minutes = ref(0); // initial minutes
const seconds = ref(30); // initial seconds

let resentOtpGate = ref(false)

const props = defineProps([
    'verification_id',
    'error'
])

const form = useForm({
    userOtp: '',
    verification_id: props.verification_id,
});

const submit = () => {
    form.post(route('verification'), {
      onStart:()=>q.loading.show({
            message: "Processing..."
        }),

        onFinish: () => [ q.loading.hide()],

    });
};

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