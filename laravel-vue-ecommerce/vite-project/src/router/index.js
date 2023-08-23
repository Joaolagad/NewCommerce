import {createRouter, createWebHistory} from 'vue-router';
import Homepage from '../views/Homepage.vue';
import CategoryProducts from '../components/CategoryProducts.vue';
import ProductDetail from '../components/ProductDetail.vue';
import SearchResults from '../components/SearchResults.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
const routes = [   
        {
            path:'/',
            name: 'Homepage',
            component: Homepage,
        
        
        },
        {
          path: '/searchresults',
          name: 'SearchResults',
          component: SearchResults,
        },
        
        {
            path: '/category/:id',
            name: 'CategoryProducts',
            component: CategoryProducts,
          },

          {
            path: '/login',
            name: 'Login',
            component: Login,
          },
        
          {
            path: '/register',
            name: 'Register',
            component: Register,
          },
          
          {
            path: '/product/:id',
            name: 'product-detail',
            component: ProductDetail,
          },
    ];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;