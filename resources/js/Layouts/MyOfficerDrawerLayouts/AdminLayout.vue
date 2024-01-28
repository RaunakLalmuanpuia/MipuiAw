<template>




<q-item clickable v-ripple class="no-padding">
  <Link class="full-width " :href="route('landing')" :class="{ 'active': $page.url === '/' }">
    <div class="row mt-3 ml-5">
      <q-item-section avatar>
      <i class="q-icon material-icons-outlined">
        home
      </i>
      </q-item-section>
      
      <q-item-section>
        Home
  </q-item-section>
    </div>
  </Link>
</q-item>

<hr>
<q-item-label header>
  <span v-if="CURRENT_USER.role_id==1">Super Administrator</span>
  <span v-else> State Nodal Officer</span>  
 
</q-item-label>
<q-item clickable v-ripple class="no-padding">
  <Link class="full-width " :href="route('officer.dashboard')" :class="{ 'active': $page.url === '/dashboard' }">
    <div class="row mt-3 ml-5">
      <q-item-section avatar>
      <i class="q-icon material-icons-outlined">
        dashboard
      </i>
      </q-item-section>
      
      <q-item-section>
        Dashboard
  </q-item-section>
    </div>
  </Link>
</q-item>

<q-item clickable v-ripple class="no-padding">
  <Link class="full-width " :href="route('department.index')" :class="{ 'active': $page.url === '/department' }">
    <div class="row mt-3 ml-5">
      <q-item-section avatar>
      <i class="q-icon material-icons-outlined">
        corporate_fare
      </i>
      </q-item-section>
      
      <q-item-section>
        Department List
      </q-item-section>
    </div>
  </Link>
</q-item>


<q-expansion-item
:content-inset-level="0.5"
  expand-separator
  icon="article"
 
  label="Grievance"
  caption=""
  >
    
      <q-item clickable v-ripple class="no-padding" >
        <Link class="full-width " :href="route('officer.dashboard')"  :class="{ 'active': $page.url === '/dashboard' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined">
              assignment
            </i>
            </q-item-section>
            <q-item-section>
              Pending
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
                  <q-item-label caption>And transferred</q-item-label>

              </q-item-section>
          </div>
          </Link>
      </q-item>

      <q-item clickable v-ripple class="no-padding" >
        <Link class="full-width " :href="route('officer.notyetopen')"  :class="{ 'active': $page.url === '/dashboardnyo' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined">
              assignment
            </i>
            </q-item-section>
            <q-item-section>
              Not Yet Open
        </q-item-section>
          </div>
        </Link>
      </q-item>


      <q-item clickable v-ripple class="no-padding" >
        <Link class="full-width " :href="route('officer.deleteGrievance')"  :class="{ 'active': $page.url === '/dashboarddelete' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined text-red-6">
              delete
            </i>
            </q-item-section>
            <q-item-section>
              <span class="text-red-6">Delete Grievance</span>
              
        </q-item-section>
          </div>
        </Link>
      </q-item>
      
</q-expansion-item>


<q-expansion-item
    :content-inset-level="0.5"
    expand-separator
    icon="analytics"
    label="Reports"
    caption=""  
  >
  <q-item clickable v-ripple class="no-padding">
    <Link class="full-width " :href="route('report.grievancelist')"  :class="{ 'active': $page.url === '/report/grievancelist' }">
      <div class="row mt-3 ml-5">
        <q-item-section avatar>
        <i class="q-icon material-icons-outlined">
          list
        </i>
        </q-item-section>
        
        <q-item-section>
          <q-item-label>Grievance List</q-item-label>
          <q-item-label caption>Department Wise</q-item-label>
    </q-item-section>
      </div>
    </Link>
  </q-item>
    
</q-expansion-item>

  <q-expansion-item
    :content-inset-level="0.5"
    expand-separator
    icon="people"
    label="Users"
    caption=""  
  >
    <div  >

      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('applicant.index')"  :class="{ 'active': $page.url === '/applicant' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined">
              person
            </i>
            </q-item-section>
            <q-item-section>
              Applicants
        </q-item-section>
          </div>
        </Link>
      </q-item>

      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('all.officer')"  :class="{ 'active': $page.url === '/allofficer' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined">
              local_police
            </i>
            </q-item-section>

            <q-item-section>
              Department Nodals 
            </q-item-section>
          </div>
        </Link>
      </q-item>
      
      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('all.subofficer')"  :class="{ 'active': $page.url === '/allofficer' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined  text-blue-9">
              local_police
            </i>
            </q-item-section>

            <q-item-section>
              Sub-Department Nodals
            </q-item-section>
          </div>
        </Link>
      </q-item>
      
       

      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('appellate.index')"  :class="{ 'active': $page.url === '/admin/appellate' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined text-green-9">
              local_police
            </i>
            </q-item-section>

            <q-item-section>
              Department Appellates
            </q-item-section>
          </div>
        </Link>
      </q-item>
    </div>
  </q-expansion-item>

  <q-expansion-item
  :content-inset-level="0.5"

  expand-separator
  icon="settings"
  label="System"
  caption="">
    <div  >
      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width" :href="route('admin.system.carousel.index')" :class="{'active': $page.url ==='/admin/setting/carousel'}">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
              <i class="q-icon material-icons-outlined">
                wallpaper
              </i>
            </q-item-section>
            <q-item-section>
              Home Carousel
            </q-item-section>
          </div>
        </Link>
      </q-item>

      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width" :href="route('admin.system.hometext.index')" :class="{'active': $page.url ==='/admin/setting/hometext'}">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
              <i class="q-icon material-icons-outlined">
                article
              </i>
            </q-item-section>
            <q-item-section>
              Home Text
            </q-item-section>
          </div>
        </Link>
      </q-item>

      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width" :href="route('maximumday.index')" :class="{'active': $page.url ==='/maximumday'}">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
              <i class="q-icon material-icons-outlined">
                pin
              </i>
            </q-item-section>
            <q-item-section>
              Maximum Days
            </q-item-section>
          </div>
        </Link>
      </q-item>

      <div v-if="CURRENT_USER.role_id==1">
        <q-item clickable v-ripple class="no-padding">
          <Link class="full-width " :href="route('role.index')"  :class="{ 'active': $page.url === '/admin/role' }">
            <div class="row mt-3 ml-5">
              <q-item-section avatar>
              <i class="q-icon material-icons-outlined">
                assignment
              </i>
              </q-item-section>
              
              <q-item-section>
                Role 
          </q-item-section>
            </div>
          </Link>
        </q-item>

        <q-item clickable v-ripple class="no-padding">
          <Link class="full-width " :href="route('action.index')" :class="{ 'active': $page.url === '/admin/action' }">
            <div class="row mt-3 ml-5">
              <q-item-section avatar>
              <i class="q-icon material-icons-outlined">
                call_to_action
              </i>
              </q-item-section>
              
              <q-item-section>
                Action
          </q-item-section>
            </div>
          </Link>
        </q-item>
      </div>
      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('category.index')"  :class="{ 'active': $page.url === '/admin/category' }">
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

      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('quote.index')"  :class="{ 'active': $page.url === '/admin/quote' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined">
              format_quote
            </i>
            </q-item-section>
            
            <q-item-section>
              Quote
        </q-item-section>
          </div>
        </Link>
      </q-item>

      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('feedback.index')"  :class="{ 'active': $page.url === '/admin/feedback' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined">
              feedback
            </i>
            </q-item-section>
            
            <q-item-section>
              Feedback
        </q-item-section>
          </div>
        </Link>
      </q-item>

      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('monthlyLimit.index')"  :class="{ 'active': $page.url === '/admin/monthlyLimit' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined">
              bolt
            </i>
            </q-item-section>
            
            <q-item-section>
              Credit Limit
        </q-item-section>
          </div>
        </Link>
      </q-item>


      <q-item clickable v-ripple class="no-padding">
        <Link class="full-width " :href="route('deletedUser.index')"  :class="{ 'active': $page.url === '/admin/deletedUser' }">
          <div class="row mt-3 ml-5">
            <q-item-section avatar>
            <i class="q-icon material-icons-outlined">
              person_remove
            </i>
            </q-item-section>
            
            <q-item-section>
              Deleted User List
        </q-item-section>
          </div>
        </Link>
      </q-item>

    </div>


  </q-expansion-item>

<q-separator /> 
    
 </template>
 
 <script setup>
 
 import { usePage,Link } from '@inertiajs/vue3'
 import { computed } from 'vue'
 
  const page = usePage()
 
  const CURRENT_USER = computed(() => page.props.CURRENT_USER)
 
 </script>