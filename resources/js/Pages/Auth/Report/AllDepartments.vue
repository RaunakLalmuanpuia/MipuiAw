<template>
    <Head title="Report"/> 

    <div class="row justify-end mt-4">

        <div class="col-3" >
            <q-btn label="Select Range" color="primary" @click="showCalender = true" />
            <div v-if="rangeSelect">
                Range : {{ rangeSelect['from'] }} - {{ rangeSelect['to'] }}
            </div>
        </div>
        <div class="col-3">
            <q-btn
                label="Print"
                @click="printClick()"
            />
        </div>
    </div>
    <div class="m-5">
        <q-table
        :rows="myDepartmentCount"
        :columns ="columns"
        flat bordered
        title="Department List"
        separator="cell"
        :pagination="{
                    sortBy:'id',
                    rowsPerPage:15,
                    descending:false,
                }"        
        wrap-cells
        >
            <template v-slot:body-cell-more="props">
                <q-td
                    key="more"
                    :props="props"
                > 
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

            <template v-slot:body-cell-print="props">
                <q-td
                    key="id"
                    :props="props"
                > 
                <q-btn
                    dense
                    round
                    flat
                    color="blue"
                    @click="singleDepartmentPrint(props.row.id)"

                    icon="print"
                ></q-btn>
            </q-td>
                
            </template>
            
        </q-table>
        
        <!-- <Pagination class="mt-6" :links="myDepartmentCount.links"/> -->

    </div>

<q-dialog v-model="showCalender" persistent>
    <q-card>
        <q-card-section class="row items-center">
             <q-date 
             v-model="form.rangeSelect" 
             mask="DD/MM/YYYY"
             today-btn
             range 
             flat
             />
        </q-card-section>

        <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" v-close-popup />
        <q-btn flat label="Submit" @click="submitRange()" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>
</template>
<script setup>
 import {ref} from 'vue'
 import {useForm,Head,router} from "@inertiajs/vue3";
 import {useQuasar} from "quasar";
 import { Link } from '@inertiajs/vue3'
 
const showCalender=ref(false)
const q=useQuasar()

const props = defineProps([
    'myDepartmentCount','rangeSelect',
])
 


//const rangeSelect = ref({ from: '2023/07/08', to: '2023/07/17' })
//const rangeSelect=ref(null)
const columns = [
    {name:'id', align:'left', label:'ID', field:'id'},
    {name:'organization_name', align:'left', label:'Department', field:'organization_name'},
    {name:'grievance_received', align:'left', label:'Grievance Received', field:'grievance_received'},
    {name:'grievance_closed', align:'left', label:'Grievance Closed', field:'grievance_closed'},
    {name:'NotYetProcess', align:'left', label:'Not Yet Process', field:'grievance_not_yet_process'},
    {name:'processing', align:'left', label:'Processing', field:'grievance_processing'},
    {name:'print', align:'left', label:'Print', field:'id'},

    {name:'more', align:'left', label:'Details', field:'more'},

]

const moreClick=(id)=>{
    router.get('/report/mydepartment/'+id);
}

let form = useForm({
    rangeSelect:''
})

const submitRange=()=>{
    form.get('/report/grievancelist',{
        onStart:()=>q.loading.show({
            message: "Loading..."
        }),
        onFinish:()=>{
            q.loading.hide()
        }
    })
}
 
const printClick=()=>{
    const params = new URLSearchParams(props.rangeSelect).toString();
    const url = `/allreport/print?${params}`;
    window.open(url, '_blank');

}

const singleDepartmentPrint=(id)=>{
    const params = new URLSearchParams(props.rangeSelect).toString();

    const url = `/singlereport/print/${id}?${params}`;
    window.open(url, '_blank');
}

</script>
