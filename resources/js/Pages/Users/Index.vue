<template>
    <Layout>
     <Head title="User">
         
     </Head>
        <div>
            <div class="flex justify-between">
                <div class="flex items-center">
                    <h1>Users</h1>
                    <Link href="/users/create" class="text-blue-500 text-sm ml-3 " >New user</Link>
                </div>
                
                <input v-model="search" type="text" placeholder="Search..." class="border px-2 rounded-lg">

            </div>
             
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="m-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="user in users.data" :key="user.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ user.name }}
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <!--  <Link :href="'/users/'+user.id+'/edit'" class="text-indigo-600 hover:text-indigo-900">Edit</Link>-->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
           <Pagination :links="users.links" />

            
        </div>
    </Layout>
</template>

<script   >
import Pagination from '@/Shared/Pagination.vue';
import { ref } from "vue";

//import { Link } from "@inertiajs/vue3"; //Link pawh hi dah lo mah ila a dik tho ag. globally in kan import toh app.js
 
// let search = ref('');
 export default {
        
    props:{
        users:Object
    }
}
 
//     // components: {Link}, //NOTE: Link is already declare globally in middle app.js

 
</script>