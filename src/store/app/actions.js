import router from '../../router/index'
import Api from '../../services/api'
import { Dialog } from 'quasar'

export function errorDialog ({ store }, playload) {
  Dialog.create({
    title: playload.title,
    message: playload.message,
    persistent: true
  }).onOk(() => {
    router({ store }).go()
  })
}

export async function Login ({ commit, state }, playload) {
  await Api.get('csrf-cookie')
  return new Promise((resolve, reject) => {
    Api.post('auth/login', playload).then(response => {
      commit('Authenticated', true)
      commit('currentUser', response)
      localStorage.setItem('currentUser', JSON.stringify(response))
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}

export function User ({ commit, state }) {
  return new Promise((resolve, reject) => {
    Api.post('auth/me').then(response => {
      commit('currentUser', response)
      localStorage.setItem('currentUser', JSON.stringify(response))
      resolve(response)
    }).catch(error => {
      commit('currentUser', {})
      localStorage.removeItem('currentUser')
      reject(error)
    })
  })
}

export function Modules ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.get('users/modules', playload).then(response => {
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}

export function Logout ({ commit }) {
  return new Promise((resolve, reject) => {
    Api.post('/auth/logout').then(response => {
      localStorage.removeItem('currentUser')
      commit('Authenticated', false)
      commit('currentUser', {})
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
