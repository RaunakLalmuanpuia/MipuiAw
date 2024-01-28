<template>
    <Head title="Dashboard" />
    <div class="container">
         
        <div class="m-4">
            <div v-show="CURRENT_USER.active==0">
                <p class="text-h4 pt-3 bg-red-2 text-red-6 p-3 text-weight-medium">
                    YOUR ACCOUNT IS INACTIVE!
                </p>
            </div>

            <h3>Dashboard</h3>
            
            {{ dashboadData }}
            
            <div class="q-pa-md example-row-equal-width">
                <div class="row">
                    <div class="p-5 " :class="$q.screen.xs ? 'col-12':'col'">
                        <q-card class="mHoverable my-card bg-amber-9 text-white">
                            <q-card-section>
                                <div class="text-center">
                                    <div class="text-h2">
                                        {{ props.dashboardData.total_grievance_received??'nil' }} 
                                    </div>
                                    <hr>
                                    <div class="text-bold">
                                        Total Grievance Registered
                                    </div>
                                </div>
 
                            </q-card-section>
                        </q-card>
                    </div>
                    <div class="p-5" :class="$q.screen.xs ? 'col-12':'col'">
                        <q-card class="mHoverable my-card bg-green-9 text-white">
                            <q-card-section>
                                <div class="text-center">
                                    <div class="text-h2">
                                        {{ props.dashboardData.total_grievance_pending??'nil' }} 
                                    </div>
                                    <hr>
                                    <div class="text-bold">
                                        Number of Grievances Pending

                                    </div>
                                </div>
 
                            </q-card-section>
                        </q-card>
                    </div>
                    <div class="p-5" :class="$q.screen.xs ? 'col-12':'col'">
                        <q-card class="mHoverable my-card bg-cyan-9 text-white">
                            <q-card-section>
                                <div class="text-center">
                                    <div class="text-h2">
                                        {{ props.dashboardData.total_grievance_closed??'nil' }} 

                                    </div>
                                    <hr>
                                    <div class="text-bold">
                                        Number of Grievances Closed
                                    </div>
                                </div>
                            </q-card-section>
                        </q-card>
                    </div>
                </div>
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
                 title="Grievance List"
                 separator="cell"
                 wrap-cells
                 @request="tableData"
                 >

                 <template v-slot:top>
                    <span class="text-2xl">Grievance List</span>
                    <q-space/>
                    <q-input autofocus dense debounce="800" @update:model-value="handleSearch" color="primary" v-model="search" placeholder="Search">
                        <template v-slot:append>
                            <q-icon name="search"/>
                        </template>
                        <q-tooltip>
                            Search using Registration Number, Department and Description.
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
                    <q-td class="" :props="props">
                        <div   style="width:140px;">
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
                <template v-slot:body-cell-status="props">
                    <q-td
                    key="status"
                    :props="props">
                        <div style="width: 170px;" class="text-center">
                            <div v-if="CURRENT_USER.role_id==5">
                                <div v-if="!props.row.is_seen_by_citizen">
                                   
                                    <div class="text-red" >
                                         
                                        <i class="q-icon material-icons">
                                            notifications
                                        </i>
                                        
                                    </div>
                                </div>
                            </div>
                            <div v-if="props.row.action_id===1" >
                                - No Action Required -
                            </div>
                            <div v-else-if="props.row.action_id===2">
                                - Grievance under examination -
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
                            <div v-else>
                                - Under Process -
                            </div>
                            
                        </div>
                    </q-td>
                </template>
                <template v-slot:body-cell-date_of_receipt="props">
                    <q-td :props="props">
                        <div style="width: 150px;">
                            {{ date.formatDate(props.row.created_at,'DD MMM YYYY, hh:mm A') }}
                        </div>
                    </q-td>
                        

                </template>
            </q-table>
        </div>
    </div>
    
      
</template>
<script setup>
import {ref,computed,onMounted} from 'vue'
import { useForm,Head,router} from "@inertiajs/vue3";
import axios from 'axios'
import { useQuasar,Notify,date } from 'quasar';
import { usePage } from '@inertiajs/vue3'
 


const page = usePage()
const CURRENT_USER = computed(() => page.props.CURRENT_USER)

const props = defineProps(['grievances','dashboardData','search'])
const search = ref(props.search)

const q=useQuasar()
 
const flash = computed(() => page.props.flash)

let forms = useForm({})

const moreClick=(id)=>{
    router.get('/grievance/citizen/show/'+id);
}

const columns= [
    {name:'id', align:'left', label:'Sl No', field:'id'},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'organization', align:'left', label:'Department Name',field:'department' },
    {name:'registration_number', align:'left', label:'Registration No', field:'registration_number'},

    {name:'grievance_description', align:'left', label:'Description', field:'grievance_description'},
    {name:'more', align:'left', label:'Details', field:'id'},
    {name:'status', align:'center', label:'Status', field:'status'},
    {name:'date_of_receipt',align:'left', label:'Submit Date', field:'created_at' },
]


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
    router.get(route('citizen.dashboard'),{
        per_page: rowsPerPage,
        page: page,
        search:search.value
    },{})
}




</script>



<style>
   .mHoverable:hover{
        box-shadow: 4px 4px 10px grey;
        /* font-size:15px; */
        transition: 0.1s ease;
    }

    .local-turncate{
        width: 20px;
    }
</style>