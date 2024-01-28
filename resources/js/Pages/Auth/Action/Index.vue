<template>
    <Head title="Action List" />
    <div class="m-4">
    <h4 class="mb-4">Action</h4>

    <!-- <Link href="/admin/action/create" class="p-2 m-5 border">New Action</Link> -->

        <div class="q-pa-md">
            <q-table
            :rows="actions"
            :columns="columns"
            row-key="name"
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
            
            <template  v-slot:body-cell-actions="props">
               
                    <q-td 
                    key="action"
                    :props="props">
                        <div v-if="CURRENT_USER.role_id==1">
                            <q-btn
                                dense
                                round
                                flat
                                color="green"
                                @click="openEditModal(props.row)"
                                icon="edit"
                                ></q-btn>
                        </div>
                        <div v-else>
                            -
                        </div>
                      
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
                        <form @submit.prevent="submit" method="post">
                            <div class="q-pa-md">
                                <div class="q-gutter-x-md column" style="width: 400px">
                                    <q-input
                                        name="label"
                                        standout
                                        v-model="form.label"
                                        :error="!form.errors.label===false"
                                        :error-message="form.errors.label"
                                        :dense="dense"
                                        placeholder="Action Name">
                                    </q-input>

                                    <div>
                                        <q-toggle 
                                            v-model="form.visible" 
                                            label="Visibility for dropdown" 
                                            true-value=1
                                            false-value=0
                                            left-label />
                                    </div>

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
 import {ref,computed} from 'vue'
 import {useForm,Head,usePage} from "@inertiajs/vue3";
 import {useQuasar} from "quasar";
 import {useRouter} from 'vue-router'
 const q = useQuasar();

 const page = usePage()
const CURRENT_USER = computed(() => page.props.CURRENT_USER)

const modal = ref(false)
const form = useForm({
    id:'',
    label:'',
    visible:'',
})

defineProps({
    actions:Object
})

const router = useRouter();

const openEditModal=e=>{
    
    modal.value=true
    form.id = e.id
    form.label=e.label
    form.visible=e.visible

}


const columns =  [
    {name:'id', align:'left', label:'ID', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'label', align:'left', label:'Label', field:'label'},

    {name:'name', align:'left', label:'Value', field:'name'},
    {name:'visible', align:'left', label:'Visible', field:'visible'},

     {name:'actions', align:'left', label:'Action', field:'id'},

]
 

const submit=e=>{
    console.log("Im the only one: "+e)
    form.put(route('action.update',form.id),{
        onSuccess:() => {
            modal.value= false
            q.notify({
                    message: 'Action Updated',
                    closeBtn: true,
                    icon: 'check',
                    iconColor: 'blue'
                });
        }
    })
}
</script>
