<template>
  <div class="welcome">
    <h2>Welcome to Car E-Commerce</h2>
    <img src="" alt="Promotion Banner" class="promi-image" />
    <p class="advert-text">
      Discover your dream car today at unbeatable prices!
    </p>
  </div>
</template>

<script>
export default {
  name: "WelcomePage",
};
</script>

<style scoped>
.hero-img {
  width: 100%;
  height: auto;
  max-height: 300px;
  object-fit: cover;
  border-radius: 8px;
  margin: 20px 0;
}
.welcome {
  text-align: center;
  padding: 20px;
}
</style>
