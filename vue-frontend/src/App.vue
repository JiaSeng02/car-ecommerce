<template>
  <div>
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
    };
  },
  mounted() {
    axios
      .get("http://localhost:8000/api/cars")
      .then((response) => {
        this.cars = response.data;
      })
      .catch((error) => {
        console.error(error);
      });
  },
};
</script>
