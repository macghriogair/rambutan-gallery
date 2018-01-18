/**
 * @date:    2018-01-18
 * @file:    albums.js
 * @author:  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */
import axios from 'axios'
import { makeUploadFilePromise } from '../common/upload'

import {
  state as baseState,
  actions as baseActions,
  mutations as baseMutations,
  getters
} from '../common/crud'

const state = {
  ...baseState,
  resourceUrl: '/api/albums',
  photos: []
}

const mutations = {
  ...baseMutations,
  setPhotos: (state, payload) => {
    state.photos = payload
  },
}

const actions = {
  ...baseActions,
  fetchPhotos({commit, state}, { albumId }) {
    commit('setLoading', true)
    axios.get(`${state.resourceUrl}/${albumId}/photos`)
      .then((response) => {
        commit('setPhotos', response.data)
        commit('setLoading', false)
      })
      .catch(e => {
        console.error(e)
        commit('setLoading', false)
      })
  },

  storePhoto({commit, state, getters}, payload) {
    let createObj = {}
    if (payload.albumId) {
      createObj.album_id = getters['byId'](payload.albumId).uuid
    }
    if (payload.name) {
      createObj.name = payload.name
    }
    if (payload.description) {
      createObj.description = payload.description
    }
    if (payload.file) {
      createObj.file = payload.file
    }

    let uploadFilePromise = makeUploadFilePromise(payload, createObj, '/api/upload/image')

    let storePromise = function (data) {
      if (data && data.tmpFile) {
        createObj.file = data.tmpFile
      }
      return new Promise((resolve, reject) => {
        axios.post('/api/photos', createObj)
          .then(response => {
            // commit('update', response.data.data)
            console.log(response)
            window.Bus.$emit('ajax-success', {text: 'Photo added successfully!'})
            resolve(response)
          })
          .catch(e => reject(e))
      })
    }

    return uploadFilePromise.then(storePromise)
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters
}

