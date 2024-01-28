<template>
    <Head title="Dashboard" />
    
    <div class="container">
        <div class="m-4">
            <div v-show="CURRENT_USER.active==0">
                <p class="text-h4 pt-3 bg-red-2 text-red-6 p-3 text-weight-medium">
                    YOUR ACCOUNT IS INACTIVE!
                </p>
            </div>
            
            
             
            
            <div v-if="CURRENT_USER.role_id==1 || CURRENT_USER.role_id==2">
                <h3>Dashboard</h3>
                <AdminDashboard v-bind:dashboardData='dashboardData'  />
            </div>
            <div v-else-if="CURRENT_USER.role_id==3">
                <h3>Dashboard</h3>
                <OfficerDashboard v-bind:dashboardData='dashboardData'  />
            </div>
            <div v-else-if="CURRENT_USER.role_id==4||CURRENT_USER.role_id==6">
                
                <SubOfficerDashboard v-bind:dashboardData='dashboardData'  />
            </div>
        </div>
        <div v-if="CURRENT_USER.role_id==3" class="ml-5 py-2 text-center bg-grey-4">
            <div>
                Note: Please address all grievances within a 15-day timeframe.
            </div>
            <div>
                Note: Grievance hrim hrim hi ni 15 chhung a khawih chet ngei ngei tur a ngen kan ni.
            </div>
        </div>
        <div class="q-pa-md">

            <q-table
                v-model:pagination="pagination"
                :rows="grievances.data"
                :columns="columns"
                :props="props"
                row-key="name"
                table-header-class="bg-grey-2"
                flat bordered
                separator="cell"
                wrap-cells
                @request="tableData"
                preserve-scroll
                >
                <template v-slot:top>
                    <span class="text-2xl">{{ tableTitle }}</span>
                    <q-space/>
                    <q-input preserve-scroll autofocus dense debounce="800" @update:model-value="handleSearch" color="primary" v-model="search" placeholder="Search">
                        <template v-slot:append>
                           <q-icon name="search"/>
                        </template>
                        <q-tooltip>
                            Search using Applicant Name, Registration Number, Department and Description.
                        </q-tooltip>
                    </q-input>
                </template>
                
                <template v-slot:body-cell-id="props">
                    <q-td key="id" :props="props">
                        {{ props.rowIndex+1 }}
                    </q-td>
                </template>
                
                <template v-slot:body-cell-organization="props">
                    <q-td  :props="props">
                        <div  style="width: 200px;">
                            {{ props.row.department.organization_name }}
                        </div>
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
                        
                        <div v-if="CURRENT_USER.role_id==3">
                            <div v-if="!props.row.is_seen_by_department"  >
                                <div class="text-red" >
                                     
                                        <i class="q-icon material-icons">
                                            notifications
                                        </i>
                                     
                                </div>
                            </div>
                        </div>

                        <div v-else-if="CURRENT_USER.role_id==4"> 
                            <div  v-if="!props.row.is_seen_by_sub_department">
                                <div class="text-red" > 
                                    
                                    <i class="q-icon material-icons">
                                        notifications
                                    </i>
                                      
                                </div>
                            </div>
                        </div>
                        <div v-else-if="CURRENT_USER.role_id==6">
                            <div v-if="!props.row.is_seen_by_appellate" >
                                <div class="text-red" >
                                     
                                    <i class="q-icon material-icons">
                                        notifications
                                    </i>
                                      
                                </div>
                            </div>
                        </div>
                        
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

                <template v-slot:body-cell-time_elapse_since_submission="props">
                    <q-td :props="props"> 
                      
                        <div v-bind:class="[props.row.diff_in_days>=maximumDaysForDepartmentNodalLocal?'bg-red-4':'']">
                            {{ props.row.diff_in_days??'' }}
                        </div>
                    </q-td>
                </template>
            </q-table>
        </div>
    </div> 
</template>

<script setup>
import {ref} from 'vue'
import {router, useForm,Head} from "@inertiajs/vue3";
import {date } from 'quasar'
import { usePage } from '@inertiajs/vue3'
import { computed,onMounted} from 'vue'

import AdminDashboard from '@/Pages/Auth/Dashboard/Component/Admin.vue'
import OfficerDashboard from '@/Pages/Auth/Dashboard/Component/Officer.vue'
import SubOfficerDashboard from '@/Pages/Auth/Dashboard/Component/Sub-Officer.vue'

let tableTitle=''

const page = usePage()
const CURRENT_USER = computed(() => page.props.CURRENT_USER)

if(CURRENT_USER.role_id==6){
    tableTitle= 'Grievance Appeal List'
}else{
    tableTitle='Grievance Pending List'
}

const props = defineProps(['grievances','dashboardData','search','maximumDaysForDepartmentNodal'])
const search = ref(props.search)
const rows = ref('')

const maximumDaysForDepartmentNodalLocal = props.maximumDaysForDepartmentNodal;
let form = useForm({}) 

const moreClick=(id)=>{
    router.get('/grievance/officer/show/'+id);
}

const columns= [
    {name:'id', align:'left', label:'Sl No', field:'id'},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'applicant_name', align:'left', label:'Applicant Name', field:'applicant_name'},
    {name:'registration_number', align:'left', label:'Registration No', field:'registration_number'},
    {name:'organization', align:'left', label:'Department', field:'organization'},

    {name:'grievance_description', align:'left', label:'Description', field:'grievance_description'},
    {name:'more', align:'left', label:'Details', field:'id'},
    {name:'status', align:'center', label:'Status', field:'status'},
    {name:'date_of_receipt', align:'left', label:'Receive Date', field:'date_of_receipt',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
    {name:'last_update', align:'left', label:'Last Seen', field:'updated_at',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
    {name:'time_elapse_since_submission', align:'center', label:'Day Count ', field:'time_elapse_since_submission'},

]

const pagination = ref({
    page: props.grievances?.current_page || 0,
    rowsPerPage: props.grievances.per_page,
    rowsNumber: props.grievances.total,
})

function handleSearch(val){
    
    search.value=val;
    tableData({pagination})
}
function tableData(props){

    const {page, rowsPerPage, } = props.pagination;
    router.get(route('officer.dashboard'),{
        
        per_page: rowsPerPage,
        page: page,
        search:search.value
    },{})
    
}
onMounted(() => {
    console.log(props.search)
})

</script>
<style>
  
    .mHoverable:hover{
        box-shadow: 4px 4px 10px grey;
        /* font-size:15px; */
        transition: 0.1s ease;
    }
</style>