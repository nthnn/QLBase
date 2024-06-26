import { createRouter, createWebHistory } from "vue-router";

import Authentication from "@/views/Authentication.vue";
import Contribs from "@/views/Contribs.vue";
import Deployment from "@/views/Deployment.vue";
import Firmware from "@/views/Firmware.vue";
import HomeView from "@/views/HomeView.vue";
import IntroToAPI from "@/views/IntroToAPI.vue";
import NotFound from "@/views/NotFound.vue";
import SMSVerification from "@/views/SMSVerification.vue";
import DataAnalytics from "@/views/DataAnalytics.vue";
import Database from "@/views/Database.vue";
import FileStorage from "@/views/FileStorage.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/:catchAll(.*)",
            redirect: "/404"
        },
        {
            path: "/404",
            name: "not-found",
            component: NotFound
        },
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
        },
        {
            path: "/intro-api",
            name: "intro-api",
            component: IntroToAPI
        },
        {
            path: "/authentication",
            name: "authentication",
            component: Authentication
        },
        {
            path: "/sms-verification",
            name: "sms-verification",
            component: SMSVerification
        },
        {
            path: "/data-analytics",
            name: "data-analytics",
            component: DataAnalytics
        },
        {
            path: "/database",
            name: "database",
            component: Database
        },
        {
            path: "/file-storage",
            name: "file-storage",
            component: FileStorage
        }
    ]
});

export default router;
