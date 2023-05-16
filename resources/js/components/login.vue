<template>
 <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Login</h5>
              <form @submit="login">
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" v-model="user.username" class="form-control" id="username" placeholder="Enter username">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" v-model="user.password" class="form-control" id="password" placeholder="Enter password">
                </div>
                <button @click="login" class="btn btn-primary">Login</button>
              </form>
              <p class="mt-2">Dont have an account?</p>
              <router-link class="mt-1 nav-link-text-blue" :to="{name: 'register'}">Register</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script setup>

import store from "../store/app"
import  { useRouter }  from "vue-router";
import Auth from "../auth";


const user = {
 username: '',
 password: '',
}
const router = useRouter();

function login(ev) {
    ev.preventDefault();
    store.dispatch('login', user)
    .then((data) => {
        Auth.initializeAuthUser(JSON.stringify(data));
       router.push({path: "/"});
    }).catch(() => {
        this.$toast.warning("You need to check your login credentials")
        setTimeout(this.$toast.clear, 3000)
    })
}
</script>

<style>

</style>
