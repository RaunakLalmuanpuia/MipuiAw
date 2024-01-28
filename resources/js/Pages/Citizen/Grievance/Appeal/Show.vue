<template>
    <Head title="Appeal Details" />

    <div class="m-5">
        <q-btn  class="mb-3" href="#" onclick="history.back();return false;" color="grey-4" text-color="black" label="Back" />

        <div class="border">

             
            <div class="p-5 bg-grey-4 text-h5">
            <h3>Appeal Details: </h3>
            </div>

            <div class="p-5">
                <div><h6>Appeal reason:</h6></div>
                <div  style="white-space:pre-line">
                    {{ props.appeal.appealQuestion }}
                </div>
                
                <div class="text-caption">
                    Date of Appeal: {{ date.formatDate(props.appeal.date_of_action,'DD MMM YYYY, hh:mm A') }}
                </div>
            </div>
            <div v-show="props.appeal.appealReply!=''" class="p-5">
                <div><h6>Reply:</h6></div>
                <div>{{   props.appeal.appealReply  }}</div>
                <div>
                    Attachment(s):
                    <li class="ml-4" v-for="item in stringToArray(props.appeal.daaAttachment)">
                        <a :href="'../../../../../../storage/files/'+item" target="_blank">
                            <span class="clickable text-blue">
                                {{ item }}
                            </span>
                        </a>
                    </li>
                </div>
                <hr class="mt-3">
                <div class="mt-5">
                    <h6>Officer Details:</h6>
                    <div>Name : {{ props.appeal.officer_name_daa }}</div>
                    <div>Designation : {{ props.appeal.officer_designation_daa }}</div>
                    <div>Mobile : {{ props.appeal.officer_mobile_daa }}</div>
                    <div>Email : {{ props.appeal.officer_email_daa }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { date } from 'quasar';

const props = defineProps([
'appeal',

]);

const stringToArray=(param)=>{
    return param.split(",")
}

</script>