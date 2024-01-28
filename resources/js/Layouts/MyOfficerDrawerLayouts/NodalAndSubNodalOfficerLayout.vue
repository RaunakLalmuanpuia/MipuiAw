<template>

    <q-item clickable v-ripple class="no-padding">
        <Link class="full-width" href="/">
            <div class="row mt-1 ml-5">
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
    <q-item-label  v-if="CURRENT_USER.role_id===3 " header>Department Nodal Officer</q-item-label>
    <q-item-label v-else header>Sub-Department Nodal Officer</q-item-label>
    
            <q-item clickable v-ripple class="no-padding">
                <Link class="full-width " :href="route('officer.dashboard')" :class="{ 'active': $page.url === '/dashboard' }">
                <div class="row mt-3 ml-5">
                    <q-item-section avatar>
                        <i class="q-icon material-icons-outlined">
                            dashboard
                        </i>
                    </q-item-section>
                    <q-item-section>
                        <p v-if="CURRENT_USER.role_id===3">Dashhoard</p>
                        <p v-else>Pending List</p>
                    </q-item-section>
                </div>
                </Link>
            </q-item>
            
            <q-item  v-if="CURRENT_USER.role_id===3 " clickable v-ripple class="no-padding">
                <Link class="full-width " :href="'/department/sibling/' + CURRENT_USER.department_id" :class="{ 'active': $page.url === '/department/sibling/{id}' }">
                <div class="row mt-3 ml-5">
                    <q-item-section avatar>
                    <i class="q-icon material-icons-outlined">
                    corporate_fare
                    </i>
                    </q-item-section>
                    <q-item-section>
                    Sub Office
                    </q-item-section>
                </div>
                </Link>
            </q-item>

            <q-item clickable v-ripple class="no-padding">
                <Link class="full-width " :href="'/department/closed'" :class="{ 'active': $page.url === '/department/closed' }">
                <div class="row mt-3 ml-5">
                    <q-item-section avatar>
                    <i class="q-icon material-icons-outlined">
                    archive
                    </i>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>Closed</q-item-label>
                         

                    </q-item-section>
                </div>
                </Link>
            </q-item>

            <q-item  v-if="CURRENT_USER.role_id===3 " clickable v-ripple class="no-padding">
                <Link class="full-width " :href="'/admin/appeal'" :class="{ 'active': $page.url === '/admin/appeal' }">
                <div class="row mt-3 ml-5">
                    <q-item-section avatar>
                    <i class="q-icon material-icons-outlined">
                    text_snippet
                    
                    </i>
                    </q-item-section>
                    <q-item-section>
                    Appeal
                    </q-item-section>
                </div>
                </Link>
            </q-item>

            <div v-if="CURRENT_USER.role_id===3 ">
                <q-item clickable v-ripple class="no-padding">
                    <Link class="full-width " :href="route('category.index')" :class="{ 'active': $page.url === '/admin/category' }">
                    <div class="row mt-3 ml-5">
                        
                        
                        <q-item-section avatar>
                        <i class="q-icon material-icons-outlined">
                        category
                        </i>
                        </q-item-section>
                        <q-item-section>
                        Category
                    </q-item-section>
                    </div>
                    </Link>
                </q-item>
            </div>

            <div v-if="CURRENT_USER.role_id===3 ">
                <q-item clickable v-ripple class="no-padding">
                    <Link class="full-width " :href="route('department.report')" :class="{ 'active': $page.url === '/myreport' }">
                    <div class="row mt-3 ml-5">
                        
                        
                        <q-item-section avatar>
                        <i class="q-icon material-icons-outlined">
                            analytics
                        </i>
                        </q-item-section>
                        <q-item-section>
                        Report
                    </q-item-section>
                    </div>
                    </Link>
                </q-item>
            </div>

            <q-expansion-item
                v-if="CURRENT_USER.role_id===3"
                :content-inset-level="0.5"
                expand-separator
                icon="people"
                label="Users"
                caption=""  
                >
                
                <div>

                
                <q-item clickable v-ripple class="no-padding">
                    <Link class="full-width " :href="route('departmentnodal.index')" :class="{ 'active': $page.url === '/admin/departmentnodal' }">
                    <div class="row mt-3 ml-5">
                        
                        <q-item-section avatar>
                        <i class="q-icon material-icons-outlined">
                            manage_accounts
                        </i>
                        </q-item-section>
                        <q-item-section>
                        Sub-Department User 
                        </q-item-section>
                        
                    </div>
                    </Link>
                </q-item>
                <q-item clickable v-ripple class="no-padding">
                    <Link class="full-width " :href="route('appellate.index')" :class="{ 'active': $page.url === '/admin/appellate' }">
                    <div class="row mt-3 ml-5">
                        <q-item-section avatar>
                        <i class="q-icon material-icons-outlined">
                            supervisor_account
                        </i>
                        </q-item-section>
                        <q-item-section>
                        Departmental Appellate Authority
                        </q-item-section>
                        
                    </div>
                    </Link>
                </q-item>
                </div>
                </q-expansion-item>

            
            <q-separator />
 
                 
    <q-separator />
 </template>
 
 <script setup>
 import { usePage,Link } from '@inertiajs/vue3'
 import { computed } from 'vue'

 const page = usePage()

 const CURRENT_USER = computed(() => page.props.CURRENT_USER)

 
 </script>