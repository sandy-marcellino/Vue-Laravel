import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

function importComponent(path) {
    return () =>
        import (`./components/${path}.vue`)
}

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [{
            path: "/admin",
            name: "navbarAdmin",
            component: importComponent('NavbarAdmin'),
            meta: { requiresAuth: true },
            children: [
                //menuAdmin
                {
                    path: "/menuAdmin",
                    name: "menuAdmin",
                    meta: { title: 'Menu Admin' },
                    component: importComponent('menuAdmin'),
                },
                //pesanan
                {
                    path: "/kelola_pesanans",
                    name: "Pesanan",
                    meta: { title: 'Pesanan' },
                    component: importComponent('admin/pesanan'),
                },
                //mitra
                {
                    path: "/mitra",
                    name: "Mitra",
                    meta: { title: 'Mitra' },
                    component: importComponent('admin/mitra'),
                },
                //paket
                {
                    path: "/data_paket",
                    name: "Paket",
                    meta: { title: 'Paket' },
                    component: importComponent('admin/paket'),
                },
            ]
        },
        //Index
        {
            path: "/index",
            name: "Index",
            component: importComponent('Index'),
        },
        
        //Login
        {
            path: "/login",
            name: "login",
            meta: { title: 'Login' },
            component: importComponent('Login'),
        },
        //Register
        {
            path: "/register",
            name: "register",
            meta: { title: 'Register' },
            component: importComponent('register'),
        },

        {
            path: "/user",
            name: "navbarUtama",
            component: importComponent('NavbarUtama'),
            meta: { requiresAuth: true },
            children: [
                //Beranda
                {
                    path: "/beranda",
                    name: "beranda",
                    meta: { title: 'Beranda' },
                    component: importComponent('Beranda'),
                },
                //OrderUser
                {
                    path: "/pemesanan",
                    name: "pemesanan",
                    meta: { title: 'OrderUser' },
                    component: importComponent('user/OrderUser'),
                },
            ]
        },
        //profile
        {
            path: "/profile",
            name: "Profile",
            meta: { title: 'Profile' },
            component: importComponent('profile'),
        },
        //verif
        {
            path: "/verif",
            name: "verif",
            meta: { title: 'Verification' },
            component: importComponent('verif'),
        },
        {
            path: '*',
            redirect: '/index'
        },
    ],
});

//Set Judul
// router.beforeEach((to, from, next) => {
//     if (to.name === 'register') {
//         next();
//     } else if (to.name === 'Index') {
//         next();
//     } else if (to.name === 'verif') {
//         next();
//     } else if (to.name !== 'login' && localStorage.getItem('token') === null) {
//         next({ path: '/login' })
//     } else
//         next();
// });

export default router;