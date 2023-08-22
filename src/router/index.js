import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Cronograma from '../components/Cronograma.vue'
import Botones from '../components/Botones.vue'
import Documentacion from '../components/Documentacion.vue'
import Eventos from'../components/Eventos.vue'
import Consultas from '../components/Consultas.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/Botones',
      name: 'botones',
      component: Botones
    },
    {
      path: '/Documentacion',
      name: 'documentacion',
      component: Documentacion
    },
    {
      path: '/Cronograma',
      name: 'cronograma',
      component: Cronograma 
    },
    {
      path: '/Eventos',
      name: 'eventos',
      component: Eventos 
    },
    {
      path: '/Consultas',
      name: 'consultas',
      component: Consultas 
    }

  ]
})

export default router
