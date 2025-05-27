<template>
  <div>
    <h2>Welcome, {{ user.name }}</h2>
    <h1>Car Listings</h1>
    <div v-for="car in cars" :key="car.id">
      {{ car.brand }} {{ car.model }} - ${{ car.price }} ({{ car.year }})
    </div>
  </div>
</template>

<script>
import axios from "axios";

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
