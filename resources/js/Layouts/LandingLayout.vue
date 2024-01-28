
<template>
  <link rel="icon" type="image/png" sizes="32x32" :href="'../../../img/favicon.png'">

    <q-layout view="hHh lpR fFf">
      <link rel="icon" type="image/png" :src="'../../../img/ashoka.png'">

      <q-header elevated class="bg-pink-9 text-white">
        <div class="ml-10 my-1">
            
          Goverment of Mizoram | Department of Personnel and Administrative Reforms
        </div>
        
        <div class="bg-white text-black py-2 pl-7 cursor-pointer row items-center" @click="$inertia.get('/')">
            <div>
              <img width="180" :src="'../../../img/mipui_aw_website_logo.png'">
            </div>
             
  
             
        </div>
        <div class="ml-10 my-2">
          <div class=" q-gutter-md q-pa-md">
              <span>
                  <Link
                    @click="$inertia.get('/')">
                    Home
                  </Link>
                  </span>
              <span>
                <Link
                  @click="$inertia.get('nodals')">
                  Nodal PG Officers
                </Link>
                </span>
              <!-- <span>Redress Process</span> -->
              <span>
                <Link
                  @click="$inertia.get('department-statistics')">
                  Department-Statistics
                </Link>
              </span>

              <span  v-if="!isAuth"> 
                <Link  
                  class="full-width " 
                  @click="$inertia.get('login')">
                  Login
                </Link>
              </span>  
              <span v-if="!isAuth">
                <Link  
                  class="full-width " 
                  @click="$inertia.get('register')">
                  Register
                </Link>
              </span>
              <span v-if="isAuth">  
                <Link  
                  class="full-width " 
                  @click="$inertia.post(route('logout'))">
                  Logout
                </Link>
              </span>

              <span>
                <Link
                  @click="$inertia.get('contact-us')">
                  Feedback
                </Link>
              </span>

              <span v-if="CURRENT_USER!=null">
                |
              </span>
              <span v-if="CURRENT_USER!=null">
                
                <span v-if="CURRENT_USER.role_id==5">
                  <Link  
                    class="full-width " 
                    @click="$inertia.get(route('citizen.dashboard'))">
                   DASHBOARD
                  </Link>
                   
                </span>
                <span v-else>
                  <Link  
                    class="full-width " 
                    @click="$inertia.get(route('officer.dashboard'))">
                    DASHBOARD
                  </Link>
                </span>
              </span>
              
            </div>
        </div>

    </q-header>
      <q-page-container>
        <main>
          <slot />
        </main>
        <div class="bg-grey-4 bottom py-3 mt-5">
        <div class="text-center">
          This site is designed, developed & hosted by Mizoram State e-Governance Society (MSeGS), and Content owned by Department of Personnel and Administrative Reforms. 
          </div>
        </div> 
        </q-page-container>
     
      <!-- <q-footer class="bg-grey-4 text-black">
         <div class="my-2 text-center">
          This site is designed, developed & hosted by Mizoram State e-Governance Society (MSeGS), and Content owned by Department of Personnel and Administrative Reforms. 
         </div>
      </q-footer> -->
    </q-layout>
    
  </template>
    
  


<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import axios from 'axios'
import { usePage,Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue'
const page = usePage()
const isAuth = computed(() => page.props.isAuth)
const CURRENT_USER = computed(() => page.props.CURRENT_USER)

 
</script>
