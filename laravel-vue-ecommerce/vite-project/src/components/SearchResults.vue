<template>
  <Layout />
  <div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Search Results</h2>
    <ul class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
      <li v-for="product in products" :key="product.id" class="bg-white p-4 rounded shadow-md">
        <div class="mb-2">
          <img :src="product.image_url" alt="Product" class="w-full h-40 object-cover rounded">
        </div>
        <h3 class="text-lg font-semibold mb-1">{{ product.name }}</h3>
        <p class="text-gray-600 mb-2">Category: {{ product.category_name }}</p>
        <p class="text-gray-800">${{ product.selling_price }}</p>
        <button @click="navigateToProductDetail(product.id)" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-red-600">
          See More
        </button>
      </li>
    </ul>
  </div>
</template>

<script>
import Layout from './Layout.vue';
export default {
  components: {
    Layout
  },
  name: 'SearchResults',
  computed: {
    products() {
      return this.$store.getters.getSearchResults;
    }
  },
  methods: {
    navigateToProductDetail(productId) {
      this.$router.push({ name: 'product-detail', params: { id: productId } });
    }
  }
};
</script>
  <style>
  </style>
  