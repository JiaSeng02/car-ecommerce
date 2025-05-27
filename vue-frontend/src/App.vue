<template>
  <div id="app">
    <nav>
      <router-link to="/cars">Cars</router-link> |
      <router-link to="/login" v-if="!isAuthenticated">Login</router-link>
      <router-link to="/register" v-if="!isAuthenticated">Register</router-link>
      <button @click="logout" v-if="isAuthenticated">Logout</button>
    </nav>
    <router-view></router-view>
  </div>
</template>

<script>
import { EventBus } from "@/event-bus";

export default {
  data() {
    return {
      isAuthenticatedInternal: !!localStorage.getItem("auth_token"),
    };
  },
  computed: {
    isAuthenticated() {
      return this.isAuthenticatedInternal;
    },
  },
  methods: {
    logout() {
      localStorage.removeItem("auth_token");
      this.isAuthenticatedInternal = false;
      this.$router.push("/login");
    },
  },
  created() {
    EventBus.$on("login", () => {
      this.isAuthenticatedInternal = true;
    });

    EventBus.$on("logout", () => {
      this.logout();
    });
  },
};
</script>

<style></style>
