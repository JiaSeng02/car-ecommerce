import Vue from "vue";
import VueRouter from "vue-router";
import Login from "@/views/Auth/Login.vue";
import Register from "@/views/Auth/Register.vue";
import CarList from "@/views/Cars/CarList.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/cars",
    name: "CarList",
    component: CarList,
    meta: { requiresAuth: true },
  },
  {
    path: "/login",
    component: Login,
  },
  {
    path: "/register",
    component: Register,
  },
  {
    path: "/",
    redirect: "/cars",
  },
];

const router = new VueRouter({
  mode: "history",
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!localStorage.getItem("auth_token")) {
      next("login");
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
