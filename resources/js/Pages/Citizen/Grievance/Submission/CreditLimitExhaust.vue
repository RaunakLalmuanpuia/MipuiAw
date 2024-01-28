

<template>
   
    <Head title="Dashboard" />
        <form @submit.prevent="submit">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        
                        Your monthly limit of <b>{{ props.monthlyLimit.monthly_limit }}</b> grievances has been exhausted. Your limit will be refreshed next month.
                    </div>
                    <div class="m-5 ">
                        
                        <a href="javascript:history.go(-1)">
                            <i class="q-icon material-icons-outlined">
                                        arrow_back
                            </i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </form>
     
</template>
<script setup>

import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
 import { ref } from 'vue'

 

const props = defineProps([
    'monthlyLimit'
])
</script>
 