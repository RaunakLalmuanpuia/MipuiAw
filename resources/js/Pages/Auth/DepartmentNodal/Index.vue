<template>
    <Head title="SubDepartment Nodal list"/>
    <div class="m-5">
        <h4>My Sub-Department User 👨‍💼👩‍💼</h4>
        <h4 class="mb-3">Dept Name: {{ departmentName }}</h4>
            
        <Link href="/admin/departmentnodal/create" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Sub-Department Officer</Link>

            <div class="q-pa-md">
                <q-table
                :rows="departmentUsers"
                :columns="columns"

                row-key="name"
                @request="tableData"
                flat bordered
                title="List"
                separator="cell"
                :pagination="{
                    sortBy:'name',
                    rowsPerPage:10,
                }"

                records-per-page-options="[1,5,10]"
                >

                
                <template v-slot:body-cell-id="props">
                    <q-td key="id" :props="props">
                        {{ props.rowIndex+1 }}
                    </q-td>
                </template>

                <template v-slot:body-cell-name="props">
                    <q-td key="id" :props="props">
                        <div :class="props.row.active?'':'bg-red'">{{ props.row.name }}</div>
                        
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
                                @click="$inertia.get('/admin/subnodal/'+props.row.id+'/edit')"
                                icon="edit"
                            ></q-btn>
                            <q-btn
                            dense
                            round
                            flat
                            color="red"
                            @click.stop="deleteRow(props.row.id)"
                            icon="delete"
                        ></q-btn>
                        </q-td>
                        
                    </template>
                </q-table> 
                

                <!-- MODALS -->
                <q-dialog v-model="modal">
                    <q-card>
                        <q-toolbar>
                            <q-toolbar-title><span class="text-weight-bold">Edit State Nodal Officer</span></q-toolbar-title>
                            <q-btn flat round dense icon="close" v-close-popup/>
                        </q-toolbar>

                        <q-card-section>
                            <form @submit.prevent="submit" method="post">
                                <div class="q-pa-md">
                                    <div class="q-gutter-x-md column" style="width: 400px">
                                        <q-input
                                            name="name"
                                            standout
                                            v-model="form.name"
                                            :error="!form.errors.name===false"
                                            :error-message="form.errors.name"
                                            :dense="dense"
                                            placeholder="Department Name">
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

        </div>  
        
        
<q-dialog v-model="confirm_delete">
    <q-card>
        <q-card-section class="row items-center">
            <q-avatar icon="delete" color="red" text-color="white" />
            <span class="q-ml-sm">Type the below text to delete?</span>
        </q-card-section>
        <q-card-section>
            <div>
                Type: <b>{{ matchingText }}</b>
            </div>
            <div>
                <q-input v-model="deleteConfirm.text" dense/>
            </div>
        </q-card-section>

        <q-card-actions align="right">
            <q-btn flat label="Cancel" color="primary" v-close-popup />
            <q-btn v-show="deleteConfirm.text===matchingText" flat label="Delete" @click="submitFormDelete" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>
</template>
<script setup>
 import {onMounted, ref} from 'vue'
 import {useForm,Head,router} from "@inertiajs/vue3";
 import {useQuasar} from "quasar";
 
const modal = ref(false)

const q=useQuasar()


const props =defineProps({
    departmentUsers:Object,
    departmentName:'',
 
})


const matchingText='Delete'+ Math.floor(Math.random() * (111 - 999 + 1)) + 111
const confirm=ref(false)
const confirm_delete=ref(false)
let deleteConfirm = useForm({
    text:'',
})
const delete_id = ref('')

 
const openEditModal=e=>{
    // modal.value=true;
    // form.name=e.name;
    this.$inertia.visit('login');
}

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Department Nodal Officer', field:'name'},
    {name:'mobile', align:'left', label:'Phone', field:'mobile'},
    {name:'email', align:'left', label:'Email', field:'email'},

    {name:'roles', align:'left', label:'Role', field:'role',format:val=>val.name},
    {name:'subDepartment', align:'left', label:'Office', field:'sub_department',format:val=>val.organization_name},
 
    {name:'actions', align:'left', label:'Action', field:'id'},
]

const deleteRow=id=>{
    confirm_delete.value=true
    delete_id.value=id

}

const submitFormDelete=()=>{

router.delete(route('nodal.destroy', delete_id.value), {
    onStart:()=>q.loading.show({message:'Deleting....'}),
    onSuccess:()=>{
        q.notify({
            message:'User deleted',
            closeBtn:true,
        })
        q.loading.hide();
    },
    onFinish:()=>q.loading.hide(),
    preserveState: false,
})
}


// const deleteRow2=id=>{
//     q.dialog({
//         title: 'Confirm Delete',
//         message: 'Are you sure?',
//         ok: 'Yes',
//         cancel: 'No'
//     }).onOk(() => {
//         router.delete(route('nodal.destroy', id), {

//             onStart:()=>q.loading.show({message:'Deleting....'}),
//             onSuccess:()=>{
//                 q.notify({
//                     message:'User deleted',
//                     closeBtn:true,
//                 })
//                 q.loading.hide();
//             },
//             onFinish:()=>q.loading.hide(),
//             preserveState: false,
//         })
//     }).onCancel(() => {
        
//     })
// }
 

const submit=e=>{
    console.log("Im the only one: "+e)
    // form.put(route('department.update',1),{
    //     onSuccess:() => {
    //         modal.value= false
    //     }
    // })

}
</script>
<!--  @click="moreClick(props.row.id)" -->