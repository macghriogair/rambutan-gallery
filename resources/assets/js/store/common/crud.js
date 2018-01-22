/**
 * Reusable functionality for CRUD stores
 *
 * @date:    2017-09-21
 * @file:    crud.js
 * @author:  Patrick Mac Gregor <pmacgregor@3pc.de>
 */

import axios from 'axios'

export const state = {
  resourceUrl: null,
  loading: true,
  data: []
}

export const mutations = {
  setLoading: (state, payload) => {
    state.loading = payload
  },
  setData: (state, payload) => {
    state.data = payload
  },
  update: (state, payload) => {
    let el = state.data.find(el => {
      return el.id === payload.id
    })
    for (let field in payload) {
      el[field] = payload[field]
    }
  },
  addElement: (state, element) => {
    state.data.push(element)
  },
  removeElement: (state, elementId) => {
    let idx = state.data.findIndex(el => el.id === elementId)
    if (idx >= 0) {
      state.data.splice(idx, 1)
    }
  }
}

export const actions = {
  fetch({commit, state}) {
    commit('setLoading', true)
    axios.get(state.resourceUrl)
      .then((response) => {
        commit('setData', response.data)
        commit('setLoading', false)
      })
      .catch(e => {
        console.error(e)
        commit('setLoading', false)
      })
  },

  update({commit, state}, payload) {
    return new Promise((resolve, reject) => {
      axios.put(`${state.resourceUrl}/${payload.id}`, payload)
        .then((response) => {
          //commit('update', response.data.data)
          window.Bus.$emit('ajax-success', {text: 'Entry updated successfully!'})
          resolve(response)
        })
        .catch((e) => {
          console.error(e)
          window.Bus.$emit('ajax-error', {text: e.message })
          reject(e)
        })
    })
  },

  store({commit, state}, payload) {
    return new Promise((resolve, reject) => {
      axios.post(state.resourceUrl, payload)
        .then((response) => {
          console.log(response)
          // commit('addElement', response.data.data)
          window.Bus.$emit('ajax-success', {text: 'Entry added successfully!'})
          resolve(response)
        })
        .catch((e) => {
          console.error(e)
          window.Bus.$emit('ajax-error', {text: e.message })
          reject(e)
        })
    })
  },

  destroy({commit, state}, elementId) {
    axios.delete(`${state.resourceUrl}/${elementId}`)
      .then((response) => {
        console.log(response)
        //commit('removeElement', elementId)
        window.Bus.$emit('ajax-success', {text: 'Entry deleted successfully!'})
      })
      .catch((e) => {
        console.error(e)
        window.Bus.$emit('ajax-error', {text: e.message })
      })
  },
}

export const getters = {
  byId(state) {
    return (elementId) => {
      return state.data.find((el) => {
        return el.id === elementId
      })
    }
  }
}
