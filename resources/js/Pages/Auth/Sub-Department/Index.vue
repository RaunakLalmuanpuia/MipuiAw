<template>
<Head  title="Sub Department Index"></Head>
 
   <h4>Sub Organization List</h4>

    <Link href="/department/create" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Sub Department</Link>
        <div class="q-pa-md">
            <q-table
            :rows="subDepartment"
            :columns="columns"
            
            row-key="name"
            @request="tableData"
            @row-click="rowClicker"
            flat bordered
            title="Sub-Organization List"
            separator="cell"
            :pagination="{
                sortBy:'id',
                rowsPerPage:10,

            }"
            records-per-page-options="[1,5,10]"
            >
            <template v-slot:body-cell-id="props">
                <q-td key="id" :props="props">
                    {{ props.rowIndex+1 }}
                </q-td>
            </template>
            
            <template v-slot:body-cell-subname="props">
                    <q-td :props="props">
                        {{ props.row.department.organization_name }}
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
                            @click="deleteRow(props.row.id)"
                            icon="delete"
                        ></q-btn>
                    </q-td>
                </template>
            </q-table>

            <!-- MODALS -->
            <q-dialog v-model="modal">
                <q-card>
                    <q-toolbar>
                        <q-toolbar-title><span class="text-weight-bold">Edit Sub Department</span></q-toolbar-title>
                        <q-btn flat round dense icon="close" v-close-popup/>
                    </q-toolbar>

                    <q-card-section>
                        <form @submit.prevent="submit" method="post">
                            <div class="q-pa-md">
                                <div class="q-gutter-x-md column" style="width: 400px">
                                    <q-input
                                        name="organization_name"
                                        standout
                                        v-model="form.organization_name"
                                        :error="!form.errors.organization_name===false"
                                        :error-message="form.errors.organization_name"
                                        :dense="dense"
                                        placeholder="Sub Department Name">
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
</template>

<script setup>
 import {onMounted, ref} from 'vue'
 import {useForm,router,Head} from "@inertiajs/vue3";
 import {date,useQuasar} from "quasar";
 import { Inertia } from "@inertiajs/inertia";

 const q = useQuasar()
 const modal = ref(false)
 
 const form = useForm({
    sssubDepartment:'',
 })

 const props = defineProps({
    departments:[],
    subDepartment:'',
     
 })


 const openEditModal=e=>{
    modal.value=true;
    form.organization_name=e.organization_name;
    form.id=e.id;

}


const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Sub Department Name', field:'organization_name'},
    {name:'subname', align:'left', label:'Parent Department', field:'department_id'},

    {name:'created_at', align:'left', label:'Created_at', field:'created_at',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
    {name:'actions', align:'left', label:'Action', field:'id'},

]

 const rowClicker =(row,evn)=>{
    console.log(router)

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
