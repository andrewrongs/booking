import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    scrollBehavior(to, from, savedPosition) {
        return savedPosition || { left: 0, top: 0 }
    },
    routes: [
        {
            path: '/',
            name: 'Dashboard',
            component: () => import('../Pages/Dashboard.vue'),
            meta: {
                title: 'eCommerce Dashboard',
            },
        },
        {
            path: '/storeProduct',
            name: 'StoreProduct',
            component: () => import('../Pages/StoreProduct.vue'),
            meta: {
                title: 'eCommerce Dashboard',
            },
        },
    ],
})

export default router

router.beforeEach((to, from, next) => {
    document.title = `Vue.js ${to.meta.title} | TailAdmin - Vue.js Tailwind CSS Dashboard Template`
    next()
})
