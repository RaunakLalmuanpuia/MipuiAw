<template>
    <Head title="Appeal" />
    <div class="mt-5 ml-5">
        <h3>Lodge Appeal</h3>

        <div>
            <div>
                <q-banner class="bg-light-blue-2 border text-red-8 m-5">
                    Please Note : This option can be used to lodge appeal for the grievances which are closed during last 30 days where the feedback has been provided as "POOR" and option to file appeal was not selected 
                </q-banner>
            </div>
            <div class="row m-3">

                <div class=" mr-5 text-bold" :class="$q.screen.xs ? 'col-12 text-left':'col-3 text-right'">
                    Registration Number
                </div>
                 
                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                    <q-select 
                        stack-label
                        v-model="form.grievance" 
                        :options="props.grievances" 
                        label="-- Select registration number --"
                        dense outlined
                    />
                    <div v-if="form.errors.grievance" v-text="form.errors.grievance" class="text-red-500 text-xs mt-3"></div>

                </div>
                
            </div>
            <div class="row m-3">
                <div class="mr-5 text-bold" :class="$q.screen.xs ? 'col-12 text-left':'col-3 text-right'">
                    Reason For Appeal
                </div>
                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                   <div class="text-blue">Maximum 2000 characters are allowed in the textbox
 
                   </div>
                   <div>
                        <q-input type='textarea' 
                        class="border p-3" 
                        id="reason" 
                        v-model="form.reason" 
                        rows="5"
                        :rules="[val => val.length == 2000]"
                        maxlength="2000"
                        counter
                        />
                        <div v-if="form.errors.reason" v-text="form.errors.reason" class="text-red-500 text-xs mt-3"></div>

                   </div>
                </div>
                
            </div>
            <div class="row m-3 mt-3">

                <div class=" mr-5 text-bold" :class="$q.screen.xs ? 'col-12 text-left':'col-3 text-right'">
                     
                </div>
                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                    <q-btn color="primary" icon="save" label="Submit" @click="appealSubmitClick"/>

                </div>

            </div>
            <div v-if="x_message" class="bg-red-2 border-red-9 mt-5 p-4   border-2" >
                        <div class="text-red-9 text-h6 text-bold">
                            WARNING!
                        </div>
                        <div class="text-grey-9">
                            {{ x_message }}    
                        </div>
                        

                    </div>
        </div>
        
    </div> 
</template>

<script setup>
import { useForm,Head, usePage } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import { ref,computed } from 'vue';

const q = useQuasar()
const page = usePage()
const x_message = computed(() =>page.props.flash.message)

let form=useForm({
    
    grievance:'',
    reason:'',
})

const props=defineProps([
    'grievances',

])

const appealSubmitClick=()=>{

    form.post('/citizen/appeal',{
        onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{
            q.loading.hide()
        },
    })
}


</script>