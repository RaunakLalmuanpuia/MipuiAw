<template>

    <Head title="Category List" />
    <div class="m-5">
        <h4 class="mb-3">Category</h4>
        <Link :href="route('category.create')" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Category</Link>

        <div class="q-pa-md">
            <q-table
            :rows="categories"
            :columns="columns"
            row-key="name"
            @row-click="rowClicker"
            flat bordered
            title="Action List"
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
                        @click="deleteRow(props.row)"
                        icon="delete"
                    ></q-btn>
                    </q-td>
                </template>
            </q-table>

            <!-- MODALS -->
            <q-dialog v-model="modal">
                <q-card>
                    <q-toolbar>
                        <q-toolbar-title><span class="text-weight-bold">Edit Action</span></q-toolbar-title>
                        <q-btn flat round dense icon="close" v-close-popup/>
                    </q-toolbar>

                    <q-card-section>
                        <form @submit.prevent="submit" method="put">
                            <div class="q-pa-md">
                                <div class="q-gutter-x-md column" style="width: 400px">
                                    <q-input
                                        name="Name"
                                        standout
                                        v-model="form.name"
                                        :error="!form.errors.name===false"
                                        :error-message="form.errors.name"
                                        :dense="dense"
                                        placeholder="Category Name">
                                    </q-input>

                                    <div class="mb-3" v-show="isDepartmentOfficer">
                                         
                                        <q-select 
                                            v-model="form.department" 
                                            :options="departments" 
                                            label="-- Select department --"
                                                />                 
                                    
                                    </div>
                                    <div>
                                        <q-btn label="Update" dense color="black" type="submit"
                                            :disable="form.processing"/>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </form>
                    </q-card-section>
                </q-card>
            </q-dialog>
        </div>
    </div>

    <!-- DELETE CONFIRM -->
    <q-dialog v-model="deleteConfirm" persistent>
      <q-card>
        <q-card-section class="row items-center">
           <span class="q-ml-sm">Are you sure you want to delete? </span>
          <span class="text-red text-lg" v-if="categoryMessage"> {{ categoryMessage }}</span>
        </q-card-section>


        <q-card-actions align="right">
          <q-btn flat label="Cancel" @click="deleteRowCancel()" color="primary" v-close-popup />
          <q-btn flat label="Delete Anyway" @click="deleteCategoryClick()" color="primary" v-close-popup />
        </q-card-actions>
      
      </q-card>
    </q-dialog>


</template>
<script setup>
 import {ref} from 'vue'
 import {useForm,Head} from "@inertiajs/vue3";
 import {date, useQuasar} from "quasar";
 import {useRouter} from 'vue-router'

 const q = useQuasar();
 let isDepartmentOfficer=ref(true)

 const deleteConfirm = ref(false)
 const categoryMessage = ref('')
 const deleteConfirmId = ref('')

const modal = ref(false)

let form = useForm({
    id:'',
    name:'',
    department:'',
    
})
 
const props = defineProps([
    'categories','departments','errors','CURRENT_USER'
])

const router = useRouter();

var mCurrentDepartmentID='';

const openEditModal=e=>{
    console.log(e.visible)
    console.log("oasis")
    let selected = props.departments.find(item=>item.value===e.department.id)

    modal.value=true
    form.id = e.id
    form.name=e.name
    form.department=selected

    mCurrentDepartmentID=e.department_id

}

const deleteRow=category=>{
     
    if(category.isUsed){
        categoryMessage.value="This category is already used. Please cancel if you do not want to delete.";
    }
    deleteConfirm.value = true
    deleteConfirmId.value = category.id
}

const deleteRowCancel=()=>{
    deleteConfirmId.value = ''
    categoryMessage.value =''

}

const deleteCategoryClick=()=>{
    categoryMessage.value='';
    form.delete(route('category.destroy',deleteConfirmId.value),{
     
     })
    
}

const columns =  [
    {name:'id', align:'left', label:'ID', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Name', field:'name'},
    {name:'department', align:'left', label:'Department ID', field:'department',format:val=>val.organization_name},
    {name:'created_at', align:'left', label:'Created_at', field:'created_at',format:val=>date.formatDate(val,'DD MMM YYYY')},
    {name:'actions', align:'left', label:'Action', field:'id'},

]

 const rowClicker =(row,evn)=>{
    console.log(router)
 }

if(props.CURRENT_USER.role_id==3){
 
    isDepartmentOfficer=false

 //form.department=props.CURRENT_USER.department_id
}

const submit=e=>{
     
    form.transform((data)=>({
        ...data,
        department:mCurrentDepartmentID
    })).put(route('category.update',form.id),
        {
            onSuccess:(p) => {
                modal.value= false
                q.notify({
                        message: 'Category Updated',
                        closeBtn: true,
                        icon: 'check',
                        iconColor: 'blue'
                    });
            }
        })
}
</script>
