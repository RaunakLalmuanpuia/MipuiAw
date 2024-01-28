<template>
        <Head title="Show Grievance" />
 
    <div>
        <div class="m-5">
            <div v-if="props.fromReport">
                
                    <Link class="full-width border" :href="route('report.singleDepartment',props.grievance.department_id)" >
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
            </div>
            <div class="mb-3" v-else-if="CURRENT_USER.role_id==1 ||CURRENT_USER.role_id==2">
                <i class="q-icon material-icons-outlined">arrow_back</i>
                <a href="javascript:history.back()">Go Back</a>
            </div>
            <div v-else>
                <div class="mb-2">
                    <i class="q-icon material-icons-outlined">arrow_back</i>
                    <a href="javascript:history.back()">Go Back</a>
                </div>
            </div>
            
            <div class="border shadow">
                <div class="row p-3 bg-grey-4 text-h5 ">
                    <div :class="$q.screen.xs ? 'col-12':'col-5'">
                        Grievance Details
                    </div>

                    
                    <div :class="$q.screen.xs ? 'col-12 mt1':'col-5'">
                        <q-btn label="Action History" color="primary" @click="actionHistoryClick" />
                    </div>
                    <div :class="$q.screen.xs ? 'col-12 mt-1':'col-2'">
                        <q-btn color="primary" icon="print" label="Print" @click="printClicked(props.grievance.id)"/>
                    </div>
                </div>

                <div>
                    <div class="p-5">
                        
                        <div v-show="props.grievance.action_id==7 && CURRENT_USER.role_id==4  && !props.from_closed_page ">    
                            <q-btn color="primary" @click="moveToClosedClick()" label="Move to Closed">
                                <q-tooltip>
                                    To move the closed grievance from pending list
                                </q-tooltip>
                            </q-btn>
                        </div>

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
                                Date of receipt
                            </div>
                            <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                 {{ date.formatDate(props.grievance.date_of_receipt,'DD MMM YYYY, hh:mm A') }}
                            </div>
                        </div>
                        <hr>
                        <div class="row m-3">
                            <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                Residential Address
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
                            <div :class="$q.screen.xs ? 'col-12':'col-8'" style="white-space:pre-line">
                                {{ props.grievance.grievance_description_modify}}
                                <div v-if="readMoreButton" v-on:click="readMoreButtonClick" class="text-blue-8 underline italics">
                                    <a href="#">{{ readMoreReadLessText }}</a>
                                </div>

                                <div v-if="grievance.update_date_of_receipt!=null" class="text-end text-caption" >
                                      <em>  Edited {{  date.formatDate(props.grievance.update_date_of_receipt,'DD MMM YYYY, hh:mm A')}}</em>
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
                    </div>
                </div>
            </div>
            
            <div v-if="props.case.status==true" class="mt-3 border shadow">
                <div >
                    <div class="p-3 bg-grey-8 text-h5 text-grey-1">
                       Grievance Reply
                    </div>
                    <div class="p-5" style="white-space:pre-line">
                        <div class="mb-3">
                            {{ props.case.remark}}
                        </div>
                        <div>
                            <div v-if="$props.mNodalFiles.length != 0">  
                                <span>Attachment:
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
                        <br>
                        Date: {{ date.formatDate(props.case.date_of_action,'DD MMM YYYY, hh:mm A') }}
                        
                        <div v-if="props.grievance.update_date_of_final_remark!=null">
                        Edited : {{ date.formatDate(props.grievance.update_date_of_final_remark,'DD MMM YYYY, hh:mm A') }}
                        </div>
                        <div v-if="props.answerEdit" class="mt-5">
                            <i>Can be edit within {{ EDITING_HOURS }} hrs of answer</i> 
                            <br>

                            <q-btn @click="dialogEditAnswer=true"  class="bg-blue-7 text-white rounded py-2 px-4 hover:bg-green-5">
                                Edit
                            </q-btn>
                        </div>
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
                    <div class="p-3 bg-grey-8 text-h5 text-grey-1">
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

            <div v-if="grievance.is_appeal" class="mt-3 border shadow">
                <hr>
                <div>
                    <div class="p-3 bg-orange-8 text-h5 text-grey-1">
                        Appeal Question
                    </div>
                    <div class="p-5" style="white-space:pre-line">
                        Question: {{ grievance.appealQuestion }}
                        <div class="text-caption">
                            Date: {{ date.formatDate(grievance.appealQuestionDate,'DD MMM YYYY, hh:mm A') }}
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="grievance.appealReply!=null" class="mt-3 border shadow">
                <hr>
                <div>
                    <div class="p-3 bg-orange-10 text-h5 text-grey-1">
                        Appeal Reply
                    </div>
                    <div class="p-5" style="white-space:pre-line">
                         {{ grievance.appealReply }}

                        
                         
                         <div v-if="$props.grievance.daaAttachment.length !=0">  
                            <span>Attachment:
                                <li class="ml-4" v-for="(item,index) in $props.grievance.daaAttachment">
                                    <a :href="'../../../../../../storage/files/'+item" target="_blank">
                                        <span class="clickable text-blue">
                                            {{ item }}
                                        </span>
                                    </a>
                                </li>
                            </span>
                        </div> 
                        <div class="text-caption">
                            Date: {{ date.formatDate(grievance.appealReplyDate,'DD MMM YYYY, hh:mm A') }}
                        </div>

                        <!-- <div v-if="props.grievance.update_date_of_final_remark!=null">
                        Edited : {{ date.formatDate(props.grievance.update_date_of_final_remark,'DD MMM YYYY, hh:mm A') }}
                        </div> -->

                        <div v-if="props.answerEditByAppellate" class="mt-5">
                            <i>Can be edit within {{ EDITING_HOURS }} hrs of answer</i> 
                            <br>

                            <q-btn @click="dialogEditAnswerByAppellate=true"  class="bg-blue-7 text-white rounded py-2 px-4 hover:bg-green-5">
                                Edit
                            </q-btn>
                        </div>

                        
                        <br>
                        <div>
                            Officer Name: {{ grievance.officer_name_daa }}
                        </div>
                        <div>
                            Officer Designation: {{ grievance.officer_designation_daa }}
                        </div>
                        <div>
                            Officer Phone: {{ grievance.officer_mobile_daa }}
                        </div>
                        <div>
                            Officer Email: {{ grievance.officer_email_daa }}
                        </div>
                    </div>
                </div>
            </div>
          
            <div v-if="x_message" class="bg-red-2 border-red-9 mt-5 p-4   border-2" >
                <div class="text-red-9 text-h6 text-bold">
                    WARNING!
                </div>
                <div class="text-grey-9" v-html="x_message"></div>
                

            </div>
            
             <div v-if="props.grievance.action_id!=7 || props.showAction" >
              
                <div v-if="props.grievance.action_id!=5">
                    <div > 
                        <!-- v-if="!props.isMarkedClosedBySub" -->
                        <div v-if="props.showAction">
                            <!-- STATUS_IS 7 = CLOSED -->
                            
                            <div v-if = "subCanClose || iAmSubDepartment">

                                <div v-if="grievance.is_appeal==false || currentRole==6"  class="mt-5 border shadow">

                                    <div class="p-3 bg-blue-9 text-h5 text-white">
                                        Grievance Action
                                    </div>
                                    <div>
                                        <div class="m-3">
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
                                                    Action
                                                </div>
                                                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                    <q-select 
                                                        v-model="form.action" 
                                                        :options="options" 
                                                        label="-- Select an Action --"
                                                    />
                                                </div>
                                            </div>

                                            <!-- NO ACTION REQUIRED = 1 -->
                                            <div v-if="form.action.value==1 || form.action.value==11">
                                                <div class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Grievance Category (optional)
                                                    </div>
                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-select 
                                                            v-model="form.category" 
                                                            :options="classification" 
                                                            label="-- Select Category --"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="row  m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Remarks
                                                    </div>

                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-input type='textarea' class="border p-3" id="remark" v-model="form.remark" rows="5"/>
                                                        <div v-if="form.errors.remark" v-text="form.errors.remark" class="text-red-500 text-xs mt-3"></div>
                                                    </div>
                                                    
                                                </div>
                                                <div v-if="CURRENT_USER.role_id===4" class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Mark as closed
                                                    </div>

                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-checkbox v-model="form.mark_as_closed_for_no_action" disable/> (Auto closed on "no action required" on sub organization side)
                                                    </div>
                                                </div>

                                                <div class="row m-3 mb-5 justify-end">
                                                    <!-- <button @click="noActionRequiredClick"  class="bg-blue-7 text-white rounded py-2 px-4 hover:bg-green-5">
                                                        Submit
                                                    </button> -->
                                                    <button @click="noActionRequiredModal=true"  class="bg-blue-7 text-white rounded py-2 px-4 hover:bg-green-5">
                                                        Submit
                                                    </button>
                                                </div>
                                        </div>

                                        <!-- EXAMINE AT OUR LEVEL = 2 -->
                                        <div v-if="form.action.value==2  || form.action.value==12">
                                                <div class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Grievance Category (optional)
                                                    </div>
                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-select 
                                                            v-model="form.category" 
                                                            :options="classification" 
                                                            label="-- Select Category --"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="row  m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Remarks
                                                    </div>

                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-input type='textarea' class="border p-3" id="remark" v-model="form.remark" rows="5"/>
                                                        <div v-if="form.errors.remark" v-text="form.errors.remark" class="text-red-500 text-xs mt-3"></div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Attachment
                                                    </div>
                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">

                                                        <q-file
                                                            v-model="form.files"
                                                            label="Attachment"
                                                            outlined
                                                            use-chips
                                                            multiple
                                                            style="max-width: 300px;"
                                                            accept=".jpg,.jpeg,.png,.gif,.pdf"
                                                            append
                                                            max-files="10"
                                                            @rejected="onRejected"
                                                        />
                                                        <span class="text-caption">Maximum 8 files. Supported file: jpg, png and pdf. Max total size 8 mb</span>

                                                    </div>
                                                </div>
                                                <div v-if="CURRENT_USER.role_id===4" class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Mark as closed
                                                    </div>

                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-checkbox v-model="form.mark_as_closed_for_examine" />
                                                    </div>
                                                </div>

                                                <div class="row m-3 mb-5 justify-end">
                                                    <button @click="examineAtOurLevelModal=true"  class="bg-blue-7 text-white rounded py-2 px-4 hover:bg-green-5">
                                                        Submit
                                                    </button>
                                                </div>
                                        </div>

                                        <!-- TAKE UP WITH SUBORDINATE ORGANIZATION = 3 -->
                                        <div v-if="form.action.value==3">
                                                <div class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Grievance Category (optional)
                                                    </div>
                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-select 
                                                            v-model="form.category" 
                                                            :options="classification" 
                                                            label="-- Select category --"
                                                        />
                                                    </div>
                                                </div>

                                                <div class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                    <div>Subordinate Office(s)</div> 
                                                        <div class="text-caption text-green">Maximum 5 can be selected</div>
                                                    </div>
                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-select 
                                                            filled
                                                            multiple
                                                            use-chips
                                                            stack-label
                                                            v-model="form.subDepartment" 
                                                            :options="subDepartment" 
                                                            label="-- Select sub Organization --"
                                                            @update:model-value="subDepartmentSelect"
                                                        />
                                                        <div v-if="form.errors.subDepartment" v-text="form.errors.subDepartment" class="text-red-500 text-xs mt-3"></div>

                                                    </div>
                                                </div>

                                                <div class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">

                                                    </div>
                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-checkbox 
                                                            v-model="form.subDepartmentCanCloseCheckBox" 
                                                            label="Sub Organization can close the case" 
                                                            
                                                            :disable="isCheckBoxDisabled"
                                                            />
                                                    </div>
                                                </div>
                                                <div class="row m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Maximum Day(s) 
                                                        <div class="text-caption">Time frame for answering</div>
                                                    </div>
                                                    <div class="row" :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-input
                                                            style="width:120px"
                                                            name="mobile"
                                                            mask="###"
                                                            :rules="[val => val.length <= 3 || 'Must be less than 3 digits']"
                                                            maxlength="3"
                                                            v-model="form.maximumDaysDefine"
                                                            :error="!form.errors.maximumDaysDefine===false"
                                                            :error-message="form.errors.maximumDaysDefine"
                                                            >
                                                        </q-input>
                                                        
                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class="row  m-3">
                                                    <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                        Remarks
                                                    </div>
                                                    <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                        <q-input type='textarea' class="border px-3" id="remark" v-model="form.remark" rows="5"/>
                                                        <div v-if="form.errors.remark" v-text="form.errors.remark" class="text-red-500 text-xs mt-3"></div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row m-3 mb-5 justify-end">
                                                    <button @click="takeUpWithSubDepartmentModal=true"  class="bg-blue-7 text-white rounded py-2 px-4 hover:bg-green-5">
                                                        Submit
                                                    </button>

                                                </div>
                                        </div>
                                        <!-- END -->
                                            
                                        <!-- CASE DISPOSE OF = 4 -->
                                        <div v-if="form.action.value==4">
                                            <div class="row m-3">
                                                <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                    Grievance Category (optional)
                                                </div>
                                                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                    <q-select 
                                                        v-model="form.category" 
                                                        :options="classification" 
                                                        label="-- Select category --"
                                                    />
                                                </div>
                                            </div>

                                            <!-- <div class="row m-3">
                                                <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                    Resolution Type 
                                                </div>
                                                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                    <q-select 
                                                        stack-label
                                                        v-model="form.resolutionType" 
                                                        :options="resolutionType" 
                                                        label="-- Select Resolution Type --"
                                                    />
                                                </div>
                                            </div> -->

                                            <div class="row  m-3">
                                                <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                    Remarks
                                                </div>
                                                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                    <q-input type='textarea' class="border p-3" id="remark" v-model="form.remark" rows="5"/>
                                                    <div v-if="form.errors.remark" v-text="form.errors.remark" class="text-red-500 text-xs mt-3"></div>
                                                </div>
                                            </div>

                                            <div class="row m-3">
                                                <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                    Attachment
                                                </div>
                                                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                    <q-file
                                                        v-model="form.files"
                                                        label="Attachment"
                                                        outlined
                                                        use-chips
                                                        multiple
                                                        style="max-width: 300px;"
                                                        accept=".jpg,.jpeg,.png,.gif,.pdf"
                                                        append
                                                        
                                                        max-files="10"
                                                        @rejected="onRejected"
                                                    />
                                                    <span class="text-caption">Maximum 8 files. Supported file: jpg, png and pdf. Max total size 8 mb</span>

                                                </div>
                                            </div>

                                            <div class="row m-3 mb-5 justify-end">
                                                <button @click="caseDisposeOfModal=true"  class="bg-blue-7 text-white rounded py-2 px-4 hover:bg-green-5">
                                                    Submit
                                                </button>

                                            </div>
                                        </div>
                                        <!-- END -->

                                        <!-- TRANSFER TO OTHER DEPARTMENT = 5 -->
                                        <div v-if="form.action.value==5">
                                            <div class="row m-3">
                                                <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                    Grievance Category (optional)
                                                </div>
                                                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                    <q-select 
                                                        v-model="form.category" 
                                                        :options="classification" 
                                                        label="-- Select category --"
                                                    />
                                                </div>
                                            </div>

                                            <div class="row m-3">
                                                <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                    Department
                                                </div>
                                                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                    <q-select 
                                                        stack-label
                                                        v-model="form.department" 
                                                        :options="department" 
                                                        label="-- Select Department --"
                                                        @filter="filterFn"
                                                        use-input
                                                    />
                                                    <div v-if="form.errors.department" v-text="form.errors.department" class="text-red-500 text-xs mt-3"></div>

                                                </div>
                                            </div>

                                            <div class="row  m-3">
                                                <div :class="$q.screen.xs ? 'col-12':'col-4'">
                                                    Remarks
                                                </div>
                                                <div :class="$q.screen.xs ? 'col-12':'col-8'">
                                                    <q-input type='textarea' class="border p-3" id="remark" v-model="form.remark" rows="5"/>
                                                    <div v-if="form.errors.remark" v-text="form.errors.remark" class="text-red-500 text-xs mt-3"></div>
                                                </div>
                                                
                                            </div>
                                            <div class="row m-3 mb-5 justify-end">
                                                <button @click="transferToAnotherDepartmentModal=true"  class="bg-blue-7 text-white rounded py-2 px-4 hover:bg-green-5">
                                                    Submit
                                                </button>

                                            </div>
                                        </div>
                                        <!-- END -->


                                        <div v-if="x_message" class="bg-red-2 border-red-9 mt-5 p-4   border-2" >
                                            <div class="text-red-9 text-h6 text-bold">
                                                WARNING!
                                            </div>
                                            <div class="text-grey-9" v-html="x_message"></div>
                                            

                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- DIALOGS -->
<q-dialog v-model="noActionRequiredModal">
    <q-card>
        <q-card-section class="row items-center">
        <q-avatar icon="done" color="primary" text-color="white" />
        <span class="q-ml-sm">Are you sure you want to submit?</span>
        </q-card-section>

        <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" v-close-popup />
        <q-btn flat label="Submit"  @click="noActionRequiredClick" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>

<q-dialog v-model="examineAtOurLevelModal">
    <q-card>
        <q-card-section class="row items-center">
        <q-avatar icon="done" color="primary" text-color="white" />
        <span class="q-ml-sm">Are you sure you want to submit?</span>
        </q-card-section>

        <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" v-close-popup />
        <q-btn flat label="Submit"  @click="examineAtOurLevelClick" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>

<q-dialog v-model="takeUpWithSubDepartmentModal">
    <q-card>
        <q-card-section class="row items-center">
        <q-avatar icon="done" color="primary" text-color="white" />
        <span class="q-ml-sm">Are you sure you want to submit?</span>
        </q-card-section>

        <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" v-close-popup />
        <q-btn flat label="Submit"  @click="takeUpWithSubDepartmentClick" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>

<q-dialog v-model="caseDisposeOfModal">
    <q-card>
        <q-card-section class="row items-center">
        <q-avatar icon="done" color="primary" text-color="white" />
        <span class="q-ml-sm">Are you sure you want to submit?</span>
        </q-card-section>

        <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" v-close-popup />
        <q-btn flat label="Submit"  @click="caseDisposeOfClick" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>


<q-dialog v-model="transferToAnotherDepartmentModal">
    <q-card>
        <q-card-section class="row items-center">
        <q-avatar icon="done" color="primary" text-color="white" />
        <span class="q-ml-sm">Are you sure you want to submit?</span>
        </q-card-section>

        <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" v-close-popup />
        <q-btn flat label="Submit"  @click="transferToAnotherDepartmentClick" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>


<!-- DIALOGS END -->


        
<!-- MOVEMENT HISTORY -->
    <q-dialog
        v-model="movement"
        full-width
        >
        <q-card >
            <!-- <q-card-section>
            <div class="text-h6">Howdy!</div>
            </q-card-section> -->

            <q-card-section class="q-pt-none">
                <div class="border shadow mt-5">
                   
                    <div>
                        <div class="p-3 bg-green-4 text-h5">
                        Grievance Movement
                    </div>

                        <div class="q-pa-md">
                            <q-table
                            :rows="props.grievance.grievance_movement"
                            :rows-per-page-options="[8,20,50,100]"       
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

                            <template v-slot:body-cell-date_of_action="props">
                                <q-td key="id" :props="props">
                                    {{ date.formatDate(props.row.date_of_action,'DD MMM YYYY, hh:mm A') }}
                                    <div v-if="props.row.update_date_of_action!=null" class="text-caption">Edited {{date.formatDate(props.row.update_date_of_action,'DD MMM YYYY, hh:mm A')}} </div>
                                </q-td>
                            </template>
                            <!-- start -->
                            <template v-slot:body-cell-action_taken_by="props">
                                <q-td key="id" :props="props">
                                    <span v-if="props.row.officer_name!=null">
                                        {{ props.row.officer_name }}, {{props.row.officer_designation }}, Ph:{{props.row.officer_mobile }}
                                    </span>
                                    <span v-if=" props.row.action_id==9 || props.row.action_id==8|| props.row.action_id==6">
                                        <span v-if="props.row.from">
                                            {{ props.row.from.name??'' }}
                                        </span>
                                        <span v-else>
                                            <i class="text-red-7">user deleted</i>
                                        </span>
                                    </span>

                                </q-td>
                            </template>
          

                            <template v-slot:body-cell-from="props">
                                <q-td key="id" :props="props"> 
                                    <span v-if="props.row.from!=null">
                                        <span>{{ props.row.from_type==='App\\Models\\User'?props.row.from.name : props.row.from.organization_name }}</span>
                                    </span>
                                    <span v-else>
                                            - null -
                                    </span>
                                </q-td>

                            </template>
                            <template v-slot:body-cell-to="props">
                                <q-td key="id" :props="props">
                                    <span v-if="props.row.to!=null">
                                        <div>{{ props.row.to_type==='App\\Models\\User'?props.row.to.name : props.row.to.organization_name }}</div>
                                    </span>
                                    <span v-else>
                                            - null -
                                    </span>
                                </q-td>
                            </template>

                            <template v-slot:body-cell-remark="props">
                                <q-td :props="props">
                                    <span  v-if="props.row.remark!=null && props.row.is_duplicate!=true">
                                        <q-btn
                                        color="primary"
                                        label="View Remark"
                                        style="width: 120px;"
                                        no-caps
                                        @click="secondDialogClick(props.row)"
                                    />
                                    </span>
                                    <span v-else-if="props.row.to_type=='App\\Models\\Department' && props.row.to_id==CURRENT_USER.department_id">
                                        <q-btn
                                        color="primary"
                                        label="View Remark"
                                        style="width: 120px;"
                                        no-caps
                                        @click="secondDialogClick(props.row)"
                                    />
                                    </span>
                                    
                                    <span v-else>
                                        -
                                    </span>

                                    <div v-if="props.row.replyEdit" class="clickable cursor-pointer">   
                                        <div v-if="CURRENT_USER.id == props.row.action_taken_by_id">
                                            <span @click="movementEditRemarks(props.row,props.rowIndex)"> 
                                                
                                                <span class="text-caption">Edit</span> 
                                                <q-tooltip>
                                                    Can be edit within {{ EDITING_HOURS }} hrs of reply
                                                </q-tooltip>
                                            </span>
                                        </div>
                                    </div> 
                                </q-td>
                            </template>   
                            

                            <!-- end -->
                            <template v-slot:body-cell-maximum_days="props" >
                                <q-td :props="props">
                                    {{ props.row.maximum_days }}
                                    <div v-if="props.row.replyEdit && props.row.maximum_days!=null" class="clickable cursor-pointer">   
                                        <div v-if="CURRENT_USER.id == props.row.action_taken_by_id">
                                            <span @click="movementEditMaximumDays(props.row)"> 
                                                <span class="text-caption">Edit</span> 
                                                <q-tooltip>
                                                    Can be edit within {{ EDITING_HOURS }} hrs of reply
                                                </q-tooltip>
                                            </span>
                                        </div>
                                    </div> 
                                </q-td>


                            </template>
                            </q-table>
                        </div>
                    </div>
                </div>
            </q-card-section>

            <q-card-actions align="right" class="bg-white text-teal">
            <q-btn flat label="OK" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <!-- SECOND DIALOG -->
    <q-dialog v-model="secondDialog" 
        transition-show="scale" 
        transition-hide="scale"
        
        >
      <q-card >
        <q-card-section class="bg-light-green text-white mb-3">
          <div class="text-h6">Remark</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
            <div class="mb-3  " style="white-space:pre-line">
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

    <!-- EDIT DIALOG -->
    <q-dialog v-model="editDialog" transition-show="scale" transition-hide="scale">
      <q-card >
        <q-card-section class="bg-light-green text-white mb-3">
          <div class="text-h6">Edit</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
            <form @submit.prevent="submit" method="post">
                <div>
                    <q-input
                        name="editRemark"
                        type="textarea"
                        row="5"
                        v-model="editForm.remark"
                        :error="!editForm.errors.remark===false"
                        :error-message="editForm.errors.remark"
                        label="Edit Remark"
                        required
                        />
                </div>

                <div>
                    <q-file
                        v-model="editForm.files"
                        :files="prepopulatedFiles"
                        label="Attachment"
                        outlined
                        use-chips
                        multiple
                        style="max-width: 300px;"
                        accept=".jpg,.jpeg,.png,.gif,.pdf"
                        append
                        max-files="10"
                        @update:model-value="editForm.files"
                        
                    />
                </div>
            </form>
             
            <a :href="'../../../../../../storage/files/NODAL1688473220746.pdf'" class="text-blue underline" target="_blank">dd</a>

            <div v-if="mRow.nodal_attachment">
                
                Attachment(s):
                <li class="ml-4" v-for="item in stringToArray(mRow.nodal_attachment)">
                    <a :href="'../../../../../../storage/files/'+item" target="_blank">
                        <span class="clickable text-blue">
                            {{ item }}
                        </span>
                    </a>
                </li>
                <a :href="'../../../../../../storage/files/'+item" target="_blank"></a>
            </div>
        </q-card-section>

        <q-card-actions align="right" class="bg-white text-teal">
            <q-btn flat label="Cancel" color="black" v-close-popup />
            <q-btn flat label="Update" @click="updateClick" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog> 

    <!-- EDIT ANSWER DIALOG -->
    <q-dialog v-model="dialogEditAnswer"  >
        <q-card style="width:700px;" >
        <q-card-section class="bg-blue-grey-9 text-white mb-3">
             EDIT ANSWER
        </q-card-section>
            <q-card-section class="q-pt-none">
                <q-input
                        v-model="props.grievance.final_remark"
                        type="textarea"                
                    />
                <!-- NEW FROM HOME -->
                <div v-if="$props.mNodalFiles !=null">  
                    <span>Attachment:
                        <li class="ml-4 mb-4" v-for="(item,index) in $props.mNodalFiles">
                            <a :href="'../../../../../../storage/files/'+item" target="_blank">
                                <span class="clickable text-blue">
                                    {{ item }}
                                </span>
                            </a>
                            <span @click="openConfirmationDialog(index)"   class="ml-5 text-caption clickable cursor-pointer">remove</span>

                        </li>
                    </span>
                </div>

                <q-file
                    class="mt-5"
                    v-model="form2.editAnswerFiles"
                    label="Select file"
                    outlined
                    use-chips
                    multiple
                    accept=".jpg,.jpeg,.png,.gif,.pdf"
                    append
                    :files="fileAttachment"
                    style="max-width: 300px"
                />

            </q-card-section>
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn flat label="Update" @click="editAnswerUpdate()" v-close-popup />
                <q-btn flat label="Cancel"   v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
    
    <!-- EDIT ANSWER BY APPELLATE DIALOG -->
    <q-dialog v-model="dialogEditAnswerByAppellate"  >
        <q-card style="width:700px;" >
        <q-card-section class="bg-blue-grey-9 text-white mb-3">
             EDIT ANSWER BY APPELLATE
        </q-card-section>
            <q-card-section class="q-pt-none">
                <q-input
                        v-model="props.grievance.appealReply"
                        type="textarea"                
                    />

                <!-- NEW FROM HOME -->
                <div v-if="$props.grievance.daaAttachment !=null">  
                    <span>Attachment:
                        <li class="ml-4 mb-4" v-for="(item,index) in $props.grievance.daaAttachment">
                            <a :href="'../../../../../../storage/files/'+item" target="_blank">
                                <span class="clickable text-blue">
                                    {{ item }}
                                </span>
                            </a>
                            <span @click="openConfirmationDialogByAppellate(index)"   class="ml-5 text-caption clickable cursor-pointer">remove</span>
                        </li>
                    </span>
                </div>

                <q-file
                    class="mt-5"
                    v-model="form5.editAnswerFiles"
                    label="Select file"
                    outlined
                    use-chips
                    multiple
                    accept=".jpg,.jpeg,.png,.gif,.pdf"
                    append
                    :files="fileAttachment"
                    style="max-width: 300px"
                />

            </q-card-section>
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn flat label="Update" @click="editAnswerUpdateByAppellate()" v-close-popup />
                <q-btn flat label="Cancel"   v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <!-- EDIT MOVEMENT ANSWER DIALOG -->
    <q-dialog v-model="dialogEditMovementAnswer"  >
            <q-card style="width:700px;" >
            <q-card-section class="bg-blue-grey-9 text-white mb-3">
                EDIT MOVEMENT
            </q-card-section>
                <q-card-section class="q-pt-none">
                    <q-input
                        v-model="mMovementRow.remark"
                        type="textarea"
                    />
                     
                    <div v-if="mMovementRow.nodal_attachment_array !=null">  
                        <span>Attachment(s):
                            <li class="ml-4 mb-4" v-for="(item,index) in mMovementRow.nodal_attachment_array">
                                <a :href="'../../../../../../storage/files/'+item" target="_blank">
                                    <span class="clickable text-blue">
                                        {{ item }}
                                    </span>
                                </a>
                                <span @click="openConfirmationMovementDialog(index)"   class="ml-5 text-caption clickable cursor-pointer">remove</span>
                            </li>
                        </span>
                    </div>

                    <q-file
                        class="mt-5"
                        v-model="form3.appendedFiles"
                        label="Select file"
                        outlined
                        use-chips
                        multiple
                        accept=".jpg,.jpeg,.png,.gif,.pdf"
                        append
                        :files="fileAttachment"
                        style="max-width: 300px"
                    />
                </q-card-section>
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn flat label="Update" @click="movementAnswerUpdate(mMovementRow)" v-close-popup />
                    <q-btn flat label="Cancel" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>

    <!-- EDIT MOVEMENT MAXIMUM DAYS DIALOG -->
    <q-dialog v-model="dialogEditMovementMaximumDays"  >
        <q-card  >
        <q-card-section class="bg-blue-grey-9 text-white mb-3">
            EDIT Maximum Days
        </q-card-section>
            <q-card-section class="q-pt-none">
                <q-input
                    
                    v-model="mMovementRow.maximum_days"
                    type="text"

                    style="width:120px"
                    mask="###"
                    :rules="[val => val.length <= 3 || 'Must be less than 3 digits']"
                    maxlength="3"
                    
                    :error="!form.errors.grievance_movement_maximum_days===false"
                    :error-message="form.errors.grievance_movement_maximum_days"
                />
                
            </q-card-section>
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn flat label="Update" @click="movementDaysUpdate(mMovementRow)" v-close-popup />
                <q-btn flat label="Cancel"   v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <!-- NEW FROM HOME -->
    <q-dialog v-model="attachmentDeleteConfirmationDialog">
        <q-card>
            <q-card-section class="row items-center">
                <span class="q-ml-sm">Are you sure to delete?</span>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancel" color="primary" v-close-popup />
                <q-btn @click="editFinalReplyAttachmentRemoveClick()" flat label="Delete" color="primary" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
    <!-- Confirmation of Appellate -->
    <q-dialog v-model="attachmentDeleteConfirmationDialogByAppellate">
        <q-card>
            <q-card-section class="row items-center">
                <span class="q-ml-sm">Are you sure to delete?</span>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancel" color="primary" v-close-popup />
                <q-btn @click="editFinalReplyAttachmentRemoveClickByAppellate()" flat label="Delete" color="primary" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <!-- NEW FROM HOME ENDING-->
    <!-- NEW FROM HOME -->
    <q-dialog v-model="attachmentDeleteConfirmationMovementDialog">
        <q-card>
            <q-card-section class="row items-center">
                <span class="q-ml-sm">Are you sure to delete?</span>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancel" color="primary" v-close-popup />
                <q-btn @click="editFinalReplyAttachmentMovementRemoveClick()" flat label="Delete" color="primary" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
    <!-- NEW FROM HOME ENDING-->
</template>

<script setup>
import { useForm,Head,router,usePage} from "@inertiajs/vue3";
import {ref,onMounted,computed} from 'vue';
import { date, useQuasar } from "quasar";

const page = usePage()
const q = useQuasar()

const CURRENT_USER = computed(() => page.props.CURRENT_USER)
const x_message = computed(() =>page.props.flash.message)

const fileAttachment = ref([
    {name:'lil.jpg',size:1111},
    {name:'123123.jpg',size:111}
]);

const removeItem=(index)=> {
    fileAttachment.value.splice(index,1);
}

const readMoreButton = ref(true)
const readMoreReadLessText = ref('')
let readMoreCounter = 0

const props = defineProps([
    'grievance',
    'action',
    'subDepartment',
    'case',
    'department',
    'grievanceCategory',
    'currentRole',
    'mUserFiles',
    'mNodalFiles',
    'showAction',
    'prepopulatedFiles',
    'isMarkedClosedBySub',
    'fromReport',
    'answerEdit',
    'answerEditByAppellate',
    'EDITING_HOURS',
    'from_closed_page',
    'randomQuote',

]) 

//const mark_as_closed=ref(false)
let quote = props.randomQuote.quote +' - '+props.randomQuote.speaker

let selectedCategory=''
props.prepopulatedFiles = ref( [
  { name: 'example_file_1.txt', size: 1024 },
  { name: 'example_image.jpg', size: 2048 },
  // Add more file objects as needed.
]);

props.grievanceCategory.forEach(function(cat,index){
    if(cat.value==props.grievance.category_id){
        selectedCategory=cat 
    }
})

let form=useForm({
    action:'',
    remark:'',
    grievance_id:props.grievance.id,
    subDepartment:[],
    //category: props.grievanceCategory[props.grievance.category_id - 1],
    category: selectedCategory,

    resolutionType:'',
    department:'',
    subDepartmentCanCloseCheckBox:'',
    files:[],
    mark_as_closed_for_no_action:true,
    mark_as_closed_for_examine:false,
    maximumDaysDefine:'',
})

const noActionRequiredModal = ref(false)
const examineAtOurLevelModal = ref(false)
const takeUpWithSubDepartmentModal = ref(false)
const caseDisposeOfModal = ref(false)
const transferToAnotherDepartmentModal = ref(false)
const dialogEditAnswer = ref(false)
const dialogEditAnswerByAppellate = ref(false)

const dialogEditMovementAnswer = ref(false)
const dialogEditMovementMaximumDays = ref(false)

//NEW FROM HOME
const attachmentDeleteConfirmationDialog = ref(false)
const attachmentDeleteConfirmationMovementDialog = ref(false)
const attachmentDeleteConfirmationDialogByAppellate = ref(false)
const attachmentDeleteConfirmationMovementDialogByAppellate = ref(false)

const xfiles = ref(null)
const editRemovedFiles = ref(null)
const editMovementRemovedFiles = ref(null)

const currentIndexOfAttachmentRemove = ref(null)
const currentIndexOfAttachmentMovementRemove = ref(null)
const currentIndexOfAttachmentRemoveByAppellate = ref(null)
const currentIndexOfAttachmentMovementRemoveByAppellate = ref(null)
//NEW FROM HOME END

let secondDialog = ref(false)
let editDialog = ref(false)

const iAmNodal = ref(true)
let isNotTransfer = ref(true)
let subCanClose=ref(true)
let iAmSubDepartment = ref(false)

let grievanceActionShow = ref(true)
let mRow=''
let editRow=''

const mMovementRow=ref("")
const mMovementRowIndex=ref("")

if(props.grievance.sub_organization_can_close_case == true){
    form.subDepartmentCanCloseCheckBox = true
}else {
    form.subDepartmentCanCloseCheckBox = false
}

//form.subDepartmentCanCloseCheckBox=false

var isCheckBoxDisabled=ref(false)

if(props.currentRole==4){ //4=SUB DEPARTMENT USER
    iAmSubDepartment = true
}

if(props.grievance.action_id==10){// 10=SUB ORDINATE CAN CLOSED
    subCanClose=false
}
const department = ref(props.department)

const options=ref(props.action)

const subDepartment=ref(props.subDepartment)

const movement=ref(false)//should be false. true for testing

const classification=props.grievanceCategory

const resolutionType=['No resolution','Partial Resolve','Fully Resolve'];

let movementForm = useForm({
    'grievance_id': props.grievance.id
})

const actionHistoryClick=()=>{
    movement.value = true
    
}

const noActionRequiredClick=()=>{
    form.post('/grievance/officer/noactionrequired',{
        preserveScroll:true,
        onStart:()=>q.loading.show({message:quote}),
        onFinish:()=>{
            q.loading.hide()
        },
    })
}

const examineAtOurLevelClick=()=>{
    form.post('/grievance/officer/examineatourlevel',{
        preserveScroll:true,
        onStart:()=>q.loading.show({message:quote}),
        onFinish:()=>{
            q.loading.hide()
        },
    })
}

const takeUpWithSubDepartmentClick=()=>{
    form.post('/grievance/officer/takeupwithsubdepartment',{
        preserveScroll:true,
        onStart:()=>q.loading.show({message:quote}),
        onFinish:()=>{
            q.loading.hide()
        },
    })
}

const caseDisposeOfClick=()=>{
    form.post('/grievance/officer/casedisposeof',{
        preserveScroll:true,
        onStart:()=>q.loading.show({message:quote}),
        onFinish:()=>{
            q.loading.hide()
        },
    })
}

const transferToAnotherDepartmentClick=()=>{
    form.post('/grievance/officer/transfertoanotherdepartment',{
        preserveScroll:true,
        onStart:()=>q.loading.show({message:quote}),
        onFinish:()=>{
            q.loading.hide()
        },
    })
}

const filterFn=(val,update)=>{
    if(val){
        update(() => {
            department.value=props.department.filter(item=>item.label.toLowerCase().includes(val.toLowerCase()))
        })
        return
    }
    update(() =>{
        department.value=props.department
    })
}

const columns =  [
    { name:'id', align:'left', label:'Sl No', field:'id'},//field:row=> 'ID : ${row.id}' //ka append duh chuan
    {name:'date_of_action', align:'left', label:'Date of Action', field:'date_of_action'},
    {name:'action', align:'left', label:'Action Taken', field:'action',format:val=>val.label},
    {name:'action_taken_by', align:'left', label:'Action Taken By', field:'id'},
    {name:'from', align:'left', label:'From', field:'from_id'},
    {name:'to', align:'left', label:'To', field:'to_id'},
    {name:'remark', align:'center', label:'Remark', field:'remark'},
    {name:'maximum_days', align:'center', label:'Maximum Days', field:'maximum_days'},

]

const subDepartmentSelect=()=>{
    if(form.subDepartment.length>1){
        isCheckBoxDisabled=true
        form.subDepartmentCanCloseCheckBox=false
    }else{
        isCheckBoxDisabled=false
    }
}

const secondDialogClick=(row)=>{
    mRow = row
    secondDialog.value = true
}

// const editMovementClick=(row)=>{
//     editForm.remark = row.remark+" :This is appended! Line:1039"
//     editForm.files[0] ={0:'../../../storage/files/NODAL1688473220746.pdf'}
//     editDialog.value = true
   
//     // mRow = row
// }

const printClicked=(id)=>{   
    window.open('/grievance/print/'+id,'_blank')
}

const stringToArray=(param)=>{
    return param.split(",")
}

if(subCanClose){
    if(iAmSubDepartment){
        grievanceActionShow=true
    }
}else{
    if(iAmNodal){

    }
}

const onRejected=(rejecteEntries)=>{
    q.notify({
        type:'negative',
        message:`${rejecteEntries.length} file(s) did not pass validation constraints`
    })
}
 

// const moreDialogClick=(row)=>{
//     mRow = row
//     moreDialog.value = true
// }

onMounted(()=>{
    if(props.grievance.grievance_description.length>330){
        props.grievance.grievance_description_modify = props.grievance.grievance_description.slice(0,330)+'...' 
        readMoreReadLessText.value = 'Read More'
    }else{
        props.grievance.grievance_description_modify = props.grievance.grievance_description 

    }
})

const mountedDuplicate=()=>{
    if(props.grievance.grievance_description.length>330){
        props.grievance.grievance_description_modify = props.grievance.grievance_description.slice(0,330)+'...' 
        readMoreReadLessText.value = 'Read More'
    }else{
        props.grievance.grievance_description_modify = props.grievance.grievance_description 

    }
     
}

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
    final_remark_update:'',
    editAnswerFiles:[],
    
 })

 let form3 = useForm({
    grievance_movement_id:'',
    grievance_movement_remark:'',
    previousFiles:[],
    appendedFiles:[],

 })

 let form4 = useForm({
    grievance_movement_id:'',
    grievance_movement_maximum_days:'',
 })

 let form5 = useForm({
    grievance_movement_id:'',
    grievance:'',
    editAnswerFiles:[],

 })

 const editAnswerUpdate=()=>{
   
    form2.transform(data=>({
        grievance_id:props.grievance.id,
        final_remark_update:props.grievance.final_remark,
        mNodalFiles:props.mNodalFiles,
        editAnswerFiles: form2.editAnswerFiles,
        editRemovedFiles:editRemovedFiles,

    })).post('/grievance/answer/update',{
        onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{q.loading.hide()},
        onSuccess:()=> {
            q.notify({
                message: 'Answer Update Successfully',
                icon:'check',
                iconColor:'blue'
            });
            mountedDuplicate();
        }
    })
 }

 const editAnswerUpdateByAppellate=()=>{
   
    form5.transform(data=>({
        grievance_movement_id:props.grievance.appealReplyId,
        grievance:props.grievance,
        editAnswerFiles: form5.editAnswerFiles,

    })).post('/grievance/answer/updateByAppellate',{
       onStart:()=>q.loading.show({message:'Uploading...'}),
       onFinish:()=>{ q.loading.hide()},
       onSuccess:()=> {
           q.notify({
               message: 'Answer Update Successfully',
               icon: 'check',
               iconColor: 'blue'
           });
           mountedDuplicate();
       }
    })
}

 const movementEditRemarks=(row,rowIndex)=>{
   
    mMovementRow.value = row
    mMovementRowIndex.value = rowIndex
    dialogEditMovementAnswer.value = true
    
 }
 
 const movementEditMaximumDays=(row)=>{
    mMovementRow.value = row
    dialogEditMovementMaximumDays.value = true
 }

 const movementAnswerUpdate=(MovementRow)=>{
     
    form3.transform(data=>({
        grievance_movement_id: MovementRow.id,
        grievance_movement_remark : MovementRow.remark,
        previous_files : props.grievance.grievance_movement[mMovementRowIndex.value].nodal_attachment_array,
        appended_files : form3.appendedFiles,
        
    })).post('/grievance/movement/answer/update',{
        onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{q.loading.hide()},
        onSuccess:()=> {
            q.notify({
                message: 'Answer Update Successfully',
                icon:'check',
                iconColor:'blue'
            });
            mountedDuplicate();
        }
    })
 }

 const movementDaysUpdate=(MovementRow)=>{

        form4.transform(data=>({
        grievance_movement_id: MovementRow.id,
        grievance_movement_maximum_days : MovementRow.maximum_days,
    })).post('/grievance/movement/maximumdays/update',{
        onStart:()=>q.loading.show({message:'Uploading...'}),
        onFinish:()=>{q.loading.hide()},
        onSuccess:()=> {
            q.notify({
                message: 'Answer Update Successfully',
                icon:'check',
                iconColor:'blue'
            });
            mountedDuplicate();
        }
    })
 }

 //<!-- NEW FROM HOME -->
 const editFinalReplyAttachmentRemoveClick=()=>{
     props.mNodalFiles.splice(currentIndexOfAttachmentRemove.value,1)
     editRemovedFiles.push(props.mNodalFiles(currentIndexOfAttachmentRemove.value))
 }
// <!-- NEW FROM HOME -->
 const openConfirmationDialog=(index)=> {
    attachmentDeleteConfirmationDialog.value=true
    currentIndexOfAttachmentRemove.value=index
 }

const editFinalReplyAttachmentRemoveClickByAppellate=()=>{
    
    props.grievance.daaAttachment.splice(currentIndexOfAttachmentRemoveByAppellate.value,1)
    editRemovedFiles.push(props.grievance.daaAttachment(currentIndexOfAttachmentRemoveByAppellate.value))

    console.log(props.grievance.daaAttachment)
}
const openConfirmationDialogByAppellate=(index)=> {
   attachmentDeleteConfirmationDialogByAppellate.value=true
   currentIndexOfAttachmentRemoveByAppellate.value=index
}

  //<!-- NEW FROM OFFICE -->
  const editFinalReplyAttachmentMovementRemoveClick=()=>{
    props.grievance.grievance_movement[mMovementRowIndex.value].nodal_attachment_array.splice(currentIndexOfAttachmentMovementRemove.value,1)
    editMovementRemovedFiles.push(props.grievance.grievance_movement[mMovementRowIndex.value].nodal_attachment_array(currentIndexOfAttachmentMovementRemove.value))
 }
// <!-- NEW FROM OFFICE -->
 const openConfirmationMovementDialog=(index)=> {
    
    attachmentDeleteConfirmationMovementDialog.value=true
    currentIndexOfAttachmentMovementRemove.value=index
 }
 
 let pendingToClosed = useForm({
    grievance_id:'',
})

 const moveToClosedClick=()=>{
    
    q.dialog({
        title:'Confirmation',
        message:'Are you sure you want to move this from pending?',
        cancel:true,
    }).onOk(()=>{
        pendingToClosed.transform(data=>({
            grievance_id: props.grievance.id,
        })).post('/grievance/movefrompendingtoclosed',{
            onStart:()=>q.loading.show({message:'Moving...'}),
            onFinish:()=>{q.loading.hide()},
        })
    }).onCancel(() => {
        // console.log('Cancel')
    }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
    })
 }


</script>

<style>
   .clickable:hover{
        color: blue;
    }
</style> 
   