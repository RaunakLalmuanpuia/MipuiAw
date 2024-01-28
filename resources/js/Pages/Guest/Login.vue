

<template>
        <Head title="Log in" />
    <div class="row justify-center">
        <div class="border m-5 shadow-2" :class="$q.screen.xs?'col-11  ' :'col-6'">
             
            <div class="bg-grey-4 text-center text-2xl py-2 ">
                Login
            </div>

            <div class="p-5 ">   
                <form @submit.prevent="submit">
                    <div>
                        

                        <q-input
                            label="Email"
                            id="email"
                            type="email"
                            class="w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                  
                        <q-input
                            label="Password"
                            id="password"
                            dense=""
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
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

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Forgot your password?
                        </Link>

                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>
                    </div>
                    <div class=" flex justify-end mt-4">
                        <Link
                            v-if="canResetPassword"
                            :href="route('register')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Register
                        </Link>
                    </div>
                </form>
            </div>
            
        </div>
        
    </div>
    
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { usePage,Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue'
import { useQuasar } from 'quasar';

const page = usePage()
const isPwd = ref(true)
const q=useQuasar()

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onStart:()=>q.loading.show({
            message: "Processing..."
        }),
        onFinish: () => [form.reset('password'), q.loading.hide()],
    });
};

const isAuth = computed(() => page.props.isAuth)
</script>