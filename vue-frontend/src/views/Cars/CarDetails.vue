<template>
  <div v-if="car" class="car-hero-container">
    <div
      class="car-hero-image"
      :style="{ backgroundImage: `url(${car.image})` }"
    >
      <div class="car-overlay">
        <div class="left">
          <h1 class="car-title">{{ car.brand }} {{ car.model }}</h1>
          <ul class="car-specs">
            <li><span class="label">Price:</span> ${{ car.price }}</li>
            <li><span class="label">Year:</span> {{ car.year }}</li>
          </ul>
        </div>
        <div class="right">
          <button class="btn btn-primary" @click="showTestDriveForm = true">
            🚗 Book a Test Drive
          </button>
          <button class="btn btn-outline" @click="toggleSellerInfo">
            📞 Contact Seller
          </button>
        </div>
      </div>
    </div>

    <div class="seller-card" v-if="showSellerInfo">
      <h2>Seller Information</h2>
      <p><strong>Name: </strong>{{ seller.name }}</p>
      <p><strong>Phone: </strong>{{ seller.phone }}</p>
      <button class="btn btn-outline" @click="showSellerInfo = false">
        Close
      </button>
    </div>

    <div class="test-drive-form" v-if="showTestDriveForm">
      <h2>Book a Test Drive</h2>
      <form @submit.prevent="submitTestDriveForm">
        <input
          type="text"
          v-model="testDrive.name"
          placeholder="Your Name"
          required
        />
        <input
          type="email"
          v-model="testDrive.email"
          placeholder="Email Address"
          required
        />
        <input
          type="tel"
          v-model="testDrive.phone"
          placeholder="Phone Number"
          required
        />
        <input type="date" v-model="testDrive.date" required />
        <input type="time" v-model="testDrive.time" required />
        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Submit</button>
          <button class="btn btn-outline" @click="showTestDriveForm = false">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
  <div v-else class="loading-state">
    <p>Loading car details...</p>
  </div>
</template>

<script>
import axios from "axios";
import "@/styles/carList/carDetails.css";

export default {
  data() {
    return {
      car: null,
      showSellerInfo: false,
      showTestDriveForm: false,
      seller: {
        name: "",
        phone: "",
      },
      testDrive: {
        name: "",
        email: "",
        phone: "",
        date: "",
        time: "",
      },
    };
  },
  mounted() {
    const carId = this.$route.params.id;
    axios
      .get(`http://localhost:8000/api/cars/${carId}`)
      .then((response) => {
        this.car = response.data;
      })
      .catch((error) => {
        console.error("Failed to fetch car details:", error);
      });
  },
  methods: {
    toggleSellerInfo() {
      const names = ["John Doe", "Emily Clark", "Michael Smith", "Sarah Kim"];
      const phones = [
        "+1 555-123-4567",
        "+44 20 7946 0958",
        "+91 98765 43210",
        "+81 80-1234-5678",
      ];

      this.seller.name = names[Math.floor(Math.random() * names.length)];
      this.seller.phone = phones[Math.floor(Math.random() * phones.length)];
      this.showSellerInfo = true;
    },
    submitTestDriveForm() {
      const token = localStorage.getItem("auth_token");

      const payload = {
        car_id: this.car.id,
        name: this.testDrive.name,
        email: this.testDrive.email,
        phone: this.testDrive.phone,
        test_drive_date: this.testDrive.date,
        test_drive_time: this.testDrive.time,
      };

      axios
        .post("http://localhost:8000/api/book-test-drive", payload, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          alert(response.data.message);
          this.showTestDriveForm = false;
        })
        .catch((error) => {
          console.error("Booking failed:", error);
          alert("Booking failed. Please try again.");
        });
    },
  },
};
</script>

<style scoped></style>
