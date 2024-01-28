<template>
        <Head title="Sub Organization" />

    <div class="p-5"   >

    <h4>Sub Organization of <b>{{ departmentName }} 🏢</b></h4>
    <div>
        <q-btn class="m-4" href="#" onclick="history.back();return false;" color="primary" label="Back" />
    </div>
    <Link :href="'/sibling/create/'+departmentId" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Sub Org</Link>
    
    <div v-if="x_message" class="bg-red-2 border-red-9 mt-5 p-4   border-2" >
        <div class="text-red-9 text-h6 text-bold">
            WARNING!
        </div>
        <div class="text-grey-9">     {{ x_message }}     </div>
        

    </div>
    <div v-if="x_message_success" class="bg-green-2 border-green-9 mt-5 p-4 border-2" >
        <div class="text-green-9 text-h6 text-bold">
            SUCCESS!
        </div>
        <div class="text-grey-9"> {{ x_message_success }}     </div>
    </div>
    
        <div class="q-pa-md">
            <q-table
            :rows="sibling"
            :columns="columns"
            row-key="name"
            @row-click="rowClicker"
            flat bordered
            title="Department List"
            separator="cell"
            >
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
</div>

           <!-- <Pagination :links="departments.links" /> -->
</template>
<script setup>
 import {computed, ref} from 'vue'
 import {useForm,router,Head,usePage} from "@inertiajs/vue3";
 import {date, useQuasar} from "quasar";
 import { Inertia } from "@inertiajs/inertia";

 const q = useQuasar()
 const modal = ref(false)
 const page = usePage()

 const x_message = computed(() =>page.props.flash.message)
 const x_message_success = computed(() =>page.props.flash.message_success)

 const form = useForm({
    id:'',
    sibling:'',
    organization_name:'',
    organization_address:'',
    organization_code:'',
    organization_type:'',
    pincode:'',
 })

 const props = defineProps({
    sibling:[],
    departmentName:'',
    departmentId:'',
 })

 const openEditModal=e=>{
    modal.value=true;
    form.organization_name=e.organization_name;
    form.organization_address=e.organization_address;
    form.organization_code=e.organization_code;
    form.organization_type=e.organization_type;
    form.pincode=e.pincode;
    form.id=e.id;
}

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Department Name', field:'organization_name'},
    {name:'created_at', align:'left', label:'Created_at', field:'created_at',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
    {name:'actions', align:'left', label:'Action', field:'id'},
]

 const rowClicker =(row,evn)=>{
    console.log(row)
 }

const submit=e=>{
    console.log("Im the only one: "+form.id)
    form.put(route('subdepartment.update',form.id),{

        onStart:()=>{
            q.loading.show()
        },
        onSuccess:() => {
            q.loading.hide()
            q.notify({
                    message: 'Sub-Department Updated',
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
        router.delete(route('subdepartment.destroy',id), {
            onStart:()=>q.loading.show({ }),
            onSuccess:()=>{
               
                q.loading.hide();
            },
            onFinish:()=>q.loading.hide()
        })
    })
}

</script>
