<template>
     <topbar/>

     <div class="col-md-6 shadow p-3 m-auto">
                <div class="card-header">
                  <h4>Orders</h4>
                </div>
                <div
                    v-if="cartItems.length === 0"
                    class="row p-3 mx-2 rounded bg-white"
                    style="max-width: 800px"
                    >
                    <p class="col">
                        You currently have no products in your cart.
                    </p>
                    </div>
                <div v-if="loaded" class="card d-flex justify-content-center">
                  <div v-for="product in cartItems" key="product.id" class="card-body">
                      <div class="mb-1 col-sm-4">
                        <img src="/image/cars.png" class="card-img-top img-fluid" alt="...">
                      </div>
                      <div>
                        <p
                          >quantity: {{ product.quantity }}</p>
                      </div>
                      <div>
                        <p
                          >price: ${{ product.price }}</p>
                      </div>
                      <p @click="removeProduct(product.id)" type="submit" class="text-danger">
                        remove
                      </p>
                  </div>
                  <div v-if="cartItems.length > 0">
                    <div class="form-check mb-3">
                        <input class="form-check-input ml-3" type="radio" name="payment_method" id="pay_on_delivery" value="pay_on_delivery">
                        <label class="form-check-label" for="pay_on_delivery">
                            Pay on delivery
                        </label>
                    </div>
                  <div class="card-footer">
                    <div class="total">
                        <h3 class="font-bold">Total: ${{ totalPrice }}</h3>
                    </div>
                    <div class="checkout">
                    <router-link :to="{name: 'checkout'}">
                        <button @click.stop="checkOut()" class="btn btn btn-warning"> checkout </button>
                    </router-link>
                  </div>
                  </div>
                </div>
            </div>
              </div>

</template>

<script setup>
import { onMounted, ref } from "vue";
import topbar from "./topbar.vue";
import axiosClient from "../../axios";
import router from "../router";



const cartItems = ref([]);
const loaded = ref(false);
const totalPrice = ref(null);

onMounted(() =>{
    axiosClient.get('/cart-products').then(({data: data}) => {
        cartItems.value = data.data;
        loaded.value = true;
        totalPrice.value = data.totalPrice;
    });
})
function checkOut(){
    axiosClient.post('/order').then(() => {
        router.replace({name: "checkout"});
    });
}
function removeProduct(id){
    axiosClient.delete(`/cart/${id}`).then(() => {
        setTimeout(() => {
            window.location.reload();
        }, 500);
    });
}
</script>

<style scoped>
.card-img-top {
  height: 20%;
  object-fit: cover;
}
.card-footer {
  display: flex;
  justify-content: space-between;
}
.total {
  order: 1;
}
.checkout {
  order: 2;
}

</style>
