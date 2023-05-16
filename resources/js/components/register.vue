<template>
    <div class="container mt-5">
         <div class="row justify-content-center">
           <div class="col-md-6">
             <div class="card">
               <div class="card-body">
                 <h5 class="card-title">Register</h5>
                 <form @submit="register">
                   <div class="mb-3">
                     <label for="username" class="form-label">Name</label>
                     <input type="text" v-model="user.name" class="form-control" id="name" placeholder="Enter name">
                   </div>
                   <div class="mb-3">
                     <label for="username" class="form-label">Username</label>
                     <input type="text" v-model="user.username" class="form-control" id="username" placeholder="Enter username">
                   </div>
                   <div class="mb-3">
                     <label for="password" class="form-label">Password</label>
                     <input type="password" v-model="user.password" class="form-control" id="password" placeholder="Enter password">
                   </div>
                   <button  @click.stop="register" class="btn btn-primary">Register</button>
                 </form>
                 <p class="mt-2">Already have an account?</p>
              <router-link class="mt-1 nav-link-text-blue" :to="{name: 'login'}">Login</router-link>
               </div>
             </div>
           </div>
         </div>
    </div>
</template>

<script setup>
import store from "../store/app";
import  { useRouter }  from "vue-router";
import Auth from "../auth";
import Toaster from '@meforma/vue-toaster';

  const user = {
    name: '',
    username: '',
    password: '',
}
const router = useRouter();
function register(ev) {
    ev.preventDefault();
    store.dispatch('register', user)
    .then((data) => {
        Auth.initializeAuthUser(JSON.stringify(data));
        router.push({path: "/"})
    }).catch(() => {
        this.$toast.warning("credentials already exists")
        setTimeout(this.$toast.clear, 3000)
    })
}
   </script>

   <style>

   </style>
