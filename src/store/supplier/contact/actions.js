import Api from '../../../services/api'

export function List ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.get(`suppliers/${playload.supplier}/contacts`, playload).then(response => {
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
    Api.get(`suppliers/${playload.supplier}/contacts/${playload.contact.id}`).then(response => {
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Store ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.post(`suppliers/${playload.supplier}/contacts`, playload.contact).then(response => {
      commit('Add', response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function Update ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.put(`suppliers/${playload.supplier}/contacts/${playload.contact.id}`, playload.contact).then(response => {
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
    Api.delete(`suppliers/${playload.supplier}/contacts/${playload.contact.id}`).then(response => {
      commit('Delete', playload.contact.id)
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function DeleteMulti ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.delete(`suppliers/${playload.supplier}/contacts`, {
      contacts: playload.contacts
    }).then(response => {
      playload.contacts.map(id => {
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
    Api.post(`suppliers/${playload.supplier}/contacts/${playload.contact.id}/restore`).then(response => {
      commit('Delete', playload.contact.id)
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
export function RestoreMulti ({ commit }, playload) {
  return new Promise((resolve, reject) => {
    Api.post(`suppliers/${playload.supplier}/contacts/restore`, {
      contacts: playload.contacts
    }).then(response => {
      playload.contacts.map(id => {
        commit('Delete', id)
      })
      console.log(response)
      resolve(response)
    }).catch(error => {
      reject(error)
    })
  })
}
