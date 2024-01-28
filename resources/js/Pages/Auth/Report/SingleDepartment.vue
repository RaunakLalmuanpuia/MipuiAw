<template>
    <Head title="Report"/> 
    <div class="m-5">
        <Link class="full-width border" :href="route('report.grievancelist')" >
                <div class="row mt-3 ">
                    <q-item-section avatar>
                        <i class="q-icon material-icons-outlined">
                            arrow_back
                        </i>
                        </q-item-section>
                        <q-item-section>
                            Back
                    </q-item-section>
                </div>  
            </Link>
 
        <q-table
            :rows="grievances.data"
            :columns ="columns"
            flat bordered
            title="My Grievance List"
            separator="cell"

            v-model:pagination="pagination"
            @request="tableData"
            :props="props"
            :filter="filter"
        >

            <template v-slot:top>
                <span class="text-2xl">Grievance List</span>
                <q-space/>
                <q-input autofocus dense debounce="800" @update:model-value="handleSearch" color="primary" v-model="search" placeholder="Search">
                    <template v-slot:append>
                        <q-icon name="search"/>
                    </template>
                    <q-tooltip>
                        Search using Name, Mobile and Registration Number
                    </q-tooltip>
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

            <template v-slot:body-cell-status="props">
                <q-td
                key="status"
                :props="props"> 

                    
                    <div v-if="props.row.action_id===1">
                        - No Action Required -
                    </div>
                    <div v-else-if="props.row.action_id===2">
                        - Examine At Our Level -
                    </div>
                    <div v-else-if="props.row.action_id===3">
                        - Take up with Subordinate Organization -
                    </div>
                    <div v-else-if="props.row.action_id===4">
                        - Case Disposed -
                    </div>
                    <div v-else-if="props.row.action_id===5">
                        - Transferred -
                    </div>
                    <div v-else-if="props.row.action_id===6">
                        - Appeal -
                    </div>
                    <div v-else-if="props.row.action_id===7">
                        - Closed -
                    </div> 
                    <div v-else-if="props.row.action_id===10">
                        - Subordinate Can Close The Case -
                    </div> 
                    <div v-else>
                        - Under Process -
                    </div>
                    
                </q-td>
            </template>
            
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
            
        </q-table>
    </div>

    
</template>

<script setup>
 import {ref} from 'vue'
 import {useForm,Head, router} from "@inertiajs/vue3";
 import {useQuasar} from "quasar";
 const q = useQuasar();

 const props = defineProps([
    'grievances','search','departmentId'
 ])

const search = ref(props.search)
const department_id = ref('')
const columns = [
    {name:'id', align:'left', label:'Sl No', field:'id'},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'applicant_name', align:'left', label:'Applicant Name', field:'applicant_name'},
    {name:'applicant_mobile', align:'left', label:'Applicant Mobile', field:'applicant_mobile'},

    {name:'registration_number', align:'left', label:'Registration No', field:'registration_number'},
    {name:'grievance_description', align:'left', label:'Description', field:'grievance_description'},
    {name:'more', align:'left', label:'Details', field:'id'},
    {name:'status', align:'center', label:'Status', field:'status'},
    // {name:'date_of_receipt', align:'left', label:'Receive Date', field:'date_of_receipt',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
    // {name:'last_update', align:'left', label:'Last Seen', field:'updated_at',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
]

const moreClick=(grievanceId)=>{
    router.get('/report/mydepartment/grievance/'+grievanceId);
}

const pagination = ref({
    page: props.grievances?.current_page || 0,
    rowsPerPage: props.grievances.per_page,
    rowsNumber: props.grievances.total,
})
function handleSearch(val){
    search.value = val;
    department_id.value=props.departmentId;
    tableData({pagination})
}
function tableData(props){

    const {page, rowsPerPage, } = props.pagination;
    router.get('/report/mydepartment/'+ department_id.value,{ 
        per_page: rowsPerPage,
        page: page,
        search:search.value
    },{})
}
</script>