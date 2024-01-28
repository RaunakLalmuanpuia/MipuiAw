<template>
   <Head title="NODAL Officers"/> 
    <div class="row justify-center">
            <div class="col-7 m-5 mx-10">
                
                <q-table
                :rows="nodals"
                :columns ="columns"
                flat bordered
                title="List of Nodal Officer"
                separator="cell"
                :pagination="{
                            sortBy:'id',
                            rowsPerPage:15,
                            descending:false,
                        }"        
                wrap-cells
                >

                <template v-slot:body-cell-id="props">
                    <q-td key="id" :props="props">
                        {{ props.rowIndex+1 }}
                    </q-td>
                </template>

                <template v-slot:body-cell-department="props">
                    <q-td :props="props">
                        {{ props.row.department.organization_name }}
                    </q-td>
                </template>
                <template v-slot:body-cell-active="props">
                    <q-td :props="props">
                        <div v-if="props.row.active==1">
                            <div class="text-green-9">Active</div>
                        </div>
                        <div v-else>
                            <div class="text-red-9">Inactive</div>
                        </div>
                    </q-td>
                </template>
                </q-table>
            </div>
    </div>
    
</template>

<script setup>
 
 import {Head} from "@inertiajs/vue3"; 
  
const props = defineProps({
    nodals:'',

})

const columns = [
    {name:'id', align:'left', label:'ID', field:'id'},
    {name:'name', align:'left', label:'Name', field:'name'},
    {name:'department', align:'left', label:'Department', field:'department_id'},
    {name:'phone', align:'left', label:'Phone', field:'mobile'},
    {name:'email', align:'left', label:'Email', field:'email'},
    {name:'active', align:'left', label:'Status', field:'active'},

]


</script>