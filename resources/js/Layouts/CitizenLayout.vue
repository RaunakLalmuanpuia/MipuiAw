<template>
    <link rel="icon" type="image/png" sizes="32x32" :href="'../../../img/favicon.png'">

    <q-layout view="hHh lpR fFf">
  
      <div v-if="CURRENT_USER.role_id==2 ||CURRENT_USER.role_id==3 ||CURRENT_USER.role_id==4">
        <q-header elevated class="bg-indigo-6 text-white">
          <q-toolbar>
          <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />
          <q-toolbar-title class="row items-center" href="#" @click="$inertia.get(route('citizen.dashboard'))">
             
            <div  @click="toolbarClick()" class="py-2">
              <img width="180" :src="'../../../img/mipui_aw_website_logo_bg.png'">
            </div>
             
          </q-toolbar-title>
          </q-toolbar>
          </q-header>
        </div>
        <div v-else>
          <q-header elevated class="bg-pink-9 text-white">
            <q-toolbar>
          <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />
          <q-toolbar-title class="row items-center" href="#" @click="$inertia.get(route('citizen.dashboard'))">
            <div @click="toolbarClick()"  class="py-2 cursor-pointer">
              <img width="180" :src="'../../../img/mipui_aw_website_logo_bg.png'">
            </div>
            
          </q-toolbar-title>
          </q-toolbar>
          </q-header>
        </div>
        
  
      <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
        <!-- drawer content -->
        <q-scroll-area class="fit">
          <div class="ml-3  mt-3">
  
  
            <q-list>
  
              <q-item-label header>User: {{ CURRENT_USER.name }}</q-item-label>
              
              <q-item clickable v-ripple class="no-padding">
                <Link class="full-width" href="/">
                  <div class="row mt-3 ml-5">
                    <q-item-section avatar>
                    <i class="q-icon material-icons-outlined">
                        home
                    </i>
                    </q-item-section>
                    Home
                  </div>
                </Link>
              </q-item>
              
              <hr>

              <q-item-label header>My Function</q-item-label>
  
             

              <q-item clickable v-ripple class="no-padding">
                <Link class="full-width" :href="route('citizen.dashboard')" :class="{ 'active': $page.url === '/citizen/dashboard' }">
                  <div class="row mt-3 ml-5">
                    <q-item-section avatar>
                    <i class="q-icon material-icons-outlined">
                        dashboard
                    </i>
                    </q-item-section>
                    Dashboard
                  </div>
                </Link>
              </q-item>

               
              
              <q-item v-if="CURRENT_USER.active==true" clickable v-ripple class="no-padding">
                <Link class="full-width " :href="route('grievance.create1')"  :class="{ 'active': $page.url === '/grievance1'}">
                  <div class="row mt-3 ml-5">
                    <q-item-section avatar>
                    <i class="q-icon material-icons-outlined">
                      note_add
                    </i>
                    </q-item-section>
                    Lodge Grievance
                  </div>
                </Link>
              </q-item>
              
              

              <q-expansion-item
                expand-separator
                icon="text_snippet"
                label="Appeal"
                caption=""  
                
              >
                  <q-item v-if="CURRENT_USER.active==true" clickable v-ripple class="no-padding">
                    <Link class="full-width " :href="route('appeal.index')" :class="{ 'active': $page.url === '/citizen/appeal'}">
                      <div class="row mt-3 ml-5">
                        <q-item-section avatar>
                        <i class="q-icon material-icons-outlined">
                          error
                        </i>
                        </q-item-section>
                        Appeal Grievance
                      </div>
                    </Link>
                  </q-item>
                  
                  <hr>

                  <q-item clickable v-ripple class="no-padding">
                      <Link class="full-width " :href="route('appeal.dashboard')"  :class="{ 'active': $page.url === '/citizen/appeal/dashboard'}">
                        <div class="row mt-3 ml-5">
                          <q-item-section avatar>
                          <i class="q-icon material-icons-outlined">
                            dashboard_customize
                          </i>
                          </q-item-section>
                          Appeal Dashboard
                        </div>
                      </Link>
                    </q-item>
                    
                    <hr>
              </q-expansion-item>
              <hr>
              <q-item-label header>System</q-item-label>

              <q-item clickable v-ripple class="no-padding">
                <Link class="full-width " :href="'#'" @click="$inertia.get(route('user.details.show'))">
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
                <Link class="full-width " :href="'#'"  @click="logout=true">
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
      </q-footer> -->
      
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
  
  const SUPER_ADMIN = ref(true)
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
  let userName = ''
  
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
.required:after{
    content:" *";
    color: red;
}
</style>