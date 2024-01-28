<template>

    <Head title="Quote List" />
    <div class="m-5">
        <h4 class="mb-3">Category</h4>

        <div v-if="x_message" class="bg-blue-2 border-blue-9 mt-5 p-4 mb-5  border-2" >
            <div class="text-blue-9 text-h6 text-bold">
                INFORMATION
            </div>
            <div class="text-grey-9"> {{ x_message }}   </div>
        </div>
        <Link :href="route('quote.create')" class="p-2 m-5 bg-blue-5 text-white shadow-2">New Quote</Link>

        <div class="q-pa-md">
            <q-table
            :rows="quotes"
            :columns="columns"
            row-key="name"
            @row-click="rowClicker"
            flat bordered
            title="Quote List"
            separator="cell"
            :pagination="{
                rowsPerPage:10,
            }"
            records-per-page-options="[1,5,10]"
            :filter="filter"
            >

            <template v-slot:top-right>
                <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
                <template v-slot:append>
                    <q-icon name="search" />
                </template>
                </q-input>
            </template>

            <template v-slot:body-cell-id="props">
                <q-td key="id" :props="props">
                    {{ props.rowIndex+1 }}
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
                            color="green"
                            @click="openEditModal(props.row)"
                            icon="edit"
                        ></q-btn>

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

            <!-- MODALS -->
            <q-dialog v-model="modal">
                <q-card>
                    <q-toolbar>
                        <q-toolbar-title><span class="text-weight-bold">Edit Action</span></q-toolbar-title>
                        <q-btn flat round dense icon="close" v-close-popup/>
                    </q-toolbar>

                    <q-card-section>
                        <form @submit.prevent="submit" method="put">
                            <div class="q-pa-md">
                                <div class="q-gutter-x-md column" style="width: 400px">
                                    <q-input
                                        name="Quote"
                                        standout
                                        v-model="form.quote"
                                        :error="!form.errors.quote===false"
                                        :error-message="form.errors.quote"
                                        :dense="dense"
                                        placeholder="Quote">
                                    </q-input>
                                    <q-input
                                        name="Speaker"
                                         
                                        v-model="form.speaker"
                                        :error="!form.errors.speaker===false"
                                        :error-message="form.errors.speaker"
                                        :dense="dense"
                                        placeholder="Speaker">
                                    </q-input>
                                     
                                    <div>
                                        <q-btn label="Update" dense color="black" type="submit"
                                            :disable="form.processing"/>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </form>
                    </q-card-section>
                </q-card>
            </q-dialog>
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
 
const props = defineProps({
    quotes:'',
    errors:'',
})
 
const openEditModal=e=>{
    modal.value=true
    form.id = e.id
    form.quote=e.quote
    form.speaker=e.speaker
}

const columns =  [
    {name:'id', align:'left', label:'ID', field:'id',headerClasses:''},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'quote', align:'left', label:'Quote', field:'quote'},
    {name:'speaker', align:'left', label:'Speaker', field:'speaker'},
    {name:'created_at', align:'left', label:'Created_at', field:'created_at',format:val=>date.formatDate(val,'DD MMM YYYY')},
    {name:'actions', align:'left', label:'Action', field:'id'},
]

const submit=e=>{
    form.transform((data)=>({
        ...data,
    })).put(route('quote.update',form.id),
        {
            onSuccess:(p) => {
                modal.value= false
                q.notify({
                        message: 'Category Updated',
                        closeBtn: true,
                        icon: 'check',
                        iconColor: 'blue'
                    });
            }
        })
} 

const deleteRow=id=>{
    q.dialog({
        title: 'Confirm Delete',
        message: 'Are you sure?',
        ok: 'Yes',
        cancel: 'No'
    }).onOk(() => {
        router.delete(route('quote.destroy', id), {
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
