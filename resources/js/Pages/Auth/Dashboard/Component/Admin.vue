<template> 
    <div class="q-pa-md example-row-equal-width">
        <div class="row">
            <Link href="/report/grievancelist" class="p-5" :class="$q.screen.xs ? 'col-12':'col'">
                <q-card class="mHoverable my-card bg-light-blue-9 text-white">
                    <q-card-section>
                        <div class="text-center">
                            <div class="text-h2">
                                {{ props.dashboardData.total_grievance_received??'nil' }}
                            </div>
                            <hr>
                            <div class="text-bold">
                                Total Grievances Registered
                            </div>
                        </div>

                    </q-card-section>
                </q-card>
            </Link>
            <Link  href="/dashboard" class="p-5" :class="$q.screen.xs ? 'col-12':'col'">
                <q-card class="mHoverable my-card bg-green-9 text-white">
                    <q-card-section>
                        <div class="text-center">
                            <div class="text-h2">
                                {{ props.dashboardData.total_grievance_pending??'nil' }}
                            </div>
                            <hr>
                            <div class="text-bold">
                                Number of Grievances Processing

                            </div>
                        </div>

                    </q-card-section>
                </q-card>
            </Link>
            <Link :href="route('officer.closed')" class="p-5" :class="$q.screen.xs ? 'col-12':'col'">
                <q-card class="mHoverable my-card bg-cyan-9 text-white">
                    <q-card-section>
                        <div class="text-center">
                            <div class="text-h2">
                                {{ props.dashboardData.total_grievance_closed??'nil' }}

                            </div>
                            <hr>
                            <div class="text-bold">
                                Number of Grievances Closed
                            </div>
                        </div>
                    </q-card-section>
                </q-card>
            </Link>
        </div>

        <div class="row">
            <Link  :href="route('officer.notyetopen')" class="p-5" :class="$q.screen.xs ? 'col-12':'col'">
                <q-card class="mHoverable my-card bg-purple-9 text-white">
                    <q-card-section>
                        <div class="text-center">
                            <div class="text-h2">
                                {{ props.dashboardData.grievance_not_yet_process??'nil' }}
                            </div>
                            <hr>
                            <div class="text-bold">
                                Number of Grievances not yet open
                            </div>
                        </div>

                    </q-card-section>
                </q-card>
            </Link>

            <Link :href="route('index.sibling',page.props.CURRENT_USER.department_id??'0')" class="p-5" :class="$q.screen.xs ? 'col-12':'col'">
                <q-card class="mHoverable my-card bg-red-10 text-white">
                    <q-card-section>
                        <div class="text-center">
                            <div class="text-h2">
                                {{ props.dashboardData.total_sub_organization??'nil' }}

                            </div>
                            <hr>
                            <div class="text-bold">
                                Total Sub Organization

                            </div>
                        </div>

                    </q-card-section>
                </q-card>
            </Link>
            <div class="p-5" :class="$q.screen.xs ? 'col-12':'col'">
                <q-card class="mHoverable my-card bg-teal-9 text-white">
                    <q-card-section>
                        <div class="text-center">
                            <div class="text-h2">
                                {{ props.dashboardData.total_appeal??'nil' }}
                            </div>
                            <hr>
                            <div class="text-bold">
                                Number of Appeal
                            </div>
                        </div>
                    </q-card-section>
                </q-card>
            </div>
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