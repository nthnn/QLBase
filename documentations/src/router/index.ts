import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "",
            name: "home",
            component: HomeView
        },
        {
            path: "/deployment",
            name: "deployment",
            component: () => import("../views/pages/Deployment.vue")
        },
        {
            path: "/firmware",
            name: "firmware",
            component: ()=> import("../views/pages/Firmware.vue")
        }
    ]
});

export default router;
