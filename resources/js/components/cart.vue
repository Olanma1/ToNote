<template>
    <div class="d-flex justify-content-end">
        <router-link :to="{ name: 'cart' }">
            <button class="btn btn-warning btn-sm mb-2">Cart {{ itemCount }}</button>
        </router-link>
        </div>
  </template>

  <script>
  import { ref, onMounted } from 'vue';
  import axiosClient from "../../axios";

  export default {
    setup() {
        const itemCount = ref(null);

        const getCartProducts = async () => {
           await axiosClient.post("/cart").then((response) =>{
            itemCount.value = response.data.data;
            console.log(itemCount);
          });
        }
        onMounted(() => {
            getCartProducts()
      });

      return {
      itemCount,
      getCartProducts,
    };
    }
}
  </script>
