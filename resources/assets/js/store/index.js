/**
 * Dedicated store for backend app
 */
import Vue from 'vue'
import Vuex from 'vuex'
import albums from './modules/albums'
// import photos from './modules/photos'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export const store = new Vuex.Store({
  modules: {
    albums: albums,
    // photos: photos
  },
  strict: debug
})
