<template>
  
<Head  title="Create User"></Head>

<h1> Create New User</h1>
<form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
    <div class="mb-6">
        <label for="name" class="block mb-2 uppercase font-bold text-xs text-grey-700"> Name</label>
        <input type="text" v-model="form.name" class="border border-gray-400 p-2 w-full" name="name" id="name" required>
        <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-3"></div>
    </div>
    <div class="mb-6">
        <label for="email" class="block mb-2 uppercase font-bold text-xs text-grey-700"> Email</label>
        <input type="email" v-model="form.email" class="border border-gray-400 p-2 w-full" name="email" id="email" required>
        <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-3"></div>

    </div>
    
    <div class="mb-6">
        <label for="password" class="block mb-2 uppercase font-bold text-xs text-grey-700">Password</label>
        <input type="password" v-model="form.password" class="border border-gray-400 p-2 w-full" name="password" id="password" required>
        <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-3"></div>

    </div>
    <div class="mb-6">
        <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500" :disabled="form.processing">
            Submit
        </button>
    </div>
    
</form>


</template>

<script setup>
import Layout from '@/Shared/Layout.vue'; 
import {Inertia} from "@inertiajs/inertia";
import { useForm } from '@inertiajs/vue3';

defineProps({
    errors:Object
});

let form = useForm({
    name:'',
    email:'',
    password:''
});

let submit = () => {
    form.post('/users');
};
</script>
9523 2082 2729
101965305386
sASwHp@$*732 new- Lorenzo@99