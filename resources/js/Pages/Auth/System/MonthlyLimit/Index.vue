<template>
    <Head title="Monthly Limit"/>
<div class="mt-5">
    <div class="row justify-center">
        <div class="col-6">
            <q-table
                :rows="monthly_limit"
                :columns="columns"
                row-key="name"
                
                @row-click="rowClicker"
                flat bordered
                title="Monthly Limit"
                separator="cell"
                
                >
                 
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
                            
                        </q-td>
                    </template>
            </q-table>
        </div>
    
    </div>
    
 </div>

<!-- MODALS -->
<q-dialog v-model="modal">
<q-card>
<q-toolbar>
    <q-toolbar-title><span class="text-weight-bold">Edit Monthly Limit</span></q-toolbar-title>
    <q-btn flat round dense icon="close" v-close-popup/>
</q-toolbar>

<q-card-section>
    <form @submit.prevent="submit" method="put">
        <div class="q-pa-md">
            <div class="q-gutter-x-md column" style="width: 400px">
                <q-input
                    name="Monthly Limit"
                    standout
                    v-model="form.monthly_limit"
                    :error="!form.errors.monthly_limit===false"
                    :error-message="form.errors.monthly_limit"
                    :dense="dense"
                    placeholder="Monthly Limit">
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
import {ref,computed} from 'vue'
import {useForm,Head,usePage} from "@inertiajs/vue3";
import {date,useQuasar} from "quasar";

const q = useQuasar();
const page = usePage();
const x_message = computed(() =>page.props.flash.message)

const modal = ref(false)
let form = useForm({
    id:'',
    monthly_limit:'',
    
})

const props = defineProps([
    'monthly_limit','errors',

])

const openEditModal=e=>{
    modal.value=true
    form.id = e.id
    form.monthly_limit=e.monthly_limit
}
const columns =  [
    
    {name:'monthly_limit', align:'left', label:'Monthly Limit', field:'monthly_limit'},
    {name:'actions', align:'left', label:'Action', field:'id'},
    {name:'updated_at', align:'left', label:'Update At', field:'updated_at',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm aa')},

]

const submit=e=>{
    form.transform((data)=>({
        ...data,
    })).put(route('monthlyLimit.update',form.id),
        {
            onSuccess:(p) => {
                modal.value= false
                q.notify({
                        message: 'Monthly Limit Updated',
                        closeBtn: true,
                        icon: 'check',
                        iconColor: 'blue'
                    });
            }
        })
} 

</script>