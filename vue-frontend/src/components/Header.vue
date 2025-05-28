<template>
  <header class="header">
    <nav>
      <router-link to="/">Home</router-link>
      <select v-model="selectedBrand" @change="goToBrand">
        <option disable value="">Choose Brand</option>
        <option v-for="brand in brands" :key="brand">{{ brand }}</option>
      </select>
      <router-link to="/support">Support</router-link>
      <router-link to="/profile">Profile</router-link>
    </nav>
  </header>
</template>

<script>
export default {
  name: "pageHeader",
  data() {
    return {
      selectedBrand: "",
      brands: ["Toyota", "Honda", "BMW", "Tesla"],
    };
  },
  methods: {
    goToBrand() {
      if (this.selectedBrand) {
        this.$router.push({
          name: "CarList",
          query: { brand: this.selectedBrand },
        });
      }
    },
  },
};
</script>
