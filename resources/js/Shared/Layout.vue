<template>
     <section class="bg-red-200 p-4">
        <header class="flex justify-between">
            <div class="flex items-center">
                <h1> My App</h1>
                <p class="text-sm ml-4">
                    Welcome, 
                    <!-- The above syntax is for getting data from middleware/HadleinertiaRequest.php (shared function) or only username() inorder to utile the function in computed -->
                </p>
                
            </div>
            <Nav />
        </header>
     </section>
        

     <section class="p-6">
        <div class="max-w-3xl mx-auto">
  
            
            <slot/>
        </div>
        
     </section>
      

      
</template>

<script>
import Nav from "../Shared/Nav.vue";

export default {
    components:{ Nav },

    // computed: {
    //     username() {
    //         return this.$page.props.auth.username;
    //     }
    // },
        //Note: The above could be use if we are going to use middleware data in multiple location

    /*
    1. Default layout ka la hmang lo
    2. Engtin nge extract() hi hman tur

    */
};

</script>