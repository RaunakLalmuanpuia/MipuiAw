<template>
    <div class="m-3">
        <Head title="Home Text" />
        <div class="q-pa-md">
            <h3>About MIPUI-AW</h3>
            <div class="m-3 bg-grey-2 p-3" >
                <span v-html="homeText.body1" ></span> 
                
                <q-btn 
                class="mt-3" 
                color="primary" 
                v-on:click="editClick()"
                label="Edit" 
                size="sm"
                />

            </div>
        </div>

        <div class="m-3" v-show="textEditShow">

        <q-editor 
        v-model="text" 
        min-height="5rem" 
         
        />
        
        <q-btn class="mt-3" color="primary" v-on:click="confirmDeleteModal=true" label="Submit" />

        </div>
    </div>

    
        
            
    <!-- DELETE CONFIRM  -->
    <q-dialog v-model="confirmDeleteModal">
        <q-card>
            <q-card-section class="row items-center">
            <q-avatar icon="done" color="primary" text-color="white" />
            <span class="q-ml-sm">Are you sure you want to Update?</span>
            </q-card-section>
            <q-card-actions align="right">
            <q-btn flat label="Cancel" color="primary" v-close-popup />
            <q-btn flat label="Yes"  @click="updateClick(1)" color="primary" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

</template>

<script setup>
import { useForm,Head} from "@inertiajs/vue3"
import {ref} from 'vue'
import {useQuasar} from "quasar" 
 
 const q = useQuasar();
 const props= defineProps(['homeText',]);

 const textEditShow = ref(false)
 const confirmDeleteModal=ref(false)
 const text= ref('')

 const editClick=()=>{
    textEditShow.value=true
    text.value=props.homeText.body1
 }

 const form = useForm({
    body1:text,
}) 
 
const updateClick=(id)=>{
     textEditShow.value = false
     form.body1 = text
     form.post(route('admin.system.hometext.update',id),{
        onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{
            q.loading.hide()
        },
        onSuccess:() => {
            
            q.notify({
                    message: 'Home Text Updated',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                })
            q.loading.hide()
        }
    })
}
 


</script>