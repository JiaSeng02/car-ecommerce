<template>
  <div class="auth-container">
    <form @submit.prevent="handleRegister" class="auth-form">
      <h2>Register</h2>
      <input v-model="form.name" type="text" placeholder="Name" required />
      <div class="error-message" v-if="errors.name">{{ errors.name[0] }}</div>

      <input v-model="form.email" type="email" placeholder="Email" required />
      <div class="error-message" v-if="errors.email">{{ errors.email[0] }}</div>

      <input
        v-model="form.password"
        type="password"
        placeholder="Password"
        required
      />
      <div class="error-message" v-if="errors.password">
        {{ errors.password[0] }}
      </div>

      <input
        v-model="form.password_confirmation"
        type="password"
        placeholder="Confirm Password"
        required
      />
      <div class="error-message" v-if="errors.password_confirmation">
        {{ errors.password_confirmation[0] }}
      </div>

      <div class="error-message" v-if="errors.general">
        {{ errors.general }}
      </div>

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
      errors: {},
    };
  },

  methods: {
    async handleRegister() {
      this.errors = {};

      try {
        const response = await axios.post(
          "http://localhost:8000/api/register",
          this.form
        );
        localStorage.setItem("auth_token", response.data.token);
        EventBus.$emit("login");
        this.$router.push("/");
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else if (error.response && error.response.data.message) {
          this.errors.general = error.response.data.message;
        } else {
          this.errors.general = "An unexpected error occurred.";
        }
      }
    },
  },
};
</script>
