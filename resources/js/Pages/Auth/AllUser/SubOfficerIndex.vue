<template>
    <Head title="State Nodal List" />
    <div class="container">
        <h4 class="mt-5 mb-5 ml-5">Sub Department Nodal Officer</h4>
        
         
    <!-- <Link href="/admin/nodal/create" class="p-2 m-5 border">New Department Nodal</Link> -->
        <div class="q-pa-md">
            <q-table
            :rows="subNodalOfficers"
            :columns="columns"

            row-key="name"
            @request="tableData"
            :filter="filter"
            flat bordered
            separator="cell"
            :pagination="{
                sortBy:'name',
                rowsPerPage:10,
            }"
            records-per-page-options="[1,5,10]"
            >

            <template v-slot:top>
                <span class="text-2xl">List</span>
                <q-space/>
                <q-input dense debounce="300" color="primary" v-model="filter" placeholder="Search">
                    <template v-slot:append>
                        <q-icon name="search"/>
                    </template>
                </q-input>
            </template>

            <template v-slot:body-cell-id="props">
                <q-td key="id" :props="props">
                    {{ props.rowIndex+1 }}
                </q-td>
            </template>

            <template v-slot:body-cell-name="props">
                 <q-td :props="props" :class="(props.row.active==1)?'':'text-red'">
                      {{ props.row.name }}
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
                            @click.stop="$inertia.get('/admin/nodal/'+props.row.id+'/edit')"
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
import {Head,useForm, router} from "@inertiajs/vue3";
import {date, useQuasar} from "quasar";
 
//  import {useRouter} from 'vue-router'

const q=useQuasar()
const filter = ref('')
const modal = ref(false)
const form = useForm({
    name:'',
})

const props = defineProps({
    subNodalOfficers:Object,
    role:'',
})

const openEditModal=e=>{
    this.$inertia.visit('login');
}

const matchingText='Delete'+ Math.floor(Math.random() * (111 - 999 + 1)) + 111
const confirm=ref(false)
const confirm_delete=ref(false)
let deleteConfirm = useForm({
    text:'',
})
const delete_id = ref('')

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'department', align:'left', label:'Department Nodal Officer', 
    field:row=>row.department?row.name+'\n'+row.department.organization_name:row.name, 
    style:row=>row.active==1?'white-space:pre-line;':'color:red; white-space:pre-line;'

    },
    {name:'contact_details', align:'left', label:'Contact Details', 
        field:row=>'Email: '+row.email +'\n'+ 'Ph: '+ row.mobile,
        style:row=>row.active==1?'white-space:pre-line;':'color:red; white-space:pre-line;'
    },
    {name:'active', align:'left', label:'Active', 
        field:row=>row.active==1?'Active':'Inactive',
        style:row=>row.active==1?'white-space:pre-line;color:green;':'color:red; white-space:pre-line;'
    },
    {name:'last_active', align:'left', label:'Last Active', field:'last_login',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')??'-'},
 
    {name:'actions', align:'left', label:'Action', field:'id'},
]

 const moreClick =(row)=>{
    router.get('nodalindex/sibling/'+row.department_id);
 }

const submit=e=>{
    console.log("Im the only one: "+e)
}

const deleteRow=id=>{
    confirm_delete.value=true
    delete_id.value=id
}

const submitFormDelete=()=>{
    
    router.delete(route('nodal.destroy', delete_id.value), {
        onStart:()=>q.loading.show({message:'Deleting...'}),
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

</script>
