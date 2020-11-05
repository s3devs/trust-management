import Api from '../../services/api'

export function List ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.get('users', playload).then(response => {
      commit('List', response.data)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Show ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.get('users/' + playload).then(response => {
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Store ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.post('users', playload).then(response => {
      commit('Add', response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Update ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.put('users/' + playload.id, playload).then(response => {
      commit('Edit', response.data)
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Delete ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.delete('users/' + playload.id).then(response => {
      commit('Delete', playload.id)
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function DeleteMulti ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.delete('users', playload).then(response => {
      playload.users.map(id => {
        commit('Delete', id)
      })
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Restore ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.post(`users/${playload.id}/restore`).then(response => {
      commit('Delete', playload.id)
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function RestoreMulti ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.post('users/restore', playload).then(response => {
      playload.users.map(id => {
        commit('Delete', id)
      })
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
