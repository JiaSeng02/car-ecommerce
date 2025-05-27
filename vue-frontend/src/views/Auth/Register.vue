<template>
  <div class="auth-container">
    <form @submit.prevent="handleRegister" class="auth-form">
      <h2>Register</h2>
      <input v-model="form.name" type="text" placeholder="Name" required />
      <input v-model="form.email" type="email" placeholder="Email" required />
      <input
        v-model="form.password"
        type="password"
        placeholder="Password"
        required
      />
      <input
        v-model="form.password_confirmation"
        type="password"
        placeholder="Confirm Password"
        required
      />

      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import { EventBus } from "@/event-bus";
import axios from "axios";
import "@/styles/authStyle/AuthCss.css";

export default {
  name: "AuthRegister",
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
    };
  },

  methods: {
    async handleRegister() {
      try {
        const response = await axios.post(
          "http://localhost:8000/api/register",
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
