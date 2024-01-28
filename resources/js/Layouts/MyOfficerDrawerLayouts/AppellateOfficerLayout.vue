<template>

   <q-item-label header>Departmental Appellate Officer</q-item-label>
                
                <q-item clickable v-ripple class="no-padding">
                  <Link class="full-width " :href="route('officer.dashboard')" :class="{ 'active': $page.url === '/dashboard' }">
                    <div class="row mt-3 ml-5">
                      <q-item-section avatar>
                      <i class="q-icon material-icons-outlined">
                        dashboard
                      </i>
                      </q-item-section>
                      
                      <q-item-section>
                        Pending List
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
                        Closed
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
                <q-expansion-item
                    expand-separator
                    icon="people"
                    label="Users"
                    caption=""  
                    :content-inset-level="0.5"
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
                            Department User (Department Nodal View)
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
                </div>
                
                <q-separator />
</template>

<script setup>

import { usePage,Link } from '@inertiajs/vue3'
 import { computed } from 'vue'

 const page = usePage()

 const CURRENT_USER = computed(() => page.props.CURRENT_USER)

</script>