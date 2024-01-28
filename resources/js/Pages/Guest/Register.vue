

<template>
    
        <Head title="Register" />

        <div class="row justify-center mt-3">
            <div class="text-center border p-5 bg-blue-3 text-2xl shadow-3"
            :class="$q.screen.xs?'col-11 ' :'col-8'">
                Nodal officer te tan he ta tang a in register ve loh tur
            </div>
            
        </div>
        <div class="row justify-center">
           
            <div class="border m-5 shadow-2" 
                :class="$q.screen.xs?'col-11':'col-8'">
                

                <div class="bg-grey-4 text-center text-2xl py-2">
                    Registration for Citizen Only
                </div>

                <div class="p-5">  
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel class="required" for="name" value="Full Name" />
                           

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="required" for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="required"  for="password" value="Password" >
                              
                                </InputLabel>

                            <q-input
                                id="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                                :rules="[ val => val.length >= 4 || 'Please use minimum 4 characters']"
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

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="required" for="password_confirmation" value="Confirm Password" />
                            <q-input
                                id="password_confirmation"
                                class="mt-1 block w-full"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
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

                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="required" for="address" value="Address" />
                            <TextInput
                                id="address"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.address"
                                required
                                autocomplete="address"
                            />
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="required" for="district" value="District" />
                             
                            <q-select
                                        
                                        v-model="form.district"
                                        label="Select District"
                                        :options="districts"
                                          
                                        
                                    /> 
                            <InputError class="mt-2" :message="form.errors.district" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="required" for="gender" value="Gender" />
                                <q-radio v-model="form.gender" val="Female" label="Female"/>
                                <q-radio v-model="form.gender" val="Male" label="Male"/>
                            <InputError class="mt-2" :message="form.errors.gender" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="required" for="mobile" value="Mobile (10 digits)" />
                            
                            <q-input
                                class=""
                                mask="##########"
                                :rules="[val => val.length ==10 || 'Must be 10 digits']"
                                v-model="form.mobile"
                                maxlength="10"
                                counter
                                />

                            <InputError class="mt-2" :message="form.errors.mobile" />


                        </div>

                         
                         

                        <div class="flex items-center justify-end mt-4">
                            <Link
                                :href="route('login')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Already registered?
                            </Link>
                            <q-btn label="Submit" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" color="green-9" @click="confirm = true" />

                            
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <q-dialog v-model="confirm">
            <q-card>
                <q-card-section class="row items-center">
                <q-avatar icon="done" color="green-9" text-color="white" />
                <span class="q-ml-sm">Are you sure you want to Submit?</span>
                </q-card-section>

                <q-card-actions align="right">
                <q-btn flat label="Cancel" color="green-9" v-close-popup />
                <q-btn flat label="Submit" @click="submitForm" color="green-9" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
    
</template>
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useQuasar } from 'quasar';

const confirm=ref(false)
 
const isPwd = ref(true)
const isPwdConfirm = ref(true)

const q=useQuasar()

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    address:'',
    district:'',
    gender:'',
    mobile:'',

});

const submitForm = () => {
    
    form.post(route('generateOtp'), {
        onStart:()=>q.loading.show({
            message: "Processing..."
        }),
        onFinish: () => [form.reset('password', 'password_confirmation'), q.loading.hide()],
    });
};

const submit = () => {
    // form.post(route('register'), {
    //     onFinish: () => form.reset('password', 'password_confirmation'),
    // });
    
};

const districts=[
    'Aizawl','Lunglei','Champhai','Kolasib','Serchhip','Mamit','Siaha','Lawngtlai','Khawzawl','Saitual','Hnahthial',
]
</script>
