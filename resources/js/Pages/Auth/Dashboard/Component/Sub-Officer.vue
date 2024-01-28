<template>
            
    <h3>Welcome to Mipui Aw</h3>
    <div class="q-pa-md example-row-equal-width">
        <div class="row ">
            
            
            <!-- <div class="p-5" :class="$q.screen.xs ? 'col-12':'col-4'">
                <q-card class="mHoverable my-card bg-green-9 text-white">
                    <q-card-section>
                        <div class="text-center">
                            <div class="text-h2">
                                {{ props.dashboardData.total_grievance_pending??'0' }}
                            </div>
                            <hr>
                            <div class="text-bold">
                                Number of Grievances Pending

                            </div>
                        </div>

                    </q-card-section>
                </q-card>
            </div>

            <Link :href="route('officer.closed')" class="p-5" :class="$q.screen.xs ? 'col-12':'col-4'">
                <q-card class="mHoverable my-card bg-cyan-9 text-white">
                    <q-card-section>
                        <div class="text-center">
                            <div class="text-h2">
                                {{ props.dashboardData.total_grievance_closed??'0' }}

                            </div>
                            <hr>
                            <div class="text-bold">
                                Number of Grievances Closed
                            </div>
                        </div>
                    </q-card-section>
                </q-card>
            </Link>
         -->
             
        </div>
    </div>
</template>

<script setup>

import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'


const page = usePage()
const CURRENT_USER = computed(() => page.props.CURRENT_USER)


const props = defineProps([
    'grievances',
    'dashboardData',

    ])
</script>