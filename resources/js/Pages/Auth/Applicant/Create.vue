<template>
    <Head  title="Create User"></Head>

        <div class="">
            <form @submit.prevent="submit">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h4 class="mb-2">Create User</h4>
                        <q-btn  href="#" onclick="history.back();return false;" color="primary" label="Back" />

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            
                            <div class="p-6 text-gray-900 ml-3">
                                <div class="ml-3 mb-5">
                                    <div class="mb-8 flex justify-center">
                                        Add User
                                    </div>
                                </div>
                                <div>
                                    <q-input v-model="form.name" label="Full Name"   >
                                        <template v-slot:label>
                                            Name <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-input>
                                    <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-3"></div>
                                </div>
                                <div>
                                    <q-input v-model="form.mobile" 
                                    label="Mobile"
                                    mask="##########"
                                    :rules="[val => val.length ==10 || 'Must be 10 digits']"
                                    maxlength="10"
                                    counter
                                    >
                                    <template v-slot:label>
                                            Mobile <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-input>
                                    <div v-if="form.errors.mobile" v-text="form.errors.mobile" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.email" label="Email"   >
                                        <template v-slot:label>
                                            Email <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-input>
                                    <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-3"></div>
                                </div>
                                <div>
                                    <q-input v-model="form.password" label="password"   >
                                        <template v-slot:label>
                                            Password <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-input>
                                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-3"></div>
                                </div>
                                <div>
                                    <q-input v-model="form.password_confirmation" label="Password confirmation"   >
                                        <template v-slot:label>
                                            Confirm Password <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-input>
                                    <div v-if="form.errors._confirmation" v-text="form.errors._confirmation" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-select
                                        v-model="form.gender"  
                                        input-debounce="0"
                                        label="Gender"
                                        :options="gender"
                                        style="width: 250px"
                                    >
                                    <template v-slot:label>
                                            Gender <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-select>
                                    <div v-if="form.errors.gender" v-text="form.errors.gender" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.address" label="Residential Address"   >
                                        <template v-slot:label>
                                            Residential Address <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-input>
                                    <div v-if="form.errors.address" v-text="form.errors.address" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.pincode" label="Pincode"   >
                                        <template v-slot:label>
                                            Pincode <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-input>
                                    <div v-if="form.errors.pincode" v-text="form.errors.pincode" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-input v-model="form.alternate_mobile" label="Alternate Mobile (Optional)"   >
                                        <template v-slot:label>
                                            Alternate Mobile (Optional)<span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-input>
                                    <div v-if="form.errors.alternate_mobile" v-text="form.errors.alternate_mobile" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-select
                                        v-model="form.district"  
                                        input-debounce="0"
                                        label="District"
                                        :options="districts"
                                        style="width: 250px"
                                    >
                                    <template v-slot:label>
                                            District <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-select>
                                    <div v-if="form.errors.district" v-text="form.errors.district" class="text-red-500 text-xs mt-3"></div>
                                </div>

                                <div>
                                    <q-select
                                        v-model="form.active"  
                                        input-debounce="0"
                                        label="Active"
                                        :options="active"
                                        style="width: 250px"
                                    >
                                    <template v-slot:label>
                                            Active <span class="text-red"><sup>*</sup></span>
                                        </template>
                                    </q-select>
                                    <div v-if="form.errors.active" v-text="form.errors.active" class="text-red-500 text-xs mt-3"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
                                Create
                            </button>
                        </div>
                    
                    </div>
                </div>
            </form>
        </div>
    
</template>
<script setup>
import { useForm,Head } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import { ref,onMounted } from 'vue';

const q= useQuasar()
const gender =['Female','Male']
const districts=[  'Aizawl','Lunglei','Champhai','Kolasib','Serchhip','Mamit','Siaha','Lawngtlai','Khawzawl','Saitual','Hnahthial',]
const active=[{label:'Yes',value:1},{label:'No',value:0}]

const props = defineProps({
    errors:Object,
 
})

let form = useForm({
    name:'',
    mobile:'',
    email:'',
    password:'',
    password_confirmation:'',
    gender:'',
    address:'',
    pincode:'',
    alternate_mobile:'',
    district:'',
    active:'',

})
 

 
let submit=()=>{

     
    form.post('/applicant',{
        onStart:()=>q.loading.show({message:'Creating...'}),
        onFinish:()=>{
            q.loading.hide()
        }
    })
    // form.transform((data) => ({
    //     ...data,
    //     department:mDepartmentID
    // })).post('/admin/category')
}


</script>