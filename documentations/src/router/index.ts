import { createRouter, createWebHistory } from "vue-router";

import Contribs from "../views/Contribs.vue";
import Deployment from "../views/Deployment.vue";
import Firmware from "../views/Firmware.vue";
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
            component: Deployment
        },
        {
            path: "/firmware",
            name: "firmware",
            component: Firmware
        },
        {
            path: "/contrib",
            name: "contrib",
            component: Contribs
        }
    ]
});

export default router;
