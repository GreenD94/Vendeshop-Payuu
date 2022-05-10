require('./bootstrap');

import { createApp } from 'vue'



const app = createApp({});

// registers our HelloWorld component globally
app.component('home-component', require('./component/home/HomeComponent.vue').default);


// mount the app to the DOM
app.mount('#app');
