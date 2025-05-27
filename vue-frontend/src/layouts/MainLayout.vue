<template>
  <div class="layout-container">
    <header class="header" v-if="!isAuthPage">
      <h1>Car E-commerce</h1>
      <nav>
        <router-link to="/">Home</router-link> |
        <router-link to="/login" v-if="!isAuthenticated">Login</router-link>
        <router-link to="/register" v-if="!isAuthenticated"
          >Register</router-link
        >
        <router-link to="/profile" v-if="isAuthenticated">Profile</router-link>
        <button @click="logout" v-if="isAuthenticated">Logout</button>
      </nav>
    </header>

    <header class="header" v-else>
      <h1>Car E-Commerce</h1>
      <nav>
        <router-link to="/login">Login</router-link> |
        <router-link to="/register">Register</router-link>
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
import "@/styles/mainLayout/mainLayout.css";
export default {
  data() {
    return {
      isAuthenticated: !!localStorage.getItem("auth_token"),
    };
  },
  computed: {
    isAuthPage() {
      return ["/login", "/register"].includes(this.$route.path);
    },
  },
  watch: {
    $route() {
      this.isAuthenticated = !!localStorage.getItem("auth_token");
    },
  },
  methods: {
    logout() {
      localStorage.removeItem("auth_token");
      this.isAuthenticated = false;
      this.$router.push("/login");
    },
  },
};
</script>
