<template>
    <Head title="Departmental Appellate Authority" />
    <div class="container">
        <h4 class="mt-5 mb-5 ml-5">State Departmental Appellate Authority</h4>
        <h3>{{ departmentName }}</h3>
         
    <Link :href="route('appellate.create')" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Appellate Authority</Link>
        <div class="q-pa-md">
            <q-table
            :rows="appellateAuthority"
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
            
            <template v-slot:body-cell-roles="props">
                <q-td :props="props" >
                    <div >
                        {{ departmentalAppellateAuthority.name }}
                    </div>
                </q-td>
            </template>
            <template v-slot:body-cell-contact_details="props">
                <q-td key="id" :props="props">
                    <div>Email:{{ props.row.email }}</div>
                    <div>Ph:{{ props.row.mobile }}</div>

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
                            @click.stop="deleteRow(props.row.id)"
                            icon="delete"
                        ></q-btn>
                    </q-td>
                </template>
            </q-table>
        </div>
    </div>

<!-- MODALS -->
<q-dialog v-model="modal" persistent>
    <q-card>
        <q-toolbar>
            <q-toolbar-title><span class="text-weight-bold">Edit Details</span></q-toolbar-title>
            <q-btn flat round dense icon="close" v-close-popup/>
        </q-toolbar>

        <q-card-section>
            <form @submit.prevent="submit" method="post">
                <div class="q-pa-md">
                    <div class="q-gutter-x-md column" style="width: 400px">
                        <q-input
                            name="name"
                             
                            v-model="form.name"
                            :error="!form.errors.name===false"
                            :error-message="form.errors.name"
                            label="Full Name">
                        </q-input>
                        <q-input
                            name="designation"
                             
                            v-model="form.designation"
                            :error="!form.errors.designation===false"
                            :error-message="form.errors.designation"
                            label="Designation">
                        </q-input>
                        <q-input
                            name="mobile"
                            mask="##########"
                            :rules="[val => val.length ==10 || 'Must be 10 digits']"
                            maxlength="10"
                            v-model="form.mobile"
                            :error="!form.errors.mobile===false"
                            :error-message="form.errors.mobile"
                            label="Mobile">
                        </q-input>

                        <q-input
                            name="email"
                            v-model="form.email"
                            :error="!form.errors.email===false"
                            :error-message="form.errors.email"
                            label="Email">
                        </q-input>

                        <q-select
                            v-model="form.gender"  
                            input-debounce="0"
                            label="Gender"
                            :options="gender"
                            :error="!form.errors.gender===false"
                            :error-message="form.errors.gender"
                            style="width: 250px">
                        </q-select>

                        <q-input
                            name="address"
                            v-model="form.address"
                            :error="!form.errors.address===false"
                            :error-message="form.errors.address"
                            label="Office Address">
                        </q-input>

                        <q-input
                            name="pincode"
                            v-model="form.pincode"
                            :error="!form.errors.pincode===false"
                            :error-message="form.errors.pincode"
                            label="Pincode">
                        </q-input>

                        <q-input
                            name="alternate_mobile"
                             
                            v-model="form.alternate_mobile"
                            :error="!form.errors.name===false"
                            :error-message="form.errors.alternate_mobile"
                            label="Alternate Mobile  (Optional)">
                        </q-input>

                        <q-select
                            v-model="form.district"  
                            input-debounce="0"
                            label="District"
                            :options="districts"
                            :error="!form.errors.district===false"
                            :error-message="form.errors.district"
                            style="width: 250px"
                        >
                        </q-select>

                        <q-select
                            v-model="form.active"  
                            input-debounce="0"
                            label="Active"
                            :options="active"
                            :error="!form.errors.active===false"
                            :error-message="form.errors.active"
                            style="width: 250px"
                        >
                        </q-select>
                      
                        <div v-show="isSuperAdmin" class="mb-3">
                            <q-select
                                v-model="form.department.id"
                                use-input
                                input-debounce="0"
                                label="Department"
                                :options="options"
                                @filter="filterFn"
                                style="width: 250px"
                                behavior="menu"
                                map-options
                            />
                            <div v-if="form.errors.department" v-text="form.errors.department" class="text-red-500 text-xs mt-3"></div>
                        </div>
                        <q-card-actions align="right">
                            <q-btn flat label="Cancel" color="primary" v-close-popup />
                            <q-btn label="Update" dense color="black" type="submit"
                                :disable="form.processing"/>
                        </q-card-actions>
                        
                    </div>
                </div>
            </form>
        </q-card-section>
    </q-card>
</q-dialog>
<!-- END Modal -->

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
 import {useQuasar} from "quasar";
//  import {useRouter} from 'vue-router'

const q=useQuasar()

const modal = ref(false)

const gender =['Female','Male']
const districts=['Aizawl','Lunglei','Champhai','Kolasib','Serchhip','Mamit','Siaha','Lawngtlai','Khawzawl','Saitual','Hnahthial',]
const active=[{label:'Yes',value:1},{label:'No',value:0}]
const options=ref(props.departments)


const matchingText='Delete'+ Math.floor(Math.random() * (111 - 999 + 1)) + 111
const confirm=ref(false)
const confirm_delete=ref(false)
let deleteConfirm = useForm({
    text:'',
})
const delete_id = ref('')

const form = useForm({
    id:'',
    email:'',
    name:'',
    designation:'',
    mobile:'',
    gender:'',
    address:'',
    pincode:'',
    alternate_mobile:'',
    district:'',
    active:'',
    department:'',
})

const props = defineProps({
    appellateAuthority:Object,
    role:'',
    isSuperAdmin:'',
    departments:'',
})

const openEditModal=e=>{
    modal.value=true
    form.id = e.id
    form.name = e.name
    form.designation = e.designation
    form.mobile = e.mobile
    form.email = e.email
    form.gender = e.gender
    form.address = e.address
    form.pincode = e.pincode
    form.alternate_mobile = e.alternate_mobile
    form.district = e.district
    form.active = e.active
    form.department = e.department

    if(e.active==1){
        form.active = active[1]
    }else form.active = active[0]
    
     
}

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Department Nodal Officer', field:'name'},
    {name:'department', align:'left', label:'Department', field:'department',format:val=>val.organization_name},
    {name:'contact_details', align:'left', label:'Contact', field:'id'},
 

     {name:'actions', align:'left', label:'Action', field:'id'},
]

const submit=e=>{
    console.log("Im the only one: "+e)
    form.put(route('appellate.update',form.id),{
        onSuccess:() => {
            modal.value= false
            q.notify({
                    message: 'User Updated',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                });
        }
    })
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
