<template>
      <div class="bg-green-500 py-2">
        <div class="text-white hidden lg:block text-center text-lg font-bold">
              <h1>Free Shipping</h1>
          </div>
        <div class="block sm:hidden mt-4 text-white text-center text-lg font-bold">
              <h1>Free Shipping</h1>
          </div>
      </div>
      <div class="bg-white p-4 flex flex-wrap items-center justify-between">
        <router-link to="/" class="flex items-center">
         <h1 class="logo-h1 text-2xl">NewPlants</h1>
        </router-link>

        <div class="flex items-center space-x-4">
              <div class="w-6 h-6 cursor-pointer hidden lg:block">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                  </svg>
              </div>
              <div class="ml-2 hidden lg:block">
                  <h5 class="font-semibold">Quick Search</h5>
                  <input 
                    v-if="searchActive"
                    v-model="searchQuery"
                    @keyup.enter="performSearch"
                    @blur="searchActive = false"
                    class="text-sm w-32"
                    />
                  <span v-else @click="searchActive = true"
                    class="text-sm cursor-pointer">
                    Press Here
                  </span>
                  <button @click="performSearch" class="text-sm cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-3">
                      <path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
                    </svg>
                  </button>
              </div>
            </div>
            <div class="flex items-center space-x-4">
              <div class="w-6 h-6">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                  </svg>
              </div>
              <div v-if="user.token" class="ml-2">
                    <h5 class="font-semibold">Hello, {{ user.data.name }}</h5>
                    <span class="text-sm">Let's buy some plants!</span>
              </div>
              <div v-else class="ml-2">
                  <router-link to="/login">
                    <h5 class="font-semibold">Hello, Sign In</h5>
                    <span class="text-sm">Let's take care of some plants together!</span>
                  </router-link>
              </div>
            </div>
            <div class="relative">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer" @click="isCartVisible = !isCartVisible">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
              </svg>
              <div
                  v-if="cartCount > 0 || initialCartCountFetched" 
                  class="absolute bottom-4 left-3 bg-red-500 rounded-full w-5 h-5 flex justify-center items-center text-xs text-white"
                >
                  {{ cartCount }}
                </div>
              <div>
                <Cart :showCart="isCartVisible" @hide-cart="isCartVisible = false"/>
              </div>
            </div>
            <div v-if="user.token">
              <button @click="logout">
                <h2 class="italic semi-bold relative cursor-pointer">Logout</h2>
              </button>
            </div>
            <div v-else>
            </div>

      </div>
      
      <div class="bg-gray-200 h-0.5 my-4"></div>
      <div class="hidden lg:flex justify-center space-x-4">
            <a href="#" class="px-4 py-2 hover:bg-gray-200 rounded-md">
          Plants
        </a>
        <a href="#" class="px-4 py-2 hover:bg-gray-200 rounded-md">
          Flowers
        </a>
        <a href="#" class="px-4 py-2 hover:bg-gray-200 rounded-md">
          Seeds
        </a>
        <a href="#" class="px-4 py-2 hover:bg-gray-200 rounded-md">
          Gifts for friends
        </a>
        <a href="#" class="px-4 py-2 hover:bg-gray-200 rounded-md">
          Romantic Plants
        </a>
        <a href="#" class="px-4 py-2 hover:bg-gray-200 rounded-md">
          Bonsai
        </a>
        <a href="#" class="px-4 py-2 hover:bg-gray-200 rounded-md">
          Decoration
        </a>
        <a href="#" class="px-4 py-2 hover:bg-gray-200 rounded-md">
          Garden
        </a>
      </div>
</template>
<script>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { mapState } from 'vuex';
import { mapActions } from 'vuex';
import {ref} from 'vue';
import Cart from './Cart.vue'; 
import store from '../store';
import axiosClient from '../axios';
export default {
  components: {
    Cart,
  },
  data() {
    return {
      isCartVisible: false,
      searchActive: false,
    };
  },
  setup() {
    const searchQuery = ref('');
    const router = useRouter();
    const initialCartCountFetched = ref(false); 


    function performSearch() {
      const searchUrl = '/products?search=' + encodeURIComponent(searchQuery.value);

      axiosClient
        .get(searchUrl)
        .then(response => {
          store.dispatch('searchProducts', response.data);
          router.push({
            name: 'SearchResults',
            query: { search: searchQuery.value},
          });
        })
        .catch(error => {
          //console.log('did not work', error);
        });
    }
    function logout() {
      store.commit("logout")
      
    }
    onMounted(() => {
      store.dispatch('fetchInitialCartCount');
      
      initialCartCountFetched.value = true; 


      const userToken = sessionStorage.getItem('TOKEN');
      const userData = JSON.parse(sessionStorage.getItem('USER_DATA'));

      if (userToken && userData) {
        store.commit('setUser', { token: userToken, user: userData });
      }
    });

    return {
      searchQuery,
      performSearch,
      logout,
      initialCartCountFetched,

    };

  },
  computed: {
    ...mapState(['cartCount', 'user']),
    ...mapActions(['fetchInitialCartCount']) 
  },
  methods: {
    toggleCart() {
      this.isCartVisible = !this.isCartVisible; 
    },
    hideCart() {
      this.isCartVisible = false; 
    },
       
  
  },

};
</script>
<style>
</style>