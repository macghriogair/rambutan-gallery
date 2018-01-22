/**
 * Clientside routes
 */

import Router from 'vue-router'
import Vue from 'vue'

import Dashboard from '@components/views/Dashboard'
import ShowAlbum from '@components/views/ShowAlbum'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard
    },
    {
      path: '/album/:id',
      name: 'album.show',
      component: ShowAlbum,
      props: (route) => ({
        id: parseInt(route.params.id, 10)
      })
    },
  ]
})
