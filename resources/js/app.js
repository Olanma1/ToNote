import "./bootstrap";
import "../sass/app.scss";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "bootstrap";
import Toaster from '@meforma/vue-toaster';

createApp(App)
  .use(router)
  .use(Toaster)
  .mount("#app")
