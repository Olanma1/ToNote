import { createRouter, createWebHistory } from "vue-router";
import store from "../store/app";
import login from "../components/login.vue";
import register from "../components/register.vue";
import products from "../components/products.vue";
import cartPage from "../components/cartPage.vue";
import checkout from "../components/checkout.vue";




const routes = [
    {
        path: "/",
        name: "products",
        component: products,
        meta: {
            requiresAuth: true,
          },
    },
    {
        path: "/cart",
        name: "cart",
        component: cartPage,
        meta: {
            requiresAuth: true,
          },
    },
    {
        path: "/checkout",
        name: "checkout",
        component: checkout,
        meta: {
            requiresAuth: true,
          },
    },
    {
        path: "/login",
        name: "login",
        component: login,
    },
    {
        path: "/register",
        name: "register",
        component: register,
    },
]


const router = createRouter({
    history: createWebHistory(),
    routes,
  });
  router.beforeEach((to,from,next) => {
    if(to.meta.requiresAuth && !store.state.user.token){
        next({path: "/register"})
    }else if(store.state.user.token && (to.path === "/login" || to.path ==="/register"))
        {
         next({path: "/"});
        }else {
            next();
        }
    })
  export default router;
