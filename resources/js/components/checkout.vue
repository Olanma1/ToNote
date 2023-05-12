<template>
<topbar/>
<div class="col-md-10 shadow p-3 m-auto mb-3">
        <div class="card mb-4">
             <div class="card-body">
                <div class="card-body text-center">
                        <h1>Payment Instructions</h1>
                        <p>Thank you for your order. Your order is currently pending payment.</p>
                        <p>Please pay the total amount of <h1 class="text-primary">${{ totalPrice }}</h1> on delivery to our delivery driver.</p>
                </div>
            </div>
        </div>
</div>
</template>

<script setup>
import { ref } from 'vue';
import topbar from './topbar.vue';
import { onMounted } from 'vue';
import axiosClient from '../../axios';

const totalPrice = ref(null);

onMounted(() =>{
    axiosClient.get('/cart-products').then(({data: data}) => {
        totalPrice.value = data.totalPrice;
    });
})
</script>

<style>

</style>
