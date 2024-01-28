import './bootstrap';
import '../css/app.css';
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/material-icons-outlined/material-icons-outlined.css' 
import 'quasar/src/css/index.sass'

import { createApp, h } from 'vue';
import {  Link,createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { InertiaProgress } from '@inertiajs/progress';
import { Quasar,  Notify, Loading,Dialog } from 'quasar'
import  AuthenticatedLayout  from '@/Layouts/AuthenticatedLayout.vue';
import  GuestLayout  from '@/Layouts/GuestLayout.vue';
import  CitizenLayout  from '@/Layouts/CitizenLayout.vue';
import  LandingLayout  from '@/Layouts/LandingLayout.vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'PGRAMS';
 

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        console.log('name ',name)
          
            const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));

            page.then((module) => {
                if(name.startsWith('Auth/')){
                    module.default.layout = AuthenticatedLayout;
                }else if(name.startsWith('Citizen/')){
                    module.default.layout = CitizenLayout;
                }else if(name.startsWith('Landing/')){
                    module.default.layout = LandingLayout;
                }else{
                    module.default.layout = LandingLayout;
                }
            });
    
            return page;
        },
    
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Quasar,{
                plugins:[Notify,Loading,Dialog],
            })
            .component("Link",Link) //NOTE: THIS IS A GLOBAL DECLARATION. NO NEED TO IMPORT 'LINK' IN ANY COMPONENT
            
            .mount(el);
    },
    progress: {
        color: 'red',        

       showSpinner: true,
    },

    title: title =>'PGRAMS-'+title
    //Note: this title is GLOBAL title
});
