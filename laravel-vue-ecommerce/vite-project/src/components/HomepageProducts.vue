<template>
  <div class="relative hidden lg:block">
    <h3 class="text-2xl mt-10 mb-5 looking ml-12">Shop by Category</h3>
    <div class="relative flex items-center">
      <button
        @click="slide(-1)"
        :disabled="currentSlide === 0"
        class="absolute top-1/2 left-0 transform -translate-y-1/2 px-4 text-green-500 hover:text-green-700"
      >
        <i class="fas fa-chevron-left"></i>
      </button>
      <div class="flex gap-6 px-14 overflow-hidden">
        <transition-group
          name="category-slide"
          tag="div"
          class="flex flex-wrap space-x-7"
            >
          <div
            v-for="(category, index) in visibleCategories"
            :key="category.id"
            class="w-72 rounded-lg shadow-md transform transition-transform duration-300 hover:scale-105 overflow-hidden"
          >
          <router-link
                :to="`/category/${category.id}`">
                <img
                :src="category.image_url"
                alt="Category Image"
                class="h-52 w-full object-cover"
                />
                <div class="p-4">
                  <p class="text-lg font-semibold">{{ category.name }}</p>
                  <span class="text-green-500 hover:text-green-700 text-sm font-medium">
                    View Products
                  </span>

                </div>
            </router-link>
          </div>
        </transition-group>
      </div>

      <button
        @click="slide(1)"
        :disabled="currentSlide === maxSlide"
        class="absolute top-1/2 right-0 transform -translate-y-1/2 px-4 text-green-500 hover:text-green-700"
      >
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
  </div>
  <div class="relative sm:hidden">
    <h3 class="text-2xl mt-10 mb-5 looking ml-12">Shop by Category</h3>
    <div class="grid gap-6 md:grid-cols-2 px-4">
      <div
        v-for="(category, index) in categories"
        :key="category.id"
        class="w-full rounded-lg shadow-md hover:scale-105 overflow-hidden"
      >
        <router-link :to="`/category/${category.id}`">
          <img
            :src="category.image_url"
            alt="Category Image"
            class="h-52 w-full object-cover"
          />
          <div class="p-4">
            <p class="text-lg font-semibold">{{ category.name }}</p>
            <span class="text-green-500 hover:text-green-700 text-sm font-medium">
              View Products
            </span>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
import store from '../store';
export default {
  data() {
    return {
      categories: [],
      currentSlide: 0,
      itemsPerPage: 4,
    };
  },
  computed: {
    maxSlide() {
      return Math.ceil(this.categories.length / this.itemsPerPage) - 1;
    },
    visibleCategories() {
      const start = this.currentSlide * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.categories.slice(start, end);
    },
  },
  methods: {
    slide(step) {
      this.currentSlide += step;
    },
  },
  async created() {
    try {
      await store.dispatch('fetchCategory');
      this.categories = store.getters.getCategories;
      //console.log('categories:', this.categories);
    } catch (error) {
      //console.error('Error fetching categories:', error);
    }
  },
};
</script>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
@import url('https://fonts.googleapis.com/css2?family=Abel&display=swap');
.looking {
  font-family: 'Abel', sans-serif;
}
.category-slide-enter-active,
.category-slide-leave-active {
  transition: opacity 0.5s, transform 0.5s;
}
.category-slide-enter, .category-slide-leave-to{
  opacity: 0;
  transform: translateX(30px);
}
</style>
