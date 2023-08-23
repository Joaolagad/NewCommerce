<template>
     <div v-if="showCart" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
      <div class="bg-white p-4 rounded w-96">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold">Your Cart</h3>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2 cursor-pointer" @click="$emit('hide-cart')">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>

        <ul>
          <li v-for="item in cartItems" :key="item.id" class="mb-2">
            <div class="flex items-center">
                <img :src="item.product.image_path" alt="Product" class="w-12 h-12 mr-2 rounded">
              <div>
                <p class="font-semibold">{{ item.product.name }}</p>
                <p>Price per unit: ${{ item.product.selling_price }}</p>
                <p>Quantity: {{ item.prod_qty }}</p>
                <p>Total Price: ${{ totalprice(item) }}</p> 
              </div>
            </div>
          </li>
        </ul>
        <p class="mt-4 text-sm text-gray-500">
          We take great care of our plants to ensure they thrive. Thank you for choosing us as your plant provider!
        </p>
        <button type="button" @click.prevent="handleCheckout" class="mt-4 bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
          Proceed to Checkout
        </button>
          
      </div>
    </div>
  </template>
  
  <script>
  import { computed, onMounted } from 'vue';
  import { useStore } from 'vuex';
  import { loadStripe } from '@stripe/stripe-js';
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import axiosClient from '../axios';
  export default {
    props: {
      showCart: Boolean,
    },
  
    setup(props, ) {
    const STRIPE_PUBLISHABLE_KEY = 'pk_test_51Nh9BVDtBBIjZBi6oE0gITyRp7o0CHzxfDzWNkcuxGOHOsw9T6xciL7Ikndl2P4By82MmYRy7iLMgUSeccx7Jbt900wGEgRLsL';
    const store = useStore();
    const router = useRouter(); 


    const handleCheckout = async () => {
      if (!store.state.user.token) {
        router.push('/login');
        return;
      }
    try {
        const response = await axiosClient.post('checkout');
        const sessionUrl = response.data.url;
        window.location.href = sessionUrl;
    } catch (error) {
       // console.error('Error during checkout:', error);
    }
};


      onMounted(() => {
        store.dispatch('fetchCartItems');
      });
  
      const cartItems = computed(() => {
        const items = store.getters.getCartItems;
        items.forEach(item => {
          item.product.image_path = 'http://localhost:8000/assets/uploads/products/' + item.product.image;
        });
        return items;
      });
  
      const totalprice = (item) => {
        return (item.product.selling_price * item.prod_qty).toFixed(2);
      };
      
      return {
        cartItems,
        totalprice,
        handleCheckout,

      };
    },
    methods: {
      hideCart() {
        this.$emit('hide-cart')
      },
      
    },
  };
  </script>
  <style>
  
</style>
  