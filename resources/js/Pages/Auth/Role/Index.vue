<template>
    <Head title="Role List" />
    <div class="m-5">
    <h4 class="mb-2">Role</h4>
    
     
        <!-- <Link :href="route('role.create')" class="p-2 m-5 border">New Role</Link> -->

            <div class="q-pa-md">
                <q-table
                :rows="roles"
                :columns="columns"
                row-key="name"
                @request="tableData"
                @row-click="rowClicker"
                flat bordered
                title="Roles List"
                separator="cell"
                :pagination="{
                    sortBy:'id',
                    rowsPerPage:10,
                }"
                records-per-page-options="[1,5,10]"
                >

                <template v-slot:top>
                    <span class="text-2xl">Roles List</span>
                    <q-space/>
                   <div>
                    <q-btn
                        flat
                        label="Click here 8 times to enable edit button"
                        @click="myBtnClick()"
                    />
                   </div>
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
                            
                            <q-btn v-show="showEditButton"
                                dense
                                round
                                flat
                                color="green"
                                @click="openEditModal(props.row)"
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
                            <q-toolbar-title><span class="text-weight-bold">Edit Role</span></q-toolbar-title>
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
                                            placeholder="Role Name">
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
           <!-- <Pagination :links="departments.links" /> -->
</template>
<script setup>
 import {onMounted, ref} from 'vue'
 import {useForm,Head} from "@inertiajs/vue3";
 import {date, useQuasar} from "quasar";
 const q = useQuasar();

const modal = ref(false)
const form = useForm({
    id:'',
    name:'',
})

defineProps({
    roles:Object
})

const consecutiveClicks = ref(0)
const showEditButton = ref(false)

const currentNotification = ref(null)

const openEditModal=e=>{
    modal.value=true
    form.id = e.id
    form.name=e.name
}

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Role Name', field:'name'},
    {name:'created_at', align:'left', label:'Created_at', field:'created_at',format:val => date.formatDate(val,'DD MMM YYYY')},
    {name:'actions', align:'left', label:'Action', field:'id'},
]

const submit=e=>{
    console.log("Im the only one: "+e)
    form.put(route('role.update',form.id),{
        onSuccess:() => {
            modal.value= false
            q.notify({
                    message: 'Role Updated',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                });
        }
    })
}

const myBtnClick=()=> {



    consecutiveClicks.value++
    console.log(consecutiveClicks.value)
    if(consecutiveClicks.value=== 8){
        showEditButton.value = true
    }else if(consecutiveClicks.value > 8){
        consecutiveClicks.value=1
        showEditButton.value=false
    }

    currentNotification.value=q.notify({
        message:' You have clicked '+ consecutiveClicks.value + ' times!',
        timeout:200
        
    })
     
     
}
</script>
