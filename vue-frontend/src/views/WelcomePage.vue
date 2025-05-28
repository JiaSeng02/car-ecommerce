<template>
  <div class="welcome">
    <h2>Welcome to Car E-Commerce</h2>
    <div class="img-container">
      <img
        :src="currentImage"
        alt="Promotion Banner"
        class="promo-image"
        :key="imageIndex"
      />
      <div class="indicator-container">
        <span
          v-for="(img, index) in images"
          :key="index"
          class="dot"
          :class="{ active: index === imageIndex }"
          @click="goToSlide(index)"
        ></span>
      </div>
    </div>
    <p class="advert-text">
      Discover your dream car today at unbeatable prices!
    </p>
  </div>
</template>

<script>
export default {
  name: "WelcomePage",
  data() {
    return {
      imageIndex: 0,
      images: [
        require("@/assets/images/cars/lambo1.jpg"),
        require("@/assets/images/cars/lambo2.jpg"),
        require("@/assets/images/cars/lambo3.jpg"),
      ],
      intervalid: null,
    };
  },
  computed: {
    currentImage() {
      return this.images[this.imageIndex];
    },
  },
  methods: {
    goToSlide(index) {
      this.imageIndex = index;
    },
    startSlideShow() {
      this.intervalid = setInterval(() => {
        this.imageIndex = (this.imageIndex + 1) % this.images.length;
      }, 4000);
    },
    stopSlideShow() {
      clearInterval(this.intervalid);
    },
  },
  mounted() {
    this.startSlideShow();
  },
  beforeDestroy() {
    this.stopSlideShow();
  },
};
</script>

<style scoped>
.promo-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 8px;
  transition: transform 2s ease-in-out;
  animation: zoom-in 4s ease-in-out infinite;
}
.welcome {
  text-align: center;
  padding: 20px;
}
.img-container {
  position: relative;
  overflow: hidden;
  height: 600px;
  border-radius: 10px;
}
@keyframes zoom-in {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}
.indicator-container {
  position: absolute;
  bottom: 15px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
}
.dot {
  height: 12px;
  width: 12px;
  background-color: #ccc;
  border-radius: 50%;
  display: inline-block;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.dot.active {
  background-color: #f39c12;
}
</style>
