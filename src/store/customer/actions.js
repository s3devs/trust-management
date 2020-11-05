import Api from '../../services/api'

export function List ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.get('customers', playload).then(response => {
      commit('List', response.data)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Show ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.get('customers/' + playload).then(response => {
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Store ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.post('customers', playload).then(response => {
      commit('Add', response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Update ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.put('customers/' + playload.id, playload).then(response => {
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
    Api.delete('customers/' + playload.id).then(response => {
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
    Api.delete('customers', playload).then(response => {
      playload.customers.map(id => {
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
    Api.post(`customers/${playload.id}/restore`).then(response => {
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
    Api.post('customers/restore', playload).then(response => {
      playload.customers.map(id => {
        commit('Delete', id)
      })
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
