<template>
    <Head title="All Department List"/>
    <div class="container m-10">
        <h4 class="mb-5 ml-5">Department List</h4>
         
         <Link href="/department/create" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Department</Link>
        
             <div class="q-pa-md">
                 <q-table
                  class="shadow-1"
                 :rows="departments"
                 :columns="columns"
                 :props="props"
                 :filter="filter"
                 row-key="name"
                 
                 flat bordered
                 
                 separator="cell"
                 :pagination="{
                      
                     rowsPerPage:10,
                 }"
                 records-per-page-options="[1,5,10]"
                 >


                 <template v-slot:top>
                    <span class="text-2xl">Department List</span>
                    <q-space/>
                    <q-input dense debounce="300" color="primary" v-model="filter" placeholder="Search">
                        <template v-slot:append>
                            <q-icon name="search"/>
                        </template>
                    </q-input>
                 </template>

                 <template v-slot:body-cell-more="props">
                    <q-td 
                    key="more"
                    :props="props">
                
                        <q-btn
                            dense
                            round
                            flat
                            color="blue"
                            @click="moreClick(props.row.id)"
                            icon="more"
                        ></q-btn>
                    </q-td>
                </template>

                  <template v-slot:body-cell-id="props">
                        <q-td key="id" :props="props">
                            {{ props.rowIndex+1 }}
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
                                 @click.stop="openEditModal(props.row)"
                                 icon="edit"
                             ></q-btn>
                             <!-- <q-btn
                                 dense
                                 round
                                 flat
                                 color="red"
                                 @click="deleteRow(props.row.id)"
                                 icon="delete"
                             ></q-btn> -->
                         </q-td>
                     </template>
                 </q-table>
     
                 <!-- MODALS -->
                 <q-dialog v-model="modal">
                     <q-card>
                         <q-toolbar>
                             <q-toolbar-title><span class="text-weight-bold">Edit Department</span></q-toolbar-title>
                             <q-btn flat round dense icon="close" v-close-popup/>
                         </q-toolbar>
     
                         <q-card-section>
                             <form @submit.prevent="submit" method="post">
                                 <div class="q-pa-md">
                                     <div class="q-gutter-x-md column" style="width: 400px">
                                         <q-input
                                             name="organization_name"
                                             
                                             v-model="form.organization_name"
                                             :error="!form.errors.organization_name===false"
                                             :error-message="form.errors.organization_name"
                                             label="Department Name"

                                             placeholder="Department Name">
                                         </q-input>
                                         <q-input
                                             name="organization_code"
                                             
                                             v-model="form.organization_code"
                                             :error="!form.errors.organization_code===false"
                                             :error-message="form.errors.organization_code"
                                             label="Department Code"

                                             placeholder="Department Code">
                                         </q-input>
                                         <q-input
                                             name="organization_type"
                                             
                                             v-model="form.organization_type"
                                             :error="!form.errors.organization_type===false"
                                             :error-message="form.errors.organization_type"
                                             label="Department Type"

                                             placeholder="Department Type">
                                         </q-input>
                                         <q-input
                                             name="organization_address"
                                             
                                             v-model="form.organization_address"
                                             :error="!form.errors.organization_address===false"
                                             :error-message="form.errors.organization_address"
                                             label="Department Address"

                                             placeholder="Department Address">
                                         </q-input>
                                         <q-input
                                             name="pincode"
                                             
                                             v-model="form.pincode"
                                             :error="!form.errors.pincode===false"
                                             :error-message="form.errors.pincode"
                                             label="Pincode"
                                             placeholder="Pincode">
                                         </q-input>
                                         <q-btn label="Update" dense color="black" type="submit"
                                                 :disable="form.processing"/>
                                     </div>
                                 </div>
                             </form>
                         </q-card-section>
                     </q-card>
                 </q-dialog>
     
             </div>
     
                <!-- <Pagination :links="departments.links" /> -->
    </div>
    
</template>
<script setup>
 import {onMounted, ref} from 'vue'
 import {useForm,router,Head} from "@inertiajs/vue3";
 import {date, useQuasar} from "quasar";

 const q = useQuasar()
 const modal = ref(false)
 const filter = ref('')

 const form = useForm({
    id:'',
    organization_name:'',
    organization_address:'',
    organization_code:'',
    organization_type:'',
    pincode:'',

 })

 const props = defineProps(['departments'])


 const openEditModal=e=>{
    modal.value=true;
    form.organization_name=e.organization_name;
    form.organization_address=e.organization_address;
    form.organization_code=e.organization_code;
    form.organization_type=e.organization_type;
    form.pincode=e.pincode;

    form.id=e.id;

}

const moreClick=(parentId)=>{
    router.get('/department/sibling/'+parentId);
 }

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:'bold'},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Department Name', field:'organization_name'},
    {name:'created_at', align:'left', label:'Created_at', field:'created_at',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
    {name:'more', align:'left', label:'Sub Department', field:'id'},

    {name:'actions', align:'left', label:'Action', field:'id'},

]

 const rowClicker =(row,evn)=>{
    console.log(row)
    router.push({ name: 'index.sibling', params: { parentId: '1' } })

 }



const submit=e=>{
    console.log("Im the only one: "+form.id)

    form.put(route('department.update',form.id),{

        onStart:()=>{
            q.loading.show()
        },
        onSuccess:() => {
            q.loading.hide()

            q.notify({
                    message: 'Department Updated',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                });
            modal.value= false

        },
        onFinish:() => {
            q.loading.hide()
        }
    })
}

const deleteRow=id=>{
    q.dialog({
        title: 'Confirm Delete',
        message: 'Are you sure?',
        ok: 'Yes',
        cancel: 'No'
    }).onOk(() => {

        
        router.delete(route('department.destory',id), {
            onStart:()=>q.loading.show({message:'Deleteing...'}),
            onSuccess:()=>{
                q.notify({
                    message:'Student deleted',
                    closeBtn:true,
                })
                q.loading.hide();
            },
            onFinish:()=>q.loading.hide()
        })
    })
}

</script>
