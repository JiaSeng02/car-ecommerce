<template>
  <div>
    <h1>Profile</h1>
    <button @click="logout" v-if="isAuthenticated">Logout</button>
  </div>
</template>

<script>
export default {
  name: "userProfile",
  data() {
    return {
      isAuthenticated: !!localStorage.getItem("auth_token"),
    };
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
