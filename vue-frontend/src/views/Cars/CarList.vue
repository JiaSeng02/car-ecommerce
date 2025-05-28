<template>
  <div>
    <h2>Welcome, {{ user.name || "Guest" }}</h2>

    <section class="intro">
      <p>Browse our latest car listings or search by brand, model, and more.</p>
    </section>

    <section class="car-list">
      <h3>
        Car Listings <span v-if="selectedBrand"> - {{ selectedBrand }}</span>
      </h3>
      <div v-if="filteredCars.length">
        <div v-for="car in filteredCars" :key="car.id" class="car-card">
          <strong>{{ car.brand }} {{ car.model }}</strong>
          <p>${{ car.price }} - {{ car.year }}</p>
        </div>
      </div>
      <p v-else>No cars available</p>
    </section>
  </div>
</template>

<script>
import axios from "axios";
import "@/styles/carList/carList.css";

export default {
  data() {
    return {
      cars: [],
      user: {},
      selectedBrand: this.$route.query.brand || "",
    };
  },
  computed: {
    filteredCars() {
      if (!this.selectedBrand) return this.cars;
      return this.cars.filter(
        (car) => car.brand.toLowerCase() === this.selectedBrand.toLowerCase()
      );
    },
  },
  watch: {
    "$route.query.brand"(newBrand) {
      this.selectedBrand = newBrand;
    },
  },
  mounted() {
    const token = localStorage.getItem("auth_token");
    axios
      .get("http://localhost:8000/api/user", {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .then((response) => {
        this.user = response.data;
      })
      .catch((error) => {
        console.error("Failed to fetch user: ", error);
      });

    axios
      .get("http://localhost:8000/api/cars")
      .then((response) => {
        this.cars = response.data;
      })
      .catch((error) => {
        console.error("Failed to fetch cars: ", error);
      });
  },
};
</script>
