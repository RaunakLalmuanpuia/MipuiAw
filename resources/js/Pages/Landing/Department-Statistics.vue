<template>
   <Head title="Departments Report"/> 
    <div class="row justify-center">
            <div class="col-7 m-5 mx-10">
                
                <q-table
                :rows="myDepartmentCount"
                :columns ="columns"
                flat bordered
                title="Performance Table of Department List"
                separator="cell"
                :pagination="{
                            sortBy:'id',
                            rowsPerPage:15,
                            descending:false,
                        }"        
                wrap-cells
                
                >
                     
                    
                </q-table>
                
                <!-- <Pagination class="mt-6" :links="myDepartmentCount.links"/> -->

            </div>
    </div>
    
    
</template>

<script setup>
 
 import {Head} from "@inertiajs/vue3"; 
 
const props = defineProps({
    myDepartmentCount:'',

})
 

const columns = [
    {name:'id', align:'left', label:'ID', field:'id'},
    {name:'organization_name', align:'left', label:'Department', field:'organization_name'},
    {name:'grievance_received', align:'left', label:'Grievance Received', field:'grievance_received'},
    {name:'grievance_closed', align:'left', label:'Grievance Closed', field:'grievance_closed'},
    {name:'NotYetProcess', align:'left', label:'Not Yet Process', field:'grievance_not_yet_process'},
    {name:'processing', align:'left', label:'Processing', field:'grievance_processing'},
    {name:'percentage', align:'left', label:'Close Percent', field:'percentage_closed'},
]

</script>