import Api from '../../../services/api'

export function List ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.get(`customers/${playload.customer}/locations`, playload).then(response => {
      commit('List', response.data)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Show ({ commit }, playload) {
  console.log(playload)
  return new Promise((resolve, reject) => {
    Api.get(`customers/${playload.customer}/locations/${playload.location.id}`).then(response => {
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Store ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.post(`customers/${playload.customer}/locations`, playload.location).then(response => {
      commit('Add', response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Update ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.put(`customers/${playload.customer}/locations/${playload.location.id}`, playload.location).then(response => {
      commit('Edit', response)
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Delete ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.delete(`customers/${playload.customer}/locations/${playload.location.id}`).then(response => {
      commit('Delete', playload.location.id)
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function DeleteMulti ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.delete(`customers/${playload.customer}/locations`, {
      locations: playload.locations
    }).then(response => {
      playload.locations.map(id => {
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
    Api.post(`customers/${playload.customer}/locations/${playload.location.id}/restore`).then(response => {
      commit('Delete', playload.location.id)
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function RestoreMulti ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.post(`customers/${playload.customer}/locations/restore`, {
      locations: playload.locations
    }).then(response => {
      playload.locations.map(id => {
        commit('Delete', id)
      })
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
