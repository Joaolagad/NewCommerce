import {createStore} from 'vuex';
import axiosClient from '../axios';
const store = createStore({
    state: {
        user: {
          data: {},
          token: sessionStorage.getItem('TOKEN'),
        },
        categories: [],
        products: [],
        trendingProducts: [],
        cartItems: [],
        cartCount: 0,
        searchResults: [],
    },
    getters: {
        getCategories(state) {
            return state.categories;
        },
        getProductsByCategory: (state) => (categoryId) => {
            return state.products.filter(product => product.category_id === categoryId);
        },
        getProduct: (state) => (productId) => {
            return state.products.filter(product => product.id === productId);
          },
        getTrendingProducts(state) {
            return state.trendingProducts
        },
        getCartItems(state) {
            return state.cartItems;
        },
        getSearchResults(state) {
          return state.searchResults;
        }
    },
    actions: {
      async fetchInitialCartCount({ commit, state }) {
        try {
          const response = await axiosClient.get('/initial-cart-count', {
            params: {
              user_id: state.user.data.id 
            }
          });
      
          const cartCount = response.data.cartCount;
          commit('SET_CART_COUNT', cartCount);
          return cartCount;
        } catch (error) {
          //console.error('Error fetching initial cart count:', error);
        }
      },
      

      logout({commit}) {
        return axiosClient.post('/logout')
          .then(response => {
            commit('logout')
              return response;
          })
      },
      register({commit}, user) {
        return axiosClient.post('/register', user)
          .then(({data}) => {
            commit('setUser', data);
            sessionStorage.setItem('USER_DATA', JSON.stringify(data.user));

            //console.log('data reg', data)
            return data;
          })
      },
      login({commit}, user) {
        return axiosClient.post('/login', user)
          .then(({data}) => {
            commit('setUser', data);
            sessionStorage.setItem('USER_DATA', JSON.stringify(data.user));

            //console.log('data log', data)

            return data;
          })
      },
      async checkout({ commit }) {
        try {
            const response = await axiosClient.post('/checkout');
            const sessionUrl = response.data.url;
            commit('SET_CART_ITEMS', sessionUrl);

            return sessionUrl; 
        } catch (error) {
            throw error;
        }
    },
    
      
      async searchProducts({ commit }, results) { 
          commit('SET_SEARCH_RESULTS', results);
       
      },
      async addToCart({ commit, state, dispatch }, { productId, quantity }) {
        try {
          const requestData = {
            product_id: productId,
            quantity: quantity,
            user_id: state.user.data.id,
          };
          const response = await axiosClient.post('/add-to-cart', requestData);
          commit('ADD_TO_CART', response.data.cartItem);
          commit('SET_CART_COUNT', response.data.cartCount);
          
          
        } catch (error) {
          throw error;
        }
      },

          async fetchCartItems({ commit }) {
            try {
              const response = await axiosClient.get('/get-cart-items');
              commit('SET_CART_ITEMS', response.data);
          //    console.log(response.data)
            } catch (error) {
              throw error;
            }
          },
        
        async fetchTrendingProducts({commit}) {
            try {
                const response = await axiosClient.get('/trending-products');
                commit('SET_TRENDING_PRODUCTS', response.data);
                
            }catch (error) {
                throw error;
            }
        },
        async fetchProduct({ commit }, productId) {
            try {
              const response = await axiosClient.get(`/product/${productId}`);
              commit('SET_SELECTED_PRODUCT', [response.data]); 
            } catch (error) {
              throw error;
            }
          },
        async fetchProductsCategory({commit}, categoryId) {
            try {
                const response = await axiosClient.get(`/products/category/${categoryId}`);
                commit('SET_PRODUCTS', response.data);
            //    console.log('data', response.data)
            } catch (error) {
                throw error;
            }

        },
        async fetchCategory({commit}) {
            try {
                const response = await axiosClient.get('/categories');
                commit('SET_CATEGORIES', response.data);
            } catch (error) {
                throw error

            }
        },
    },
    mutations: {
        
        SET_CATEGORIES(state, categories) {
            state.categories = categories;
        },
        SET_PRODUCTS(state, products) {
            state.products = products;
        },
        SET_SELECTED_PRODUCT(state, products) {
            state.products = Array.isArray(products) ? products : [products]; 

        },
        SET_TRENDING_PRODUCTS(state, trendingProducts) {
            state.trendingProducts = trendingProducts;
        },
        ADD_TO_CART(state, cartItem) {
            state.cartItems.push(cartItem);
//            console.log('Cart Items:', state.cartItems); 

          },
          SET_CART_COUNT(state, cartCount) {
            state.cartCount = cartCount;
          },
          SET_CART_ITEMS(state, cartItems) {
//            console.log('Setting cart items:', cartItems); 
            state.cartItems = cartItems;
          },
          SET_SEARCH_RESULTS(state, results) {
            state.searchResults = results;
          },
          setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.user;
            sessionStorage.setItem('TOKEN', userData.token);
          },
          logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem('TOKEN');
          }
        
    },
})

export default store
