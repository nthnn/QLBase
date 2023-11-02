import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '',
            name: 'home',
            component: HomeView
        },
        {
            path: '/p1-deployment',
            name: 'deployment',
            component: () => import('../views/pages/deployment.vue')
        }
    ]
});

export default router;
