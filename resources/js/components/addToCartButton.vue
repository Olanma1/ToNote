<template>
  <div>
    <hr/>
    <button @click.prevent="addProductToCart()" class="btn btn-warning btn-sm text-center">
        Add to cart
    </button>
  </div>
</template>

<script>
import axiosClient from "../../axios";

export default {
    props: ['productId', 'userId'],
    methods: {
       async addProductToCart(){
           if(this.userId == 0){
                this.$toast.warning("You need to login to add this product to cart")
                setTimeout(this.$toast.clear, 3000)
           }
           let response = await axiosClient.post("/cart", {
                'product_id' : this.productId,
           }).then((response) =>{
                response.data.data;
                this.$toast.warning("You have added this product to cart")
                setTimeout(this.$toast.clear, 3000)
        })
        }
    },
}
</script>

<style>

</style>
