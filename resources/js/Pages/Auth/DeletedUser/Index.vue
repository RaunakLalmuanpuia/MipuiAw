<template>

    <Head title="Deleted Users" />
    <div class="m-5">
        <h4 class="mb-3">Deleted Users</h4>
         <div v-if="x_message" class="bg-green-2 border-green-9 mt-5 p-4 mb-5" >
             
            <div class="text-grey-9"> {{ x_message }}   </div>
        </div>

        <div class="q-pa-md">
            <q-table
            v-model:pagination="pagination"
           :rows="deletedUsers.data"
            :columns="columns"
            row-key="name"
            @row-click="rowClicker"
            flat bordered
            title="Deleted Users"
            separator="cell"
            class="text-grey-7"
            @request="tableData"

            :props="props"
                :filter="filter"
            >

            <template v-slot:top>
                <span class="text-2xl">Deleted Users</span>
                <q-space/>
                <q-input autofocus dense debounce="800" @update:model-value="handleSearch" color="primary" v-model="search" placeholder="Search">
                    <template v-slot:append>
                        <q-icon name="search"/>
                    </template>
                    <q-tooltip>
                        Search using Name , email, mobile or district
                    </q-tooltip>
                </q-input>
            </template>

            <template v-slot:body-cell-id="props">
                <q-td key="id" :props="props">
                    {{ props.rowIndex+1 }}
                </q-td>
            </template>

            <template v-slot:body-cell-name="props">
                <q-td key="id" :props="props">
                   <div>
                        {{ props.row.name }}
                   </div>
                   <div>
                        {{ props.row.email }},{{ props.row.mobile }}
                   </div>
                   <div>
                 {{ props.row.district }}
                   </div>
                </q-td>
            </template>
            <template v-slot:body-cell-role_id="props">
                <q-td key="id" :props="props">
                    <span v-if="props.row.role_id==5">Citizen</span>
                    <span v-else>Official</span>
                </q-td>
            </template>

             
            </q-table>

            
        </div>
    </div>


</template>
<script setup>
 import {ref,computed} from 'vue'
 import {useForm,Head,usePage,router} from "@inertiajs/vue3";
 import {date,useQuasar} from "quasar";

 const q = useQuasar();
 const page = usePage();
 const x_message = computed(() =>page.props.flash.message)
 const filter = ref('')


const modal = ref(false)

let form = useForm({
    id:'',
    quote:'',
    speaker:'',
})
 
const props = defineProps([
    'deletedUsers',
    'errors',
    'search',
])
const search = ref(props.search)
const pagination = ref({
    page: props.deletedUsers?.current_page || 0,
    rowsPerPage: props.deletedUsers.per_page,
    rowsNumber: props.deletedUsers.total,
})
function handleSearch(val){
    search.value = val;
    tableData({pagination})
}
function tableData(props){
    const {page, rowsPerPage, } = props.pagination;
    router.get(route('deletedUser.index'),{
        per_page: rowsPerPage,
        page: page,
        search:search.value
    },{})
}
const openEditModal=e=>{
    modal.value=true
    form.id = e.id
    form.quote=e.quote
    form.speaker=e.speaker
}

const columns =  [
    {name:'id', align:'left', label:'ID', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'name', align:'left', label:'Name', field:'id'},
    {name:'role_id', align:'left', label:'Role', field:'role_id'},
    {name:'created_at', align:'left', label:'Deleted At', field:'created_at',format:val=>date.formatDate(val,'DD MMM YYYY hh:mm aa')},
]



 

</script>
