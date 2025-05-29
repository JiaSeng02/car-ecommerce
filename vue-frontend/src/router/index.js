import Vue from "vue";
import VueRouter from "vue-router";
import Login from "@/views/Auth/Login.vue";
import Register from "@/views/Auth/Register.vue";
import CarList from "@/views/Cars/CarList.vue";
import MainLayout from "@/layouts/MainLayout.vue";
import Profile from "@/views/Profile/Profile.vue";
import WelcomePage from "@/views/WelcomePage.vue";
import SupportPage from "@/views/Support/SupportPage.vue";
import CarDetails from "@/views/Cars/CarDetails.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    component: MainLayout,
    children: [
      { path: "cars", component: CarList },
      { path: "profile", component: Profile },
      { path: "login", component: Login },
      { path: "register", component: Register },
      { path: "", component: WelcomePage },
      { path: "support", component: SupportPage },
      { path: "/cars/:id", name: "car-details", component: CarDetails },
    ],
  },
];

const router = new VueRouter({
  mode: "history",
  routes,
});

export default router;
