<template>
    <Head title="Dashboard" />
        <form @submit.prevent="submit">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="text-lg text-grey-7 border p-3 bg-blue-1">
                            Note: Any grievances concerning the state government as a unified entity should be directed to the Department of Personnel and Administrative Reforms (DP&AR)
                        </div>
                        <div class="p-6  ">
                            <div>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Step 2</h2>
                            </div>
                            <p>Select Department</p>
                            <div class="">
                                <div class="q-gutter-md">
                                    <q-select
                                     
                                        v-model="form.department"
                                        use-input
                                        input-debounce="0"
                                        label="Department"
                                        :options="options"
                                        @filter="filterFn"
                                        style="width: 250px ;"
                                        behavior="menu"      
                                        :options-html="true"                                             
                                    >

                                    </q-select>
                                <div v-if="props.errors.department" v-text="props.errors.department" class="text-red-500 text-xs mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-5">
                            <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
                                Next
                            </button>
                        </div>
                    <div v-if="x_message" class="bg-red-2 border-red-9 mt-5 p-4   border-2" >
                        <div class="text-red-9 text-h6 text-bold">
                            WARNING!
                        </div>
                        <div class="text-grey-9">
                            {{ x_message }}    
                        </div>
                        

                    </div>
                </div>
                
            </div>
        </form>
</template> 

<script setup>
import { Head,usePage } from '@inertiajs/vue3';
import { ref,computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
 
const page = usePage()

const x_message = computed(() =>page.props.flash.message)

const props = defineProps({
    errors:Object,
    agree:'',
    departments:'',


});

const options = ref(props.departments)

let form = useForm({
    department:'',
});

const filterFn = (val,update)=>{
    if(val){
        update(() => {
            options.value = props.departments.filter(item=>item.label.toLowerCase().includes(val.toLowerCase()))
        })
        return
    }
    update(() => {
        options.value=props.departments
    })
}

let submit=()=>{
    form.get('/grievance3');
};

</script> 