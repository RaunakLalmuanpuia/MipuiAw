<template>
    <div>
        <q-card>
        <q-card-section class="bg-light-green text-white mb-3">
             EDIT ANSWER
        </q-card-section>
                
        <q-card-section class="q-pt-none">
            <q-input
                    v-model="myText"
                    type="textarea"                
                />

        </q-card-section>
        <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn flat label="OK" v-close-popup />
                    <q-btn flat label="Cancel" @click="props.showDialogEditAnswer.value=false" v-close-popup />
                </q-card-actions>
        </q-card>
    </div>
</template>

<script setup>
import {ref,onMounted,computed} from 'vue';
   
    const props = defineProps([
        'showDialogEditAnswer',
        'sdf',
    ])
   
    
   
</script>