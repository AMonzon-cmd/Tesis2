import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/views/Home.vue'),
      meta: {
        pageTitle: 'Home',
        breadcrumb: [
          {
            text: 'Home',
            active: true,
          },
        ],
      },
    },
    {
      path: '/second-page',
      name: 'second-page',
      component: () => import('@/views/SecondPage.vue'),
      meta: {
        pageTitle: 'Second Page',
        breadcrumb: [
          {
            text: 'Second Page',
            active: true,
          },
        ],
      },
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/Login.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/registro',
      name: 'registro',
      component: () => import('@/views/Registro.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '*',
      redirect: 'error-404',
    },
    {
      path: '/recuperarContrasena',
      name: 'recuperarContrasena',
      component: () => import('@/views/Recuperar.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/reset',
      name: 'reset',
      component: () => import('@/views/ResetPass.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/productos',
      name: 'productos',
      component: () => import('@/views/ListaProductos.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: () => import('@/views/Perfil.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/pagar',
      name: 'pagar',
      component: () => import('@/views/RealizarPago.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/confirmacionPago',
      name: 'confirmacionPago',
      component: () => import('@/views/ConfirmacionPago.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/confirmacionCambioPass',
      name: 'confirmacionCambioPass',
      component: () => import('@/views/ConfirmacionCambioPass.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/confirmacionRegistro',
      name: 'confirmacionRegistro',
      component: () => import('@/views/ConfirmacionRegistro.vue'),
      meta: {
        layout: 'full',
      },
    },
  ],
})

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

export default router
