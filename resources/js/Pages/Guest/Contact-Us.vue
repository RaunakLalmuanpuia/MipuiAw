

<template>
        <Head title="Contact Us" />
    <div class="row justify-center">
            <div v-if="x_message" :class="$q.screen.xs?'col-11  ' :'col-6'" class=" bg-green-2 border-green-9 mt-5 p-4   border-2" >
                    <div class="text-green-9 text-h6 text-bold">
                        Success!
                    </div>
                    <div class="text-grey-9" v-html="x_message" ></div>
                    

            </div>
        <div class="border m-5 shadow-2" :class="$q.screen.xs?'col-11  ' :'col-6'">
            
            <div class="bg-grey-4 text-center text-2xl py-2 ">
                Feedback
            </div>

            <div class="p-5 ">   
                <form @submit.prevent="submit">
                    <div>
                        <q-input
                            label="Name"
                            id="name"
                            type="text"
                            class="w-full mb-3"
                            v-model="form.name"
                            required
                            autofocus
                            outlined
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <q-input
                            label="Email"
                            id="email"
                            type="text"
                            class="w-full mb-3"
                            v-model="form.email"
                            required
                            outlined
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <q-input
                            label="Phone"
                            id="phone"
                            class="w-full mb-3"
                            v-model="form.phone"
                            required
                            outlined
                            autocomplete="phone"
                            maxlength="10"
                            counter
                            mask="##########"
                            :rules="[val => val.length ==10 || 'Must be 10 digits']"
                        />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>

                    <div>
                        <q-input
                            label="Subject"
                            id="subject"
                            type="text"
                            class="w-full mb-3"
                            v-model="form.subject"
                            required
                            outlined
                            autocomplete="subject"
                        />
                        <InputError class="mt-2" :message="form.errors.subject" />
                    </div>
                    
                    <div>
                        <q-input 
                            label="Message"
                            v-model="form.message" 
                            type='textarea' 
                            class="mb-3" 
                            id="message" 
                            outlined
                            rows="5"
                            maxlength="400"
                            counter
                            
                            :rules="[val => val.length <=400 || 'Must be 400 characters']"
                            />
                         
                        <InputError class="mt-2" :message="form.errors.message" />

                        <q-input
                            label="honeypot"
                            id="honeypot"
                            class="w-full mb-3 hidden"
                            v-model="form.honeypot"
                        />
                    </div>

                    <div class=" flex justify-center mt-4">
                        <q-btn @click="feedbackClick" color="primary" label="Submit" />
                    </div>
                </form>
            </div>
            
        </div>
        
    </div>
    
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import { usePage,Head, Link, useForm } from '@inertiajs/vue3';
import { ref,computed } from 'vue'
import { useQuasar } from 'quasar';

const page = usePage()
const isPwd = ref(true)
const q=useQuasar()
const x_message = computed(() =>page.props.flash.message)

defineProps([
    'errors',
]);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    honeypot:'',
    source:'guest',
});

const feedbackClick = () => {
    form.post(route('contactus'), {
        onStart:() => q.loading.show({
            message: "Processing..."
        }),
        onFinish: () => [form.reset('password'), q.loading.hide(),
        //form.name='',form.email='',form.subject='',form.message='',
    ],
    });
};

</script>