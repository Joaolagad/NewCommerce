<template>
    <Layout/>
    
    <div class="text-3xl md:text-5xl text-center looking font-semibold text-green-500 my-6 md:my-8">
      {{ categoryProducts[0]?.category.name }}
    </div>    
    <div class="bg-gray-300 h-0.5 my-4"></div>
    
    <div class="p-4 md:p-8 text-center">
     <p class="text-xl md:text-2xl font-semibold looking">
        Bring nature home with our exquisite selection of flowers, plants, and bonsai.
      </p>
    </div>
    
    <div class="flex flex-col md:flex-row md:flex-wrap justify-center p-4 md:p-8">
        
        <div v-for="product in categoryProducts" :key="product.id" class="w-full md:w-1/3 p-2 md:p-4">
                <router-link
                    v-for="product in categoryProducts"
                    :key="product.id"
                    :to="'/product/' + product.id"
                    class="block"
                > 
                    <div class="rounded-lg shadow-md overflow-hidden">
                        <img :src="product.image_url" alt="Product Image" class="h-40 md:h-60 w-full object-cover" />
                        <div class="p-2 md:p-4">    
                            <h2 class="text-lg md:text-xl font-semibold mb-1 md:mb-2">{{ product.name }}</h2>
                            <p class="text-sm md:text-base text-gray-600">{{ product.small_description }}</p>
                            <div class="mt-2 md:mt-4 flex justify-between items-center">
                                <span class="text-base md:text-lg text-green-500 font-semibold">
                                ${{ product.selling_price}}
                                </span>
                            </div>
                        </div>
                    </div>
                </router-link>
            </div>
            
    </div>
  </template>
  
  
<script>
import {computed} from 'vue';
import { useRoute, useRouter } from 'vue-router'; // Import useRouter
import store from '../store';
import Layout from './Layout.vue'
export default {
    components: {
        Layout
    },
    computed: {
        categoryProducts() {
            const route = useRoute();
            const categoryId = route.params.id;
            return store.state.products.filter(product => product.category_id == categoryId);
        },
    },

    created() {
        const route = useRoute();
        const categoryId = route.params.id;

        store.dispatch('fetchProductsCategory', categoryId);
    },
   
    

    
};
</script>
<style>
</style>