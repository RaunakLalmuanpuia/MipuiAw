

<template>
   
    <Head title="Dashboard" />
        <form @submit.prevent="submit">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                       
                        <div class="p-6 text-gray-900 ml-3">
                            <div class="border p-2 bg-grey-2 text-xl">
                               <p> You can sent a maximum of <span><b>{{ props.monthlyLimit.monthly_limit}}</b></span> per month.</p>
                               <p> Total Sent: <b>{{ props.grievanceCount }} </b> </p>
                               <p> Remaining Credit :<b> {{ props.creditRemains }} </b></p>

                             
                            </div>
                            <div>
                                <h2 class="mt-5 font-semibold text-xl text-gray-800 leading-tight">Step 1</h2>
                            </div>
 
                            <div class="text-right">
                                 
                                <div>
                                    <q-btn-toggle
                                    v-model="languageToggle"
                                    size="sm"
                                    class="my-custom-toggle"
                                    no-caps
                                    rounded
                                    unelevated
                                    toggle-color="blue"
                                    color="white"
                                    text-color="blue"
                                    :options="[
                                    {label: 'Mizo', value: 'mizo'},
                                    {label: 'English', value: 'english'}
                                    
                                    ]"
                                    />
                                </div>
                                
                                <div class="text-caption">Language Toggle</div>
                                
                              
                            </div>
                            <div v-if="languageToggle=='english'"  class="ml-3 mb-5">
                                <div class="mb-2 mt-2 text-xl ">
                                     
                                    <div>List of subjects/topics which can not be treated as grievance. </div>
                                </div>
                                <li>
                                    RTI Matters 
                                </li>
                                <li>
                                    Court related / Subjudice matters 
                                </li>
                                <li>
                                    Religious matters 
                                </li>
                                <li>
                                    Suggestions 
                                </li>
                                <li>
                                    Grievances of Government employees concerning their service matters including disciplinary proceedings etc. unless the aggrieved employee has already exhausted the prescribed channels keeping in view the DoPT OM No. 11013/08/2013-Estt.(A-III) dated 31.08.2015
                                </li>
                            </div>
                             
                            <div v-if="languageToggle=='mizo'" class="ml-3 mb-5">
                                <div class="mb-2 mt-2 text-xl ">
                                    <div class="text-caption"> </div>
                                    <div>A hnuaia mi ho hi Vuivaina anga ngiah theih loh ho. </div>
                                </div>
                                <li>
                                    RTI lam 
                                </li>
                                <li>
                                    Court lam thil
                                </li>
                                <li>
                                    Sakhuana lam
                                </li>
                                <li>
                                    Mimal ngaihdan
                                </li>
                                <li>
                                    (Mizo)Grievances of Government employees concerning their service matters including disciplinary proceedings etc. unless the aggrieved employee has already exhausted the prescribed channels keeping in view the DoPT OM No. 11013/08/2013-Estt.(A-III) dated 31.08.2015
                                </li>
                            </div>

                            <div v-if="languageToggle=='english'"> 
                                <input type="checkbox" v-model="form.agree" name="agree" id="agree" class="" /> <label for="agree" class="">I agree that my grievance does not fall in any of the above listed categories </label>
                                <div v-if="props.errors.agree" v-text="props.errors.agree" class="text-red-500 text-xs mt-3"></div>
 
                            </div>
                            <div v-if="languageToggle=='mizo'">
                                <input type="checkbox" v-model="form.agree" name="agree" id="agree" class="" /> <label for="agree" class="">Ka vuivaina hi a chunga tarlan zingah hian a tel lo tih hi ka pawm a ni </label>
                                <div v-if="props.errors.agree" v-text="props.errors.agree" class="text-red-500 text-xs mt-3"></div>
 
                            </div>
                        </div>
                    </div>
                    <div class="m-5 ">
                        <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </form>
     
</template>
<script setup>

import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
 import { ref } from 'vue'

const languageToggle=ref('mizo')

const showMizo=ref(true)
const showEnglish=ref(false)

const props = defineProps([
    'errors','monthlyLimit',
    'grievanceCount','creditRemains'

]
);

let form = useForm({
    agree:Boolean,
});

let submit=()=>{

    form.get('/grievance2');

 
};
</script>
<style lang="sass" scoped>
.my-custom-toggle
  border: 1px solid #2196f3
</style>