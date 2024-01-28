<template>
    <div class="m-3">
        <Head title="Carousel" />
        <div class="q-pa-md">
            <q-table
            :rows="carousels"
            :columns="columns"
            row-key="name"
            flat bordered
             
            separator="cell"
            :pagination="{
                sortBy:'id',
                rowsPerPage:10,
            }"
            
            >

            <template v-slot:top>
                <span class="text-h4">Carousel List</span>
                
                <div class="text-h4">( {{ props.imageCount }} image visible. Maximum 10)</div> 
                <q-space/>
                    <q-btn v-model="xxx"  label="add" icon="add" color="primary" @click="carouselAddClick"> </q-btn>
            </template>
                 
            <template v-slot:body-cell-id="props">
                <q-td key="id" :props="props">
                    {{ props.rowIndex+1 }}
                </q-td>
            </template>
            <template v-slot:body-cell-visible="props">

                <q-td>
                    <div v-if="props.row.visible==0">
                        <q-chip color="red" text-color="white" label="No" />
                    </div>
                    <div v-else-if="props.row.visible==1">
                        <q-chip color="green" text-color="white" label="Yes" />
                    </div>
                </q-td>
                    
            
            </template>

            <template v-slot:body-cell-preview="props">
                <q-td :props="props">
                    <div @click="imageClick(props.row.image)">
                        <q-img
                        :src="'../../../../../../../../storage/carousel/'+props.row.image"
                        :ratio='16/9'
                        width="100px"
                        />
                    </div>
                    
                    
                </q-td>
            </template>
            
            <template v-slot:body-cell-actions="props">
                    <q-td 
                    key="action"
                    :props="props">
                        <q-btn
                            dense
                            round
                            flat
                            color="green"
                            @click="openEditModal(props.row)"
                            icon="edit"
                        ></q-btn>
                        <q-btn
                            dense
                            round
                            flat
                            color="red"
                            @click="confirmDeleteClick(props.row)"
                            icon="delete"
                        ></q-btn>
                    </q-td>
                </template>
            </q-table>
            <div>
               Note: Desire ratio for the carousel image is 19:6, with maximum 2MB

            </div>
           
        </div>
        
    </div>

     <!-- IMAGE PREVIEW -->
     <q-dialog v-model="imagePreviewModal">
        <q-card  style="width: 700px; max-width: 80vw;">
            <q-toolbar>
                <q-toolbar-title><span class="text-weight-bold">My Image</span></q-toolbar-title>
                <q-btn flat round dense icon="close" v-close-popup/>
            </q-toolbar>
            <q-card-section>
                <q-img
                    fit="contain"
                    :src="'../../../../../../../../storage/carousel/'+imageSource"

                >

                </q-img>
            </q-card-section>
        </q-card>


     </q-dialog>

    <!-- ADD MODALS -->
    <q-dialog v-model="modal" persistent>
        <q-card>
            <q-toolbar>
                <q-toolbar-title><span class="text-weight-bold">Add Carousel</span></q-toolbar-title>
                <q-btn flat round dense icon="close" v-close-popup/>
            </q-toolbar>

            <q-card-section>
                <form @submit.prevent="submit" method="post">
                    <div class="q-pa-md">
                        <div class="q-gutter-x-md column" style="width: 400px">
                                <div class="mb-3">
                                    <q-file
                                        style="max-width: 300px"
                                        v-model="form.image"
                                        filled
                                        label="Click to select image"
                                        accept=".jpg,.jpeg,.png"
                                        @rejected="onRejected"
                                    />
                                    <div v-if="props.errors.image" v-text="props.errors.image" class="text-red-500 text-xs mt-3"></div>
                                </div>

                            <div class="mb-3">
                                <q-select
                                    v-model="form.visible" 
                                    input-debounce="0"
                                    label="Visibility for carousel" 
                                    :options="visibility"
                                    style="width: 250px"
                                    
                                >
                                </q-select>
                        
                            </div>

                            <q-btn label="Submit" dense color="black" type="submit"
                                    :disable="form.processing"/>
                        </div>
                        
                    </div>
                </form>
            </q-card-section>
        </q-card>
    </q-dialog>

    <!-- EDIT MODALS -->
    <q-dialog v-model="editImageModal" persistent>
        <q-card>
            <q-toolbar>
                <q-toolbar-title><span class="text-weight-bold">Edit Carousel</span></q-toolbar-title>
                <q-btn flat round dense icon="close" v-close-popup/>
            </q-toolbar>

            <q-card-section>
                
                <form @submit.prevent="updateClick(form.id)" method="post">
                    <div class="q-pa-md">
                        <div class="q-gutter-x-md column" style="width: 400px">
                                <div class="mb-3">
                                    <q-file
                                        style="max-width: 300px"
                                        v-model="form.image"
                                        filled
                                        label="Click to update image"
                                        accept=".jpg, image/*"
                     
                                    />
                                    <div v-if="props.errors.image" v-text="props.errors.image" class="text-red-500 text-xs mt-3"></div>
                                </div>
                                <div>Current Image:
                                    <q-img
                                    :src="'../../../../../../../../storage/carousel/'+form.image"
                                    :ratio='16/9'
                                    width="80px"
                                    />
                                </div>

                            <div class="mb-3">
                                    <q-select
                                        v-model="form.visible" 
                                        input-debounce="0"
                                        label="Visibility for carousel" 
                                        :options="visibility"
                                        style="width: 250px"
                                    >
                                    </q-select>
                            </div>

                            <q-btn label="Update" dense color="black" type="submit"
                                    :disable="form.processing"/>
                        </div>
                    </div>
                </form>
            </q-card-section>
        </q-card>
    </q-dialog>
            
    <!-- DELETE CONFIRM  -->
    <q-dialog v-model="confirmDeleteModal">
            <q-card>
                <q-card-section class="row items-center">
                <q-avatar icon="done" color="primary" text-color="white" />
                <span class="q-ml-sm">Are you sure you want to Delete?</span>
                </q-card-section>
                
                <q-card-actions align="right">
                <q-btn flat label="Cancel" color="primary" v-close-popup />
                <q-btn flat label="Yes"  @click="deleteRow(form.id)" color="primary" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>

</template>

<script setup>
import { useForm,Head} from "@inertiajs/vue3"
import {ref} from 'vue'
import {useQuasar} from "quasar"
import {useRouter} from 'vue-router'
import { onUpdated } from "vue"
 
const visibility=[{label:'Yes',value:1},{label:'No',value:0}]

 const q = useQuasar();
 const props= defineProps({
    carousels:'',
    errors:Object,
    imageCount:'',
});

 const modal = ref(false)
 const imagePreviewModal = ref(false)
 const editImageModal = ref(false)
 const confirmDeleteModal=ref(false)

 const form = useForm({
    id:'', 
    visible:visibility[0],
    image:'',

}) 
 
onUpdated(() => {
    // if(props.imageFull==true){
    //     addButton.disable
    // }
     
  if(props.errors.maximum){
    modal.value=false
    editImageModal.value = false
    
    q.notify({
          message: props.errors.maximum,
          icon: 'warning',
          actions:[
          { icon: 'close', color: 'white', round: true, handler: () => { /* ... */ } }
          ]
        })
       
  }
})

const router = useRouter()
let imageSource= ''

const columns =  [
    {name:'id', align:'left', label:'ID', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Label', field:'name'},

    {name:'visible', align:'left', label:'Visible', field:'id'},

    {name:'preview', align:'left', label:'Preview', field:'id'},
    {name:'actions', align:'left', label:'Action', field:'id'},

]

const carouselAddClick=()=>{
    modal.value = true
}

const submit=e=>{
    form.post(route('admin.system.carousel.store'),{
        onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{
            q.loading.hide()
        },
        onSuccess:() => {
            modal.value= false
            q.notify({
                    message: 'Carousel Created',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                })
            q.loading.hide()
        }
    })
}
    

const openEditModal=(row)=> {
    editImageModal.value = true
    form.id = row.id
    form.image = row.image
    form.visible = row.visible==1?visibility[0]:visibility[1]

}

const deleteForm=useForm({})

const confirmDeleteClick=(row)=>{
    confirmDeleteModal.value=true
    form.id=row.id
}

const deleteRow=(id)=>{
    deleteForm.transform(data=>({
         
    })).delete(route('admin.system.carousel.delete',id),{
        onStart:()=>q.loading.show({message:'Deleting...'}),
        onFinish:()=>{
            q.loading.hide()
        },
        onSuccess:() => {
            q.notify({
                    message: 'Delete Successfully',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                })
            q.loading.hide()
        } 
    })

}
const updateClick=(id)=>{
     form.post(route('admin.system.carousel.update',id),{
        onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{
            q.loading.hide()
        },
        onSuccess:() => {
            modal.value= false
            editImageModal.value=false
            q.notify({
                    message: 'Carousel Updated',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                })
            q.loading.hide()
        }
    })
}

const imageClick=(image)=>{
    console.log(image)
     imagePreviewModal.value= true
     imageSource = image

}



</script>