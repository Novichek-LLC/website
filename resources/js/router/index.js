import { createRouter, createWebHistory } from 'vue-router'

const HomePage = () => import('../pages/public/HomePage.vue')
const LoginPage = () => import('../pages/auth/LoginPage.vue')
const RegisterPage = () => import('../pages/auth/RegisterPage.vue')

const AccountLayout = () => import('../layouts/AccountLayout.vue')
const AccountDashboardPage = () => import('../pages/account/AccountDashboardPage.vue')
const AccountProjectsPage = () => import('../pages/account/AccountProjectsPage.vue')
const AccountProjectShowPage = () => import('../pages/account/AccountProjectShowPage.vue')
const AccountBillingPage = () => import('../pages/account/AccountBillingPage.vue')
const AccountTicketsPage = () => import('../pages/account/AccountTicketsPage.vue')
const AccountProfilePage = () => import('../pages/account/AccountProfilePage.vue')
const AccountStatusPage = () => import('../pages/account/AccountStatusPage.vue')

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomePage,
    },
    {
        path: '/login',
        name: 'login',
        component: LoginPage,
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterPage,
    },
    {
        path: '/account',
        component: AccountLayout,
        children: [
            {
                path: '',
                name: 'account.dashboard',
                component: AccountDashboardPage,
            },
            {
                path: 'projects',
                name: 'account.projects',
                component: AccountProjectsPage,
            },
            {
                path: 'projects/:slug',
                name: 'account.projects.show',
                component: AccountProjectShowPage,
                props: true,
            },
            {
                path: 'billing',
                name: 'account.billing',
                component: AccountBillingPage,
            },
            {
                path: 'tickets',
                name: 'account.tickets',
                component: AccountTicketsPage,
            },
            {
                path: 'profile',
                name: 'account.profile',
                component: AccountProfilePage,
            },
            {
                path: 'status',
                name: 'account.status',
                component: AccountStatusPage,
            },
        ],
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 }
    },
})

export default router