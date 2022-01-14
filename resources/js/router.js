import Vue from 'vue';
import VueRouter from 'vue-router';

import Index from './pages/Index.vue';
import Cart from './pages/Cart.vue';
import Login from './pages/Login.vue';
import Products from './pages/Products.vue';
import Product from './pages/Product.vue';
import Orders from './pages/Orders.vue';
import Order from './pages/Order.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index
        },
        {
            path: '/cart',
            name: 'cart',
            component: Cart
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/products',
            name: 'products',
            component: Products
        },
        {
            path: '/product',
            name: 'product',
            component: Product
        },
        {
            path: '/orders',
            name: 'orders',
            component: Orders
        },
        {
            path: '/order',
            name: 'order',
            component: Order
        },
    ]
});

export default router;
