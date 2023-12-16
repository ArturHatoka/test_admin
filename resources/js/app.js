import './bootstrap';
import { createApp } from 'vue';
import MainComponent from "./MainComponent.vue";

const app = createApp({});
app.component('main-component', MainComponent);
app.mount('#app');
