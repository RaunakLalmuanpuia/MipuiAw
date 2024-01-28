<template>
    <Head title="Home" />
    <div class="q-pa-md">

    <q-carousel
      animated
      v-model="slide"
      arrows
      navigation
      infinite
      height="40vh"
       
       
    >
      <q-carousel-slide 
       
      v-for="(img,i) in props.carousels" :key="i"
       
      :name=i+1
      :img-src="'/../../../../../storage/carousel/'+img.image" />
    </q-carousel>
  </div>

   <div class="mx-3">
        <div class="bg-pink-9 text-white text-center text-bold p-1">
            Any Grievance sent by email will not be attended to / entertained. Please lodge your grievance at the website. 
        </div>
        <div class="row justify-center">
            <!-- <div class="text-justify" :class="$q.screen.sm?'col-11':'col-4'"> -->
            <div class="text-justify col-xs-10 col-sm-11 col-md-8 col-lg-4 col-xl-4">
              <div class="text-h5">ABOUT MIPUI-AW </div>    
              <span v-html="homeText.body1??''"></span>
              <hr class="mt-10 mb-10">
              <div class=" text-2xl text-center">
                Comprehensive Performance Integration Across Departments
              </div>
              <div class="mt-5 column items-center">
                <div class="col">
                  <q-btn-group  rounded>
                    <q-btn size="sm" @click="dateFilterClick('year')" rounded color="primary" label="This Year" />
                    <q-btn size="sm" @click="dateFilterClick('month')" rounded color="primary" label="This Month" />
                    <q-btn size="sm" @click="dateFilterClick('week')" rounded color="primary" label="This Week" />
                    <q-btn size="sm" @click="dateFilterClick('today')" rounded color="primary" label="Today" />
                    <q-btn size="sm" @click="dateFilterClick('all')" rounded color="primary" label="All" />


                  </q-btn-group>
                  
                </div>
                <div class="col">
                  Range : {{ props.allDepartment.range }}
                </div>
                <div class="col">
                    <apexchart
                    class=""
                    width="500"
                    type="bar"
                    :options="chartOptions"
                    :series="series"
                    
                  ></apexchart>
                </div>
                
              </div>
            </div>
        </div>

   </div> 

    
     
</template> 

 <script setup>
import { Head, useForm,Link } from '@inertiajs/vue3';
import {  ref } from 'vue';
import {useQuasar} from "quasar";
 import VueApexCharts from "vue3-apexcharts";

const q=useQuasar()
 const props = defineProps([
  'carousels','homeText','allDepartment','Link'
])
const slide = ref(1)

const apexchart = VueApexCharts
const chartOptions = ref({
  chart:{id:"ch"},
  xaxis:{categories:["Total Grievance Registered","Grievance Closed","Not Yet Process","Processing"] },
   
  
})
  
const series=ref([{
    name:["series"],
    data:[props.allDepartment.grievance_received,props.allDepartment.grievance_closed,props.allDepartment.grievance_not_yet_process,props.allDepartment.grievance_processing],
    
}])

let form=useForm({
  range:''
})

const dateFilterClick=(range)=>{
  form.range=range

  console.log(form.range)
  form.get('/',{
        onStart:()=>q.loading.show({
            message: "Loading..."
        }),
        onFinish:()=>{
            q.loading.hide()
        },
        
        
    },{
       preserveScroll:true,
        
    })
}



</script> 