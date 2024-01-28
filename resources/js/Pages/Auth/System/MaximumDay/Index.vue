<template>
    <Head title="Max Days"/>
<div>
    <q-table
            :rows="maximumDay"
            :columns="columns"
            row-key="name"
            
            @row-click="rowClicker"
            flat bordered
            title="Maximum Days"
            separator="cell"
             
            >
            <template v-slot:body-cell-id="props">
                <q-td key="id" :props="props">
                    {{ props.rowIndex+1 }}
                </q-td>
            </template>
            <template v-slot:body-cell-actions="props">
               
                    <q-td 
                    key="actions"
                    :props="props">
                        <q-btn
                            dense
                            round
                            flat
                            color="green"
                            @click="openEditModal(props.row)"
                            icon="edit"
                        ></q-btn>
                         
                    </q-td>
                </template>
            </q-table>

</div>
<!-- MODALS -->
<q-dialog v-model="modal">
<q-card>
<q-toolbar>
    <q-toolbar-title><span class="text-weight-bold">Edit Maximum Days</span></q-toolbar-title>
    <q-btn flat round dense icon="close" v-close-popup/>
</q-toolbar>

<q-card-section>
    <form @submit.prevent="submit" method="put">
        <div class="q-pa-md">
            <div class="q-gutter-x-md column" style="width: 400px">
                <q-input
                    name="Maximum Days"
                    standout
                    v-model="form.maximumDay"
                    :error="!form.errors.maximumDay===false"
                    :error-message="form.errors.maximumDay"
                    :dense="dense"
                    placeholder="Maximum Days">
                </q-input>
                 
                    
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
</template>

<script setup>
import {ref} from "vue"
import {Head, useForm} from "@inertiajs/vue3"
import {useQuasar} from "quasar";
const q = useQuasar();
const modal = ref(false)
const props = defineProps([
    'maximumDay',
])

const form = useForm({
    id:'',
    maximumDay: ""
})

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id',headerClasses:''},
    {name:'label', align:'left', label:'Label', field:'label'},
    {name:'maximum_days', align:'left', label:'Maximum Days', field:'maximum_days'},
    {name:'actions', align:'left', label:'Action', field:'id'},

]

const openEditModal=e=>{
    modal.value=true
    form.id = e.id
    form.maximumDay=e.maximumDay
}

const submit=e=>{
    form.transform((data)=>({
        ...data,
    })).put(route('maximumday.update',form.id),
        {
            onSuccess:(p) => {
                modal.value= false
                q.notify({
                        message: 'Maximum Day Updated',
                        closeBtn: true,
                        icon: 'check',
                        iconColor: 'blue'
                    });
            }
        })
} 

</script>