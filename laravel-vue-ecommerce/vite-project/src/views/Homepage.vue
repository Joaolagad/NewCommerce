<template>
    <Layout/>
    <HomepageNavbar/>
    <HomepageProducts/>
</template>

<script>
import HomepageNavbar from '../components/HomepageNavbar.vue';
import HomepageProducts from '../components/HomepageProducts.vue';
import Layout from '../components/Layout.vue';
export default {
    components: {
      HomepageNavbar,
      HomepageProducts,
      Layout,
    }
  };

</script>

<style>

</style>