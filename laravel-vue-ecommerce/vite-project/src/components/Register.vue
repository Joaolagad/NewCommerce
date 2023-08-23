<template>
  <div class="flex flex-col md:flex-row">
        <div class="w-1/2 md:block hidden">
            <img src="registerimage.jpg" alt="register" class="w-full h-screen object-cover" />
         </div>
         <div class="w-full md:w-1/2 flex justify-center items-center bg-gray-100">
            <div class="w-full md:w-96 p-4 md:p-8 bg-white rounded-lg shadow-md">
                <h1 class="logo-h1 text-4xl font-semibold mb-6 text-green-500">NewPlants</h1>
                <form class="mt-8 space-y-3" @submit="register">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="user" class="input-field" required="" v-model="user.name">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" class="input-field" required="" v-model="user.email">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" class="input-field" required="" v-model="user.password">
                    </div>
                    <div class="mb-4">
                        <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" id="confirm-password" class="input-field" required="" v-model="user.password_confirmation">
                    </div>
                    <button type="submit" class="w-full btn-primary">Register</button>
                </form>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">Already have an account?</p>
                    <router-link to="/login" class="text-blue-500 hover:underline">Log In</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useRouter} from 'vue-router'
import store from '../store';
const user = {
    name: '',
    email: '',
    password: '',
    password_confirmation: '',

};
const router = useRouter();
function register(ev) {
    ev.preventDefault();
    store.dispatch('register', user)
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
