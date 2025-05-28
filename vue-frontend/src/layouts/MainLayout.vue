<template>
  <div class="layout-container">
    <header class="header" v-if="!isAuthPage">
      <nav class="nav-bar">
        <router-link to="/" class="logo-container">
          <img src="@/assets/images/logo.png" alt="Car Logo" class="logo-img" />
          <h2>Car E-Commerce</h2>
        </router-link>

        <div class="nav-item dropdown">
          <span class="dropdown-toggle">Brand</span>
          <ul class="dropdown-menu">
            <li
              v-for="brand in uniqueBrands"
              :key="brand"
              @click="selectBrand(brand)"
            >
              {{ brand }}
            </li>
          </ul>
        </div>
        <router-link to="/support" class="nav-item">Support</router-link>
        <router-link to="/profile" v-if="isAuthenticated" class="nav-item"
          >Profile</router-link
        >
      </nav>
    </header>

    <header class="header" v-else>
      <nav class="nav-bar">
        <div class="logo-container">
          <img src="@/assets/images/logo.png" alt="Car Logo" class="logo-img" />
          <h2>Car E-Commerce</h2>
        </div>

        <router-link to="/login" class="nav-item">Login</router-link> |
        <router-link to="/register" class="nav-item">Register</router-link>
      </nav>
    </header>

    <main class="main-content">
      <router-view></router-view>
    </main>

    <footer class="footer">
      <p>&copy; 2025 Car E-Commerce</p>
    </footer>
  </div>
</template>

<script>
import axios from "axios";
import "@/styles/mainLayout/mainLayout.css";

export default {
  data() {
    return {
      isAuthenticated: !!localStorage.getItem("auth_token"),
      selectedBrand: "",
      brands: [],
    };
  },
  computed: {
    isAuthPage() {
      return ["/login", "/register"].includes(this.$route.path);
    },
    uniqueBrands() {
      return [...new Set(this.brands)];
    },
  },
  watch: {
    $route() {
      this.isAuthenticated = !!localStorage.getItem("auth_token");
    },
  },
  mounted() {
    axios
      .get("http://localhost:8000/api/cars")
      .then((response) => {
        this.brands = response.data.map((car) => car.brand);
      })
      .catch((error) => {
        console.error("Error fetching brands:", error);
      });
  },
  methods: {
    goToBrand() {
      if (
        this.selectedBrand &&
        this.$route.query.brand !== this.selectedBrand
      ) {
        this.$router.push({
          path: "/cars",
          query: { brand: this.selectedBrand },
        });
      }
    },
    selectBrand(brand) {
      this.selectedBrand = brand;
      if (this.$route.query.brand !== brand) {
        this.$router.push({
          path: "/cars",
          query: { brand },
        });
      }
    },
  },
};
</script>
