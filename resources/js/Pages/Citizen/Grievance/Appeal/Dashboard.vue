<template>
    <Head title="Appeal Dashboard" />

    <div class="m-5">
        <h4> Appeal Dashboard </h4>

        <div class="q-pa-md">

            <q-table
                :rows="appeals"
                :columns="columns"
                :props="props"
                row-key="name"
                table-header-class="bg-grey-2"
                flat bordered
                title="Appeal List"
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
                            <!-- 7=closed -->
                            <div v-if="props.row.action_id==7">
                                - Closed -
                            </div>
                            <!-- 6=closed -->
                            <div v-else-if="props.row.action_id==6">
                                - Appeal -
                            </div>
                            <div v-else>
                                - Under Process -
                            </div>
                    </q-td>
                </template>

                <template v-slot:body-cell-appeal_description="props">
                    <q-td
                    key="appeal_description"
                    :props="props">
                        <q-btn
                            dense
                            round
                            flat
                            color="green-9"
                            @click="appealDetail(props.row.id)"
                            icon="more"
                        >

                        </q-btn>
                    </q-td>
                </template>

            </q-table>
            </div>
    </div>
</template>

<script setup>
import { Head,router } from '@inertiajs/vue3';


const props = defineProps([
'appeals'
])


const columns= [
    {name:'id', align:'left', label:'Sl No', field:'id'},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'Organization', align:'left', label:'Department Name', field:'department',format:val=>val.organization_name},
    {name:'grievance_description', align:'left', label:'Description', field:'grievance_description'},
    {name:'more', align:'left', label:'Details', field:'id'},
    {name:'action_id', align:'left', label:'Status', field:'action_id'},
    {name:'appeal_description', align:'left', label:'Appeal Detail', field:'appeal_description'},

]

const moreClick=(id)=>{
     router.get('/grievance/citizen/show/'+id);
 }

 const appealDetail=(id)=>{
     router.get('/appeal/citizen/show/'+id);
 }

</script>