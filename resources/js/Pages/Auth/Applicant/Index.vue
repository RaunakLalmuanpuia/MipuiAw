<template>
    <Head title="Applicant List" />
    <h4 class="mb-3">Applicant</h4>

    <Link :href="route('applicant.create')" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Applicant</Link>

        <div class="q-pa-md">
            <q-table
                v-model:pagination="pagination"
                :rows="applicantUsers.data"
                :columns="columns"
                :props="props"
                :filter="filter"
                row-key="name"
                flat bordered
                separator="cell"
                wrap-cells
                @request="tableData"
            >

            <template v-slot:top>
                <span class="text-2xl">Applicant List</span>
                <q-space/>
                <q-input autofocus dense debounce="800" @update:model-value="handleSearch" color="primary" v-model="search" placeholder="Search">
                    <template v-slot:append>
                        <q-icon name="search"/>
                    </template>
                    <q-tooltip>
                        Search using Name and Phone number.
                    </q-tooltip>
                </q-input>
            </template>

            <template v-slot:body-cell-id="props">
                <q-td key="id" :props="props">
                    {{ props.rowIndex+1 }}
                </q-td>
            </template>
            
            <template v-slot:body-cell-contact_details="props">
                <q-td key="id" :props="props">
                    <div>Email: {{ props.row.email }}</div>
                    <div>Ph: {{ props.row.mobile }}</div>
                </q-td>
            </template>

            <template v-slot:body-cell-more="props">
                <q-td key="more" :props="props">
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

            <template v-slot:body-cell-actions="props">
                <q-td 
                key="action"
                :props="props">
                    
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
 import {date } from 'quasar'

 const q = useQuasar();

const modal = ref(false)
const form = useForm({
    id:'',
    name:'',
})

const props = defineProps(['applicantUsers','search'])
const search = ref(props.search)

const matchingText='Delete'+ Math.floor(Math.random() * (111 - 999 + 1)) + 111
const confirm=ref(false)
const confirm_delete=ref(false)
let deleteConfirm = useForm({
    text:'',
})
const delete_id = ref('')

const openEditModal=e=>{
    modal.value=true
    form.id = e.id
    form.name=e.name
}

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Name', field:'name',
        style:row=>row.active==1?'white-space:pre-line;':'color:red; white-space:pre-line;'

    },
    {name:'contact_details', align:'left', label:'Contact', field:'id'},
    
    {name:'active', align:'left', label:'Active', 
        field:row=>row.active==1?'Active':'Inactive',
        style:row=>row.active==1?'white-space:pre-line;color:green;':'color:red; white-space:pre-line;'
    },
    {name:'last_active', align:'left', label:'Last Active', field:'last_login',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')??'-'},

    {name:'created_at', align:'left', label:'Created_at', field:'created_at',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
    {name:'more', align:'left', label:'Details', field:'id'},
    {name:'actions', align:'left', label:'Action', field:'id'},
]

const moreClick=(id)=>{
    router.get('/applicant/'+id);
}

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

const pagination = ref({
    page: props.applicantUsers?.current_page || 0,
    rowsPerPage: props.applicantUsers.per_page,
    rowsNumber: props.applicantUsers.total,
})
function handleSearch(val){
    search.value = val;
    tableData({pagination})
}
function tableData(props){
    const {page, rowsPerPage, } = props.pagination;
    router.get(route('applicant.index'),{
        per_page: rowsPerPage,
        page: page,
        search:search.value
    },{})
}

const deleteRow=id=>{
    confirm_delete.value=true
    delete_id.value=id
}

const submitFormDelete=()=>{

    router.delete(route('applicant.destroy', delete_id.value), {

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

</script>
