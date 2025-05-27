<template>
  <div>
    <h2>Welcome, {{ user.name || "Guest" }}</h2>

    <section class="intro">
      <p>Browse our latest car listings or search by brand, model, and more.</p>
      <div class="filters">
        <button>By Brand</button>
        <button>By Model</button>
      </div>
    </section>

    <section class="car-list">
      <h3>Car Listings</h3>
      <div v-if="cars.length">
        <div v-for="car in cars" :key="car.id" class="car-card">
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
    };
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
