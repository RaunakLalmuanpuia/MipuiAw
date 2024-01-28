<template>
<Head title="My Report"/> 
    <div class="m-5">
        <div>
            <div class="mt-10 mb-5 row" >
                <div class="">
                    <q-btn label="Select Range" color="primary" @click="showCalender = true" />
                    <div v-if="rangeSelect">
                        Range : {{ rangeSelect['from'] }} - {{ rangeSelect['to'] }}
                    </div>
                </div>
                
                <div class="ml-5"><q-btn @click="printClick()">Print</q-btn></div>    
            </div>
            
        </div>

        <div>
            <div>
                Report Range : {{ myDepartmentCount.range }}
            </div>
            <div>
            Grievance Registered : <span>{{ myDepartmentCount.grievance_received }}</span>

            </div>
            <div>
            Grievance Processing : <span>{{ myDepartmentCount.grievance_processing }}</span>

            </div>
            <div>
            Grievance Not Yet Process : <span>{{ myDepartmentCount.grievance_not_yet_process }}</span>

            </div>
            <div>
            Grievance Closed : <span>{{ myDepartmentCount.grievance_closed }}</span>

            </div>
            <div>
            Closed Percentage (%) : <span>{{ myDepartmentCount.closed_percentage }}%</span>

            </div>
        </div>

        <div>
            <div id="chart">
            <apexchart 
            type="pie" 
            width="380" 
            :options="chartOptions" 
            :series="series"
            
            >
        
            </apexchart>
        </div>
        </div>
    </div>
<q-dialog v-model="showCalender" persistent>
    <q-card>
        <q-card-section class="row items-center">
             <q-date 
             v-model="form.rangeSelect" 
             mask="DD/MM/YYYY"
             today-btn
             range 
             flat
             />
        </q-card-section>

        <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" v-close-popup />
        <q-btn flat label="Submit" @click="submitRange()" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>
</template>

<script setup>
 import {ref} from 'vue'
 import {useForm,Head} from "@inertiajs/vue3";
 import {useQuasar} from "quasar";
 import VueApexCharts from "vue3-apexcharts";
 const apexchart = VueApexCharts

 const props = defineProps([
    'myDepartmentCount','rangeSelect',
])
const showCalender=ref(false)

const chartOptions = ref({
  chart:{width:380, type:'pie'},
  labels :['Processing','Not Yet Process','Closed'],   
  
  dataLabels:{
    //offsetX:'4px',
    enabled:true,
      
    style:{
        fontSize:'16px',
    },
     

    background: {
    enabled: true,
    foreColor: '#2e2e2e',
    padding: 10,
    borderRadius: 2,
    borderWidth: 1,
    borderColor: '#2e2e2e',
    opacity: 0.9,
    }


      
  },
  
})

const options = {
    dataLabels:{
        textAnchor:'middle',
        
        
  }
}

const series = ref( [props.myDepartmentCount.grievance_processing, props.myDepartmentCount.grievance_not_yet_process, props.myDepartmentCount.grievance_closed] )
const q=useQuasar()

let form = useForm({
    rangeSelect:'',
    printSelect:false,
})
const submitRange=()=>{
    form.get('/myreport',{
        onStart:()=>q.loading.show({
            message: "Loading..."
        }),
        onFinish:()=>{
            q.loading.hide()
        }
    })
}
 
const printClick=()=>{
    // form.printSelect=true,
    // form.get('/myreport',{
    //     onStart:()=>q.loading.show({
    //         message: "Loading..."
    //     }),
    //     onFinish:()=>{
    //         q.loading.hide()
    //     }
    // })


    const params = new URLSearchParams(props.rangeSelect).toString();
    const url = `/departmentreport/print?${params}`;
    window.open(url, '_blank');

}
</script>