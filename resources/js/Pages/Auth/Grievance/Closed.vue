<template>
    <Head title="Closed" />
    
    <div class="container">
        <h3>Closed Case & Transferred</h3>
      
        

        <div class="q-pa-md">

            <q-table
                v-model:pagination="pagination"
                :rows="grievances.data"
                :columns="columns"
                :props="props"
                row-key="name"
                table-header-class="bg-grey-2"
                flat bordered
                title="Grievance List"
                separator="cell"
                @request="tableData"
                >
                <template v-slot:top>
                    <span class="text-2xl">Closed List</span>
                    <q-space/>
                    <q-input autofocus dense debounce="800" @update:model-value="handleSearch" color="primary" v-model="search" placeholder="Search">
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
                
                <template v-slot:body-cell-grievance_description="props">
                    <q-td :props="props">
                        <div class="">
                            {{  props.row.grievance_text}}
                        </div>
                    </q-td>
                </template>

                <template v-slot:body-cell-more="props">
                    <q-td 
                    key="more"
                    :props="props">
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

                <template v-slot:body-cell-action_id="props">
                    <q-td
                    key="status"
                    :props="props"> 
                         
                            <div v-if="props.row.action_id===7">
                                - Closed -

                            </div>
                            <div v-else-if="props.row.action_id===5">
                                - Transferred to another department -
                            </div>
                            <div v-else>
                                - Under Process -
                            </div>
                    </q-td>
                </template>
                <template v-slot:body-cell-date_of_final_remark="props">
                    <q-td
                    key="status"
                    :props="props"> 
                    {{ date.formatDate(props.row.date_of_final_remark,'DD MMM YYYY, hh:mm A' ) }}
                    </q-td>
                </template>
            </q-table>
        </div>
    </div>


</template>


<script setup>
import {ref} from 'vue'
import {router, useForm,Head} from "@inertiajs/vue3";
import { date } from "quasar";


const props = defineProps(['grievances','search'])
const search = ref(props.search)

let form = useForm({}) 

const moreClick=(id)=>{
    router.get('/grievance/officer/show/'+id,
   { from_closed_page:true}
    );
}

const columns= [
    {name:'id', align:'left', label:'Sl No', field:'id'},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'applicant_name', align:'left', label:'Applicant Name', field:'applicant_name'},
    {name:'registration_number', align:'left', label:'Registration No', field:'registration_number'},
    {name:'grievance_description', align:'left', label:'Description', field:'grievance_description'},
    {name:'more', align:'left', label:'Details', field:'id'},
    {name:'action_id', align:'left', label:'Status', field:'action_id'},
    {name:'date_of_final_remark', align:'left', label:'Closed On', field:'date_of_final_remark' },

]
// 
// {name:'action', align:'left', label:'Action Taken', field:'action',format:val=>val.label},


const pagination = ref({
    page: props.grievances?.current_page || 0,
    rowsPerPage: props.grievances.per_page,
    rowsNumber: props.grievances.total,
})

function handleSearch(val){
    search.value = val;
    tableData({pagination})
}

function tableData(props){
    const {page, rowsPerPage, } = props.pagination;
    router.get(route('officer.closed'),{
        per_page: rowsPerPage,
        page: page,
        search:search.value
    },{})
}



</script>