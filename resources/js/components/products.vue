<template>
        <topbar/>
        <cart />
        <div class="card">
        <div class="card-body">
        <div class="row">
          <div v-for="product in products" key="product.id" class="col-sm-3 mb-2">
            <div class="card border-0">
              <div class="card-body">
                  <div class="justify-content-center">
                    <h5 class="card-title text-center">{{ product.name }}</h5>
                    <img src="/image/cars.png" class="card-img-top img-fluid" alt="...">
                    <p class="card-text text-bold text-danger">${{ product.price }}</p>
                        <p class="card-text">{{ product.description }}</p>
                        <add-to-cart-button :product-id="product.id" :user-id="user.id"/>
                </div>
        </div>
    </div>
  </div>
</div>
</div>
<footer class="navbar navbar-inverse">
    <div class="container d-flex justify-content-center">
      <p class="navbar-text pull-center">&copy; 2023 My ToNote Test Assignment.</p>
    </div>
  </footer>
</div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axiosClient from "../../axios";
import addToCartButton from "./addToCartButton.vue";
import topbar from "./topbar.vue";
import cart from "./cart.vue";


const products = ref([]);

const user = ref({});

onMounted(() => {
    axiosClient.get('/allProducts').then(({data: data}) => {
        products.value = data.data.data;
    });
    axiosClient.get("/user").then(({ data }) => {
            user.value = data;
        })
        .catch((error) => {
            console.log(error);
        });
});

</script>

<style scoped>
.card-img-top {
  height: 100%;
  object-fit: cover;
}
</style>
