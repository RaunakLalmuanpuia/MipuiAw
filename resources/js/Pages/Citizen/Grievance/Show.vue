<template>
    <Head title="Description"/>
    <div>
        <div class="m-5">
            <q-btn  class="mb-3" href="#" onclick="history.back();return false;" color="grey-4" text-color="black" label="Back" />

            <div class="border shadow">
                <div class="p-3 bg-grey-4 text-h5">
                    Grievance Details
                </div>

                <div>
                    <div class="p-5">
                        
                        <div class="row m-3">
                            
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Registration Number
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.registration_number}}
                            </div>


                        </div>
                        <hr>
                        <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Name
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.applicant_name}}

                            </div>
                        </div>
                        <hr>
                        <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Date of Receipt
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                               
                                {{ date.formatDate(props.grievance.date_of_receipt,'DD MMM YYYY, hh:mm A') }}

                            </div>
                            
                        </div>
                        <hr>
                        <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Address
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.applicant_address}}

                            </div>
                           
                        </div>
                        <hr>
                         
                         
                        <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                District
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.applicant_district}}

                            </div>
                            
                        </div>
                        <hr>
                        <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Mobile Number
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.applicant_mobile}}

                            </div>
                           
                        </div>
                        <hr>
                        <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Email ID
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.applicant_email}}

                            </div>
                            
                        </div>
                        

                        <hr>
                        <div class="row m-3">
                            
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                               Department
                            </div>
                            <div  :class="$q.screen.xs ? 'col-12':'col-8'" style="white-space:pre-line">
                                {{ props.grievance.department.organization_name }}
                            </div>
                        </div>
                        <hr>
                        <div class="row m-3">
                            
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Grievance Description
                            </div>
                            <div  :class="$q.screen.xs ? 'col-12':'col-8'" style="white-space:pre-line">
                                <div>
                                    {{ props.grievance.grievance_description_modify}}
                                    <div v-show="readMoreButton" v-on:click="readMoreButtonClick" class="text-blue-8 underline italics">
                                        <a href="#">{{ readMoreReadLessText }}</a>
                                    </div>

                                    <div v-if="grievance.update_date_of_receipt!=null" class="text-end text-caption" >
                                      <em>  Edited {{  date.formatDate(props.grievance.update_date_of_receipt,'DD MMM YYYY, hh:mm A')}}</em>
                                    </div>
                                    <div v-if="props.grievance.edit" class="clickable cursor-pointer text-end">   
                                        <div v-if="CURRENT_USER.id == props.grievance.user_id">
                                            <span @click="dialogEditDescription=true"> 
                                                <span class="text-caption" style="text-decoration: underline;">Edit</span> 
                                                <q-tooltip>
                                                    Can be edit within {{ EDITING_HOURS_FOR_CITIZEN }} hr(s) of submit
                                                </q-tooltip>
                                            </span>
                                        </div>
                                    </div> 
                                </div>
                                
                            </div>
                        </div>
                        <hr>
                        <div class="row m-3">
                            
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Attachment
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'" style="white-space:pre-line">
                                <div v-if="$props.mUserFiles !=null">
                                     
                                    <li v-for="(item,index) in $props.mUserFiles">
                                        <a :href="'../../../../../../storage/files/'+item" target="_blank">
                                            <span class="clickable text-blue">
                                                {{ item }}
                                            </span>
                                        </a>

                                    </li>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
           
            <div class="border shadow mt-3" v-if="props.case.status==true">

                <div class="p-3 bg-grey-8 text-h5 text-grey-1">
                    Grievance Reply
                </div>
                <div class="p-5" style="white-space:pre-line">
                    <div>
                        {{( props.case.remark )}}
                    </div>
                    <br>
                    <div class="mb-3">
                        <div v-if="$props.mNodalFiles !=null">  
                            <span v-if="$props.mNodalFiles.length!=0">Attachment:  
                                <li class="ml-4" v-for="(item,index) in $props.mNodalFiles">
                                    <a :href="'../../../../../../storage/files/'+item" target="_blank">
                                        <span class="clickable text-blue">
                                            {{ item }}
                                        </span>
                                    </a>

                                </li>
                            </span>
                        </div>
                    </div>
                    Date: {{ date.formatDate(props.case.date_of_action,'DD MMM YYYY, hh:mm A') }}
                    <div class="text-caption" v-if="props.grievance.update_date_of_final_remark!=null">
                        Edited {{ date.formatDate(props.grievance.update_date_of_final_remark,'DD MMM YYYY, hh:mm A') }}
                    </div>
                    
                </div>
            </div>

            <div class="border shadow mt-3" v-if="props.case.status==true">
                <div class="p-3 bg-grey-8 text-h5 text-grey-1">
                    Officer Details
                </div>
                <div class="p-3" style="white-space:pre-line">
                    
                    <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Officer Name
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.officer_name}}
                            </div>
                    </div><hr>
                    <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Designation
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.officer_designation}}
                            </div>
                    </div><hr>
                    <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Phone
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.officer_mobile}}
                            </div>
                    </div><hr>
                    <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Email ID
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                {{ props.grievance.officer_email}}
                            </div>
                    </div><hr>

                        
                 </div>
            </div>

            <div v-if="props.grievance.applicant_feedback!=null" class="mt-3 border shadow">
                <div>
                    <div class="row p-3 bg-grey-8  text-h5 text-grey-1">
                        Feedback
                         
                    </div>
                    <div class="p-5" style="white-space:pre-line">
                        Comments: {{ props.grievance.applicant_feedback}}
                        <br>
                        Rating: <span v-if="props.grievance.applicant_rating==1">
                                    Poor
                                </span>
                                <span v-else-if="props.grievance.applicant_rating==2">
                                    Average
                                </span>
                                <span v-else-if="props.grievance.applicant_rating==3">
                                    Good
                                </span>
                                <span v-else-if="props.grievance.applicant_rating==4">
                                    Very Good
                                </span>
                                <span v-else-if="props.grievance.applicant_rating==5">
                                    Excellent
                                </span>
                    </div>
                </div>
            </div>


            <div class="border shadow mt-5">
                <div class="p-3 bg-green-4 text-h5">
                    Grievance Movement
                </div>

                <div>
                    <div class="q-pa-md">
                        <q-table
                        :rows="props.grievance.grievance_movement"
                        :columns="columns"
                        table-header-class="bg-grey-2"
                        row-key="name"
                        flat bordered
                        wrap-cells
                        >
                        <template v-slot:body-cell-id="props">
                            <q-td key="id" :props="props">
                                {{ props.rowIndex+1 }}
                            </q-td>
                        </template>

                        <template v-slot:body-cell-action="props">
                            <q-td :props="props">
                               
                                <div v-if="props.row.from_type=='App\\Models\\SubDepartment'">
                                    <div v-if="props.row.action_id==2">
                                        TAKE UP WITH SUBORDINATE ORGANIZATION
                                    </div>
                                    <div v-else>
                                        {{ props.row.action.label }}
                                    </div>
                                </div>
                                <div v-else-if="props.row.is_duplicate==true">
                                    TRANSFERRED
                                </div>
                                <div v-else>
                                    {{ props.row.action.label }}
                                </div>
                             
                            </q-td>
                        </template>

                        <template v-slot:body-cell-action_taken_by="props">
                            <q-td key="id" :props="props">
                                <span v-if="props.row.officer_name!=null">
                                    {{ props.row.officer_name }}, {{props.row.officer_designation }}, Ph:{{props.row.officer_mobile }}
                                </span>
                                <span v-if=" props.row.action_id==9 || props.row.action_id==8|| props.row.action_id==6">
                                    {{ props.row.from.name }}
                                </span>
                                    
                            </q-td>
                        </template>
                        
                        <template v-slot:body-cell-from="props">
                            <q-td key="id" :props="props">
                                <div>{{ props.row.from_type==='App\\Models\\User'?props.row.from.name : props.row.from.organization_name }}</div>
                            </q-td>
                        </template>
                        
                        <template v-slot:body-cell-to="props">
                            <q-td key="id" :props="props">
                                <div>{{ props.row.to_type==='App\\Models\\User'?props.row.to.name : props.row.to.organization_name }}</div>
                            </q-td>
                        </template>

                        <template v-slot:body-cell-remark="props">
                            <q-td key="id" :props="props">
                                <div v-if="props.row.action_id==2">
                                    <div v-if="props.row.from_type=='App\\Models\\SubDepartment' ">
                                        <div v-if="props.row.action_id==2">
                                            -
                                        </div>
                                        <div v-else>
                                            {{ props.row.action.label }}
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div v-if="props.row.from_type!='App\Models\SubDepartment'">
                                            <q-btn
                                        color="primary"
                                        label="View Remark"
                                        no-caps
                                        @click="moreDialogClick(props.row)"
                                        />
                                        </div>
                                    </div>

                                    
                                    
                                </div>
                                <div v-else>
                                     -
                                </div>
                            </q-td>
                        </template>
                        </q-table>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <div class="q-gutter-sm">
                  
                        <q-btn color="primary" icon="home" onclick="history.back();return false;" label="Back To Home Page"/>
                   
                        <q-btn color="primary" icon="print" label="Print" @click="printClicked(props.grievance.id)"/>
                    

                    <!-- action_id=7=CLOSED -->
                         <q-btn  v-if="props.grievance.applicant_feedback==null && grievance.action_id===7" color="amber-8" icon="reviews" label="Feedback" @click="fixed=true"/>

                 </div>
            </div>
        </div>
    </div>

    <!-- More Dialog Start-->

    <q-dialog v-model="moreDialog" transition-show="scale" transition-hide="scale">
      <q-card >
        <q-card-section class="bg-light-green text-white mb-3">
          <div class="text-h6">Remark</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
            <div class="mb-3" style="white-space:pre-line">
                {{ mRow.remark }}
            </div>
            <div v-if="mRow.nodal_attachment">
                
                Attachment(s):
                <li class="ml-4" v-for="item in stringToArray(mRow.nodal_attachment)">
                    <a :href="'../../../../../../storage/files/'+item" target="_blank">
                        <span class="clickable text-blue">
                            {{ item }}
                        </span>
                    </a>
                </li>
            </div>
        </q-card-section>

        <q-card-actions align="right" class="bg-white text-teal">
          <q-btn flat label="OK" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
    <!-- More Dialog End -->

<!-- FEEDBACK -->
    <q-dialog v-model="fixed" persistent>
      <q-card style="width: 700px; max-width: 80vw;">
        <q-card-section>
          <div class="text-h6 full-width text-center">How satisfied are you?</div>
        </q-card-section>

        <q-separator />

        <q-card-section style="max-height: 50vh" class="scroll">
            <p>
                <div class="row">
                    <div class="col-6 text-right pr-4">
                        Registration Number
                    </div>
                    <div class="col-6 text-bold">
                        {{grievance.registration_number}}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 text-right pr-4">
                        Rating
                    </div>
                    <div class="col-6">
                        <q-select 
                            outlined
                            :dense="true"
                            v-model="form.category" 
                            :options="category" 
                            :error="!!form.errors.category"
                            :error-message="form.errors.category"
                            label="-- Select category --"
                        />

                    </div>
                </div>
 
                <div v-if="form.category.value==1" class="row text-blue-8">
                    <div class="col-9 text-right">
                        note: 'Poor' select chiah hian a Appeal theih
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 text-right pr-4">
                        Comments
                    </div>
                    <div class="col-6">
                        <q-input 
                        outlined
                        type="textarea"
                        v-model="form.feedback" 

                        />
                    </div>
                </div>
                <div class="row mt-5">
                  <div class="col-6">

                  </div>
                  <div class="col-6">
                    <q-btn color="primary" icon="save" label="Submit" @click="feedbackSubmitClick"/>
                  </div>
                </div>
            </p>
        </q-card-section>

        <q-separator />

        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

     <!-- EDIT DESCRIPTION DIALOG -->
     <q-dialog v-model="dialogEditDescription"  >
        <q-card  >
        <q-card-section class="bg-blue-grey-9 text-white mb-3">
            EDIT GRIEVANCE
        </q-card-section>
            <q-card-section class="q-pt-none">
                <q-input
                    
                    v-model="grievance.grievance_description"
                    type='textarea' 
                    class="border p-1 mb-3" 
                    rows="5"
                    style="width:590px"
                   />

                    <!-- NEW FROM HOME -->
                    <div class="mb-3" v-if="$props.mNodalFiles !=null">  
                        <span>Attachment:
                            <li class="ml-4 mb-4" v-for="(item,index) in $props.mUserFiles">
                                <a  :href="'../../../../../../storage/files/'+item" target="_blank">
                                    <span class="clickable text-blue">
                                        {{ item }}
                                    </span>
                                </a>
                                <span @click="openConfirmationDialog(index)"   class="ml-5 text-caption clickable cursor-pointer">remove</span>
                            </li>
                        </span>
                    </div>
                   
                    <q-file
                        name="xfile"
                        v-model="form2.editGrievanceFiles"
                        label="Select to upload attachment"
                        outlined
                        use-chips
                        multiple
                        style="max-width: 300px;"
                        accept="image/jpeg,/image/jpg,image/png,.pdf"
                        max-files="10"
                        append
                        @rejected="onRejected"
                        class="mb-2"
                    />

            </q-card-section>
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn flat label="Update" @click="grievanceUpdate(grievance)" v-close-popup />
                <q-btn flat label="Cancel"   v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

     <!-- NEW FROM HOME -->
     <q-dialog v-model="attacmentDeleteConfirmationDialog">
        <q-card>
            <q-card-section class="row items-center">
                <span class="q-ml-sm">Are you sure to delete?</span>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancel" color="primary" v-close-popup />
                <q-btn @click="editFinalReplyAttachmentRemoveClick(index)" flat label="Delete" color="primary" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
    <!-- NEW FROM HOME ENDING-->
</template>

<script setup>
import { ref} from 'vue'
import { Head,router,useForm,usePage } from '@inertiajs/vue3';
import { date, useQuasar } from 'quasar';
import { onMounted,computed } from 'vue';

const file = ref(null); // To store the selected file
const prepopulatedFile = 'https://example.com/path/to/prepopulated/file.jpg'; // URL of the prepopulated file

const page = usePage()
const q = useQuasar()

const CURRENT_USER = computed(() => page.props.CURRENT_USER)

 const dialogEditDescription = ref(false)
 const basic = ref(false)
 const fixed = ref(false)
 const readMoreButton = ref(true)
 const readMoreReadLessText = ref('')

 const attacmentDeleteConfirmationDialog = ref(false)
 const editRemovedFiles = ref(null)
 const currentIndexOfAttachmentRemove = ref(null)

 let readMoreCounter = 0

 let form=useForm({
    category:'',
    feedback:'',
    grievance_id:props.grievance.id
 })
 let moreDialog = ref(false)
 let mRow=''

 const category=[
    {value: 1, label:'Poor'},
    {value: 2, label:'Average'},
    {value: 3, label:'Good'},
    {value: 4, label:'Very Good'},
    {value: 5, label:'Excellent'},
  ]

const props = defineProps([
    'grievance',
    'case',
    'mUserFiles',
    'mNodalFiles',
    'EDITING_HOURS_FOR_CITIZEN'
])
//const xfile = props.grievance.grievance_attachment?props.grievance.grievance_attachment.split(","):''


const feedbackSubmitClick=()=>{
    form.post('/grievance/citizen/feedback',{
        onStart:()=>q.loading.show({
            message: "Loading..."
        }),
        onFinish:()=>{
            q.loading.hide()
        }
    });

}

const printClicked=(id)=>{
    console.log(id)
     
    window.open('/grievance/print/'+id,'_blank')

}

const columns =  [
    {name:'id', align:'left', label:'Sl No', field:'id'},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'date_of_action', align:'left', label:'Date of Action', field:'date_of_action',format:val=>date.formatDate(val,'DD MMM YYYY, hh:mm A')},
    {name:'action', align:'left', label:'Department Action', field:'action',format:val=>val.label},
    {name:'action_taken_by', align:'left', label:'Action Taken By', field:'id'},
    {name:'from', align:'left', label:'From', field:'from_id'},
    {name:'to', align:'left', label:'To', field:'to_id'},
    {name:'remark',align:'left', label: 'Remark',field:'id'}
]
const moreDialogClick=(row)=>{
    mRow = row
    moreDialog.value = true
}

onMounted(()=>{
    if(props.grievance.grievance_description.length>330){
        props.grievance.grievance_description_modify = props.grievance.grievance_description.slice(0,330)+'...' 
        readMoreReadLessText.value = 'Read More'
    }else{
        props.grievance.grievance_description_modify = props.grievance.grievance_description 

    }
})

 const readMoreButtonClick=()=>{
    readMoreCounter++;
    console.log(readMoreCounter%2);

    if(readMoreCounter%2){
        //Read More function tur
        readMoreReadLessText.value = 'Read Less'
        props.grievance.grievance_description_modify = props.grievance.grievance_description
    }else{
        //Read Less function tur

        readMoreReadLessText.value = 'Read More'
        props.grievance.grievance_description_modify = props.grievance.grievance_description.slice(0,330)+'...' 
    }
 }

 let form2 = useForm({
    grievance_id:'',
    grievance_description:'',
    editGrievanceFiles:[],

 })

 const grievanceUpdate=(grievance)=>{
    form2.transform(data=>({
        grievance_id:grievance.id,
        grievance_description : grievance.grievance_description,
        mUserFiles:props.mUserFiles,
        editGrievanceFiles:form2.editGrievanceFiles,
        editRemovedFiles:editRemovedFiles,


    })).post('/grievance/citizen/update',{
        onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{q.loading.hide()},
        onSuccess:()=> {
            q.notify({
                message: 'Grievance Update Successfully',
                icon:'check',
                iconColor:'blue'
            });
        }
    })
 }


 //<!-- NEW FROM HOME -->
 const editFinalReplyAttachmentRemoveClick=()=>{
    console.log(currentIndexOfAttachmentRemove.value)
    //PUT CONFIRMATION DIALOG
     props.mUserFiles.splice(currentIndexOfAttachmentRemove.value,1)
     editRemovedFiles.push(props.mNodalFiles(currentIndexOfAttachmentRemove.value))
 }
// <!-- NEW FROM HOME -->
 const openConfirmationDialog=(index)=> {
    //console.log(index)
    attacmentDeleteConfirmationDialog.value=true
    currentIndexOfAttachmentRemove.value=index
 }


const stringToArray=(param)=>{
    return param.split(",")
}
</script>
 
<style>
   .clickable:hover{
        color: blue;
    }
</style> 