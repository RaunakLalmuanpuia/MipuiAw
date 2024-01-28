<template>
    <nav >
        <ul class="flex list-disc space-x-4 list-inside">
            <li><Link href="/" :class="{'font-bold underline':$page.component==='Welcome'}">Home</Link></li>
            <li><Link href="/users" :class="{'font-bold underline':$page.component==='Users/Index'}">Users</Link></li>
        </ul>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/vue3'; 

export default{
    components: {Link},

};
</script>