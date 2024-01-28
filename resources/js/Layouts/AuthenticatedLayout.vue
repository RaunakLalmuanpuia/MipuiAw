<template>
    <link rel="icon" type="image/png" sizes="32x32" :href="'../../../img/favicon.png'">

  <q-layout view="hHh lpR fFf">
    
    <!-- ADMIN AND STATE NODAL -->
    <span v-if="CURRENT_USER.role_id===1 || CURRENT_USER.role_id===2">
      <q-header elevated class="bg-blue-grey-9 text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title class="row items-center">
              <div @click="toolbarClick()" class="py-2 cursor-pointer">
                <img width="180" :src="'../../../img/mipui_aw_website_logo_bg.png'">
              </div>
              
              <q-avatar  @click="toolbarClick()" class="ml-5 cursor-pointer">
              <img :src="'../../../img/management_bw.png'" alt="">
              </q-avatar>

        </q-toolbar-title>
      </q-toolbar>
    </q-header>
    </span>

    <!-- Department Nodal -->
    <span v-else-if="CURRENT_USER.role_id===3">
      <q-header elevated class="bg-indigo-6 text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title class="row items-center" >
            <div  @click="toolbarClick()" class="py-2  cursor-pointer">
              <img width="180" :src="'../../../img/mipui_aw_website_logo_bg.png'">
            </div>
             
        </q-toolbar-title>
      </q-toolbar>
    </q-header>
    </span>

    <!-- SUB Department Nodal -->
    <span v-else-if="CURRENT_USER.role_id===4">
      <q-header elevated class="bg-orange-10 text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title class="row items-center">
            <div  @click="toolbarClick()" class="py-2  cursor-pointer">
              <img width="180" :src="'../../../img/mipui_aw_website_logo_bg.png'">
            </div>
             
        </q-toolbar-title>
      </q-toolbar>
    </q-header>
    </span>

     <!-- Departmental Appellate Authority -->
     <span v-else-if="CURRENT_USER.role_id=== 6">
      <q-header elevated class="bg-green-10 text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title class="row items-center">
            <div @click="toolbarClick()" class="py-2 cursor-pointer">
              <img width="180" :src="'../../../img/mipui_aw_website_logo_bg.png'">
            </div>
             
        </q-toolbar-title>
      </q-toolbar>
    </q-header>
    </span>
    
     

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <!-- drawer content -->
      <q-scroll-area class="fit">
        <div class="ml-3  mt-3">

          <q-list>
            <h5>{{ CURRENT_USER.department?CURRENT_USER.department.organization_name:'' }}</h5>
            <q-item-label header>User: {{ CURRENT_USER.name }}, {{ CURRENT_USER.designation }}<br>
              {{ CURRENT_USER.sub_department?CURRENT_USER.sub_department.organization_name:'' }}
            </q-item-label>
             <!-- admin start -->
              <div v-if="CURRENT_USER.role_id === 1 || CURRENT_USER.role_id === 2">
                <AdminLayout />
              </div>
              <!-- end of admin -->

              
              <!-- Dept Nodal View -->
            <div v-else-if="CURRENT_USER.role_id===3 || CURRENT_USER.role_id===4">
              <NodalAndSubNodalOfficerLayout />
            </div>
            <!-- END -->

            <!-- Appellate officer -->
          <div v-else-if="CURRENT_USER.role_id===6">
            <AppellateOfficerLayout />
          </div>
          <!-- end of appellate -->

            <q-item-label header>System</q-item-label>

            <q-item clickable v-ripple class="no-padding">
              <Link class="full-width " :href="'#'" @click="$inertia.get(route('officer.details.show'))">
                  <div class="row mt-3 ml-5">
                    <q-item-section avatar>
                    <i class="q-icon material-icons-outlined">
                      manage_accounts
                    </i>
                    </q-item-section>
                    <q-item-section>
                      User Profile
                    </q-item-section>
                  </div>
                </Link>
              </q-item>
              
            <q-item clickable v-ripple class="no-padding mb-10">
              <Link class="full-width " :href="'#'"  @click="logout=true" >
                <div class="row mt-3 ml-5">
                  <q-item-section avatar>
                  <i class="q-icon material-icons-outlined">
                    logout
                  </i>
                  </q-item-section>
                  <q-item-section>
                    Logout
                    
                  </q-item-section>
                </div>
              </Link>
            </q-item>
          </q-list>
        </div>
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <main>
        <slot />
        
      </main>
      <div class="bg-grey-4 verticle-bottom py-3 mt-5">
          <div class="text-center">
            This site is designed, developed & hosted by Mizoram State e-Governance Society (MSeGS), and Content owned by Department of Personnel and Administrative Reforms. 

          </div>
        </div> 
    </q-page-container>
 
     
     <!-- <q-footer class="bg-grey-4 text-black">
        <div class="my-2 text-center">
          This site is designed, developed & hosted by Mizoram State e-Governance Society (MSeGS), and Content owned by Department of Personnel and Administrative Reforms. 
         </div>
      </q-footer>   -->
    </q-layout>


<q-dialog v-model="logout">
    <q-card>
        <q-card-section class="row items-center">
        <q-avatar icon="done" color="primary" text-color="white" />
        <span class="q-ml-sm">Are you sure you want to Logout?</span>
        </q-card-section>

        <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" v-close-popup />
        <q-btn flat label="Logout"   @click="$inertia.post(route('logout'))" color="primary" v-close-popup />
        </q-card-actions>
    </q-card>
</q-dialog>

</template>

<script setup>
import axios from 'axios'
import { Axios } from 'axios'
import { computed, ref, onMounted } from 'vue'
import { usePage,Link,router } from '@inertiajs/vue3'
 

import AdminLayout from '@/Layouts/MyOfficerDrawerLayouts/AdminLayout.vue'
import AppellateOfficerLayout from '@/Layouts/MyOfficerDrawerLayouts/AppellateOfficerLayout.vue'
import NodalAndSubNodalOfficerLayout from '@/Layouts/MyOfficerDrawerLayouts/NodalAndSubNodalOfficerLayout.vue'

const page = usePage()
let drawer = ref(false)
const toggleLeftDrawer = () => {
leftDrawerOpen.value = !leftDrawerOpen.value
}

onMounted(() => {
  console.log('mounted');
  axios.get('/admin/departmentnodal/role').then((result) => {
    console.log("MY LOG" + result)
  })
})

const leftDrawerOpen = ref(false)
const logout = ref(false)

const menuList = [
  {
    icon: 'inbox',
    label: 'Inbox',
    separator: true
  },
  {
    icon: 'send',
    label: 'Outbox',
    separator: false
  },
  {
    icon: 'delete',
    label: 'Trash',
    separator: false
  },

]

const CURRENT_USER = computed(() => page.props.CURRENT_USER)

const toolbarClick=()=>{
  router.get('/')
}
</script>

<style>
  .active {
    background: #f1efef;
  }

  .required:after{
      content:" *";
      color: red;
  }

</style>