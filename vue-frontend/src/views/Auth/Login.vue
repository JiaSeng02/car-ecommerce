<template>
  <div class="auth-container">
    <form @submit.prevent="handleLogin" class="auth-form">
      <h2>Login</h2>
      <input v-model="form.email" type="email" placeholder="Email" required />
      <input
        v-model="form.password"
        type="password"
        placeholder="Password"
        required
      />
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import { EventBus } from "@/event-bus";
import "@/styles/authStyle/AuthCss.css";

export default {
  name: "AuthLogin",
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    async handleLogin() {
      try {
        const response = await axios.post(
          "http://localhost:8000/api/login",
          this.form
        );
        localStorage.setItem("auth_token", response.data.token);
        EventBus.$emit("login");
        this.$router.push("/");
      } catch (error) {
        console.error(error.response.data);
      }
    },
  },
};
</script>

<style scoped></style>
