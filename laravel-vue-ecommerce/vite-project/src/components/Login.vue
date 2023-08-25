<template>
  <div class="flex flex-col md:flex-row">
        <div class="w-1/2 md:block hidden">
            <img src="plantimage.png" alt="plantimage" class="w-full h-screen object-cover"/>
        </div>
        <div class="w-full md:w-1/2 flex justify-center items-center bg-gray-100">
            <div class="w-full md:w-96 p-4 md:p-8 bg-white rounded-lg shadow-md">
                <h1 class="logo-h1 text-2xl md:text-4xl font-semibold mb-4 md:mb-6 text-green-500">NewPlants</h1>
                <form @submit="login" class="space-y-4">
                    <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" class="input-field" required v-model="user.email">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" class="input-field" required v-model="user.password">
                </div>
                <button type="submit" class="w-full btn-primary">Log In</button>
                </form>
                <div class="mt-4 text-center">
                <p class="text-sm text-gray-500">Don't have an account?</p>
                <router-link to="/register" class="text-blue-500 hover:underline">Sign Up</router-link>
                </div>
            </div>
            </div>
    </div>
</template>

<script setup>
import store from '../store';
import {useRouter} from 'vue-router';
const router = useRouter();
const user = {
    email: '',
    password: '',    
}

function login(ev) {
    ev.preventDefault();

    store.dispatch('login', user)
        .then(() => {
           router.push({
             name:'Homepage'     
            })
       })
}

</script>

<style scoped>
.logo-h1 {
    color: #2E3A59;
}
.input-field {
    padding: 0.75rem;
    width: 100%;
    border: 1px solid #D1D5DB;
    border-radius:9999px;
    transition: border-color 0.3s ease;
}

.input-field:focus {
    outline: none;
    border-color: #2563EB;
}

.btn-primary {
    background-color: #2563EB;
    color: white;
    padding: 0.75rem;
    border-radius: 0.375rem;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #1E40AF;
}
</style>
