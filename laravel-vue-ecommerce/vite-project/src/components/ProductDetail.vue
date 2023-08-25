<template>
  <Layout />
  
  <div class="flex flex-col-reverse md:flex-row">
    <div class="w-full md:w-1/2 bg-gray-100 p-4">
      <div class="product-image h-full flex justify-center items-center">
        <img :src="Products[0]?.image_url" class="max-h-full" />
      </div>
    </div>
  <div class="w-full md:w-1/2 p-4">
    <div v-for="product in Products" :key="product.id" class="mb-8">
      <h2 class="text-xl md:text-3xl font-semibold">{{ product.name }}</h2>
      <p class="text-base md:text-2xl font-semibold mt-2">${{ product.selling_price }}</p>
      <div class="bg-gray-200 h-0.5 mt-4"></div>
      <p class="text-gray-600 italic mt-2">{{ product.description }}</p>
      <button @click="addToCart" class="mt-4 px-4 py-2 w-full bg-emerald-300 hover:bg-red-500 text-white font-semibold rounded">
        Add to Cart
      </button>
          <Cart ref="cartComponent" :showCart="isCartVisible" :product="Products[0]" :quantity="quantity" @hide-cart="hideCart" @toggle-cart="toggleCart" />
    <div class="mt-2">
          <div class="flex items-center">
            <label for="quantity" class="mr-2 text-gray-600 font-medium">Quantity</label>
            <div class="flex items-center border rounded-md overflow-hidden">
              <button @click="decrementQuantity" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
              </button>
              <input type="text" name="quantity" class="w-12 text-center bg-white focus:outline-none" v-model="quantity">
              <button @click="incrementQuantity" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="mt-8">
          <h3 class="text-xl font-semibold mb-4">You might also like:</h3>
          <div class="grid grid-cols-3 gap-6">
            <div v-for="trendingProduct in trendingProducts" :key="trendingProduct.id">
              <router-link
              :key="trendingProduct.id"
              :to="'/product/' + trendingProduct.id"
             >
                <img :src="trendingProduct.image_url" class="max-h-24 mb-2" />
                <p class="text-gray-600">{{ trendingProduct.name }}</p>
                <p class="text-green-500 font-semibold">${{ trendingProduct.selling_price }}</p>
            </router-link>
            </div>
          </div>
       </div>
        

      </div>
    </div>
  </div>
</template>

<script>
import { computed, ref } from 'vue';
import { watch } from 'vue';
import { useRoute } from 'vue-router';
import Layout from './Layout.vue';
import Cart from './Cart.vue';
import { useStore } from 'vuex';

export default {
  components: {
    Layout,
    Cart,
  },
  setup() {
    const store = useStore();
    const route = useRoute();
    const productIds = ref(route.params.id);

    const quantity = ref(1);
    const isCartVisible = ref(false);
    watch(
      () => route.params.id,
      (newProductId) => {
        productIds.value = newProductId;
        store.dispatch('fetchProduct', newProductId);
      }
    );
    const addToCart = (productId) => {
      store.dispatch('addToCart', { productId: productIds.value, quantity: quantity.value });
      isCartVisible.value = true;
    };

    const trendingProducts = computed(() => store.state.trendingProducts);
    const Products = computed(() => store.state.products.filter(product => product.id == productIds.value));

    store.dispatch('fetchProduct', productIds.value);
    store.dispatch('fetchTrendingProducts');

    return {
      quantity,
      isCartVisible,
      addToCart,
      trendingProducts,
      Products,
    };
  },
  methods: {
    async addToCart() {
      const productId = this.Products[0]?.id;
      this.$store.dispatch('addToCart', { productId, quantity: this.quantity });
      this.isCartVisible = true;
    },
    
    hideCart() {
      this.isCartVisible = false;
    },
    decrementQuantity() {
      if (this.quantity > 1) {
        this.quantity--;
      }
    },
    incrementQuantity() {
      this.quantity++;
    },
    toggleCart() {
     // console.log('Received toggle-cart event in ProductDetails');

      this.isCartVisible = !this.isCartVisible; 
    },

  }
};
</script>

<style scoped>
</style>
