<template>
    <Head title="Create Sub-Nodal" />
    <div class="container mt-5 mb-5 ml-5">
        <h5>Sub Nodal Officers</h5>
    <h4 class="mb-4">{{ departmentName }}</h4>
    <Link :href="route('all.officer')" as="button"  type="button">Back</Link>

    <Link :href="'/nodal/sibling/'+departmentId" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Sub Department Nodal</Link>
        <div class="q-pa-md">
            <q-table
                :rows="sibling"
                :columns="columns"
                row-key="name"
                @request="tableData"
                flat bordered
                title="List"
                separator="cell"
                :filter="filter"
                :pagination="{
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
                     {{props.row.role.name}}
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
                        @click.stop="$inertia.get('/admin/adminViewSubNodalOfficerEdit/'+props.row.id)"
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

           <!-- <Pagination :links="departments.links" /> -->

    </div>
</template>
<script setup>
 import {onMounted, ref} from 'vue'
 import {Head,useForm, router, Link} from "@inertiajs/vue3";
 import {date, useQuasar} from "quasar";
import { InertiaProgress } from '@inertiajs/progress';

//  import {useRouter} from 'vue-router'

 const q=useQuasar()

const modal = ref(false)
const form = useForm({
    name:'',
})

defineProps({
    sibling:Object,
    departmentId:'',
    departmentName:'',
    role:'',
})

//const router = useRouter();

const openEditModal=e=>{
    // modal.value=true;
    // form.name=e.name;
    this.$inertia.visit('login');
}

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Department Nodal Officer', field:'name'},
    {name:'mobile', align:'left', label:'Phone', field:'mobile'},

    {name:'roles', align:'left', label:'Role', field:'role'},
    {name:'last_active', align:'left', label:'Last Active', field:'last_login',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')??'-'},

    {name:'actions', align:'left', label:'Action', field:'id'},
]

  

const submit=e=>{
    console.log("Im the only one: "+e)


}

const allOfficer=()=>{
    Inertia.get('allofficer');
}

const deleteRow=id=>{
    q.dialog({
        title: 'Confirm Delete',
        message: 'Are you sure?',
        ok: 'Yes',
        cancel: 'No'
    }).onOk(() => {
        router.delete(route('nodal.destroy', id), {

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
    }).onCancel(() => {
    })
}
</script>
