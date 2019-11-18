import Vue from 'vue'
import Router from 'vue-router'
//import Home from './views/Home.vue'

import auth from './middleware/auth.js';

Vue.use(Router)

export default new Router({
//export const router=new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      //component: () => import(/* webpackChunkName: "about" */ './App.vue'),
      //component: Home,
      meta: {
        middleware: [auth]
      }
    },
    //{
      //path: '/ListadoCasos/:id_caso',
      //name: 'HistorialCambios',
      //props:true,
      //component: () => import(/* webpackChunkName: "about" */ './components/HistorialCambios.vue'),
    //},
    {
      path:'/ListadoCasos/:id_caso',
      name:'HistorialCambios',
      component: () => import(/* webpackChunkName: "about" */ './components/HistorialCambios.vue'),
    },
    {
      path: '/DatosUsuario',
      name: 'DatosUsuario',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "about" */ './components/DatosUsuario.vue'),
    },
    {
      path: '/CambiarContrasena',
      name: 'CambiarContrasena',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "about" */ './components/CambiarContrasena.vue'),
    },
    {
      path: '/ListadoCasos',
      name: 'ListadoCasos',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "about" */ './components/ListadoCasos.vue'),
    },
    {
      path: '/Login',
      name: 'Login',
      component: () => import(/* webpackChunkName: "about" */ './components/Login.vue'),
    }
  ]
})
