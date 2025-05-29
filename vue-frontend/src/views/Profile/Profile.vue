<template>
  <div class="profile-container">
    <div class="profile-card" v-if="user">
      <img
        :src="`data:image/jpeg;base64,${user.image}`"
        alt="Profile Image"
        v-if="user.image"
        class="profile-image"
      />

      <input
        type="file"
        ref="fileInput"
        @change="handleImageUpload"
        accept="image/*"
        hidden
      />
      <button class="upload-btn" @click="$refs.fileInput.click()">
        Upload New Image
      </button>

      <div class="user-details">
        <h2>{{ user.name }}</h2>
        <p><span>Email:</span> {{ user.email }}</p>
        <p><span>Joined:</span> {{ formatDate(user.created_at) }}</p>
      </div>

      <div class="booking-schedule" v-if="userCars.length">
        <h3>Your Car Bookings</h3>
        <ul>
          <li
            v-for="booking in userCars"
            :key="booking.id"
            class="booking-item"
          >
            <strong>{{ booking.car.brand }} {{ booking.car.model }}</strong
            ><br />
            Test Drive: {{ formatDate(booking.test_drive_date) }} at
            {{ booking.test_drive_time }}<br />
          </li>
        </ul>
      </div>

      <button class="logout-btn" @click="logout">Logout</button>
    </div>
    <div v-else class="loading">Loading user information...</div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "UserProfile",
  data() {
    return {
      user: null,
      userCars: [],
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("auth_token");
      this.$router.push("/login");
    },
    fetchUser() {
      const token = localStorage.getItem("auth_token");
      if (!token) {
        this.$router.push("/login");
        return;
      }

      axios
        .get("http://localhost:8000/api/user", {
          headers: { Authorization: `Bearer ${token}` },
        })
        .then((response) => {
          this.user = response.data;
        })
        .catch(() => {
          this.$router.push("/login");
        });
    },
    fetchUserCars() {
      const token = localStorage.getItem("auth_token");
      axios
        .get("http://localhost:8000/api/user/cars", {
          headers: { Authorization: `Bearer ${token}` },
        })
        .then((response) => {
          this.userCars = response.data;
        })
        .catch((error) => {
          console.error("Failed to fetch car bookings", error);
          this.userCars = [];
        });
    },
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (!file) return;

      const formData = new FormData();
      formData.append("image", file);

      const token = localStorage.getItem("auth_token");

      axios
        .post("http://localhost:8000/api/user/upload-image", formData, {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "multipart/form-data",
          },
        })
        .then(() => {
          this.fetchUser();
        })
        .catch((error) => {
          console.error("Image upload failed", error);
        });
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
  },
  mounted() {
    this.fetchUser();
    this.fetchUserCars();
  },
};
</script>

<style scoped>
.profile-container {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
  min-height: 70vh;
  background-color: #f4f6f8;
}

.profile-card {
  background: white;
  padding: 30px 40px;
  border-radius: 12px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
  max-width: 400px;
  width: 100%;
  text-align: center;
}

.profile-card:hover {
  transform: translateY(-3px);
}

.logout-btn,
.upload-btn {
  display: block;
  width: 100%;
  margin-top: 15px;
  padding: 10px 20px;
  border: none;
  color: white;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
}

.logout-btn {
  background-color: #e74c3c;
}

.logout-btn:hover {
  background-color: #c0392b;
}

.upload-btn {
  background-color: #3498db;
}

.upload-btn:hover {
  background-color: #2980b9;
}

.loading {
  font-size: 18px;
  color: #777;
}

.profile-image {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 20px;
}

.user-details p span {
  font-weight: 600;
  color: #2c3e50;
}

.booking-schedule {
  margin-top: 30px;
  text-align: left;
}

.booking-schedule h3 {
  margin-bottom: 15px;
  color: #34495e;
}

.booking-item {
  background-color: #ecf0f1;
  padding: 10px 15px;
  margin-bottom: 10px;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.booking-item strong {
  color: #2c3e50;
}

.booking-item em {
  color: #2980b9;
}
</style>
