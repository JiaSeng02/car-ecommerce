<template>
  <div class="support">
    <h2>About Us</h2>
    <p>
      We aim to make car buying smooth and stress-free. Our mission is to
      provide the best car deals for everyone.
    </p>

    <h3>Contact Us</h3>
    <form @submit.prevent="submitForm">
      <input v-model="form.name" placeholder="Your Name" required />
      <input v-model="form.email" placeholder="Your Email" required />
      <textarea
        v-model="form.message"
        placeholder="Your Message"
        required
      ></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        message: "",
      },
    };
  },
  methods: {
    submitForm() {
      console.log("Message sent:", this.name, this.email, this.message);
      alert("Thank you for your message! We will get back to you soon.");
      this.form = { name: "", email: "", message: "" };
    },
  },
};
</script>

<style scoped>
.support {
  max-width: 600px;
  margin: auto;
  padding: 20px;
}
form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
input,
textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
button {
  padding: 10px;
  background-color: #333;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>
