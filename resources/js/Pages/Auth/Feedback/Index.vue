<template>

    <Head title="Feedback List" />
    <div class="m-5">
        <h4 class="mb-3">Feedback</h4>
         <div v-if="x_message" class="bg-red-2 border-red-9 mt-5 p-4 mb-5" >
             
            <div class="text-grey-9"> {{ x_message }}   </div>
        </div>

        <div class="q-pa-md">
            <q-table
            v-model:pagination="pagination"

           :rows="feedbacks.data"
            :columns="columns"
            row-key="name"
            @row-click="rowClicker"
            flat bordered
            title="Feedback List"
            separator="cell"
         
            @request="tableData"

            :props="props"
                :filter="filter"
            >

            <template v-slot:top>
                <span class="text-2xl">Feedback List</span>
                <q-space/>
                <q-input autofocus dense debounce="800" @update:model-value="handleSearch" color="primary" v-model="search" placeholder="Search">
                    <template v-slot:append>
                        <q-icon name="search"/>
                    </template>
                    <q-tooltip>
                        Search using Name , email or any text
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
                        {{ props.row.email }},{{ props.row.phone }},
                   </div>
                   <div>
                    Source: {{ props.row.source }}
                   </div>
                </q-td>
            </template>
            
            <template v-slot:body-cell-actions="props">
               
                    <q-td 
                    key="action"
                    :props="props">
                       

                        <q-btn
                            dense
                            round
                            flat
                            color="red"
                            @click="deleteRow(props.row.id)"
                            icon="delete"
                        ></q-btn>
                      
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
    'feedbacks',
    'errors',
    'search',
])
const search = ref(props.search)
const pagination = ref({
    page: props.feedbacks?.current_page || 0,
    rowsPerPage: props.feedbacks.per_page,
    rowsNumber: props.feedbacks.total,
})
function handleSearch(val){
    search.value = val;
    tableData({pagination})
}
function tableData(props){
    const {page, rowsPerPage, } = props.pagination;
    router.get(route('feedback.index'),{
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
    {name:'subject', align:'left', label:'Subject', field:'subject'},
    {name:'message', align:'left', label:'Message', field:'message'},
 
    {name:'created_at', align:'left', label:'Created_at', field:'created_at',format:val=>date.formatDate(val,'DD MMM YYYY')},
    {name:'actions', align:'left', label:'Action', field:'id'},
]



const deleteRow=id=>{
    q.dialog({
        title: 'Confirm Delete',
        message: 'Are you sure?',
        ok: 'Yes',
        cancel: 'No'
    }).onOk(() => {
        router.delete(route('feedback.destroy', id), {
            onStart:()=>q.loading.show({message:'Deleting....'}),
            onSuccess:()=>{
                q.notify({
                    message:'Quote deleted',
                    closeBtn:true,
                })
                q.loading.hide();
            },
            onFinish:()=>q.loading.hide(),
            preserveState: false,
        })
    }).onCancel(() => {
    })
}

</script>
