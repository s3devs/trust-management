import Vue from 'vue'

export function List (state, playload) {
  state.data = playload
}
export function Push (state, playload) {
  state.data.push(playload)
}
export function Add (state, playload) {
  state.data.unshift(playload)
}
export function Edit (state, playload) {
  console.log('commitEdit', playload)
  const item = state.data.find(item => item.id === playload.id)
  Object.assign(item, playload)
}
export function Delete (state, playload) {
  var index = state.data.findIndex(element => {
    return element.id === playload
  })
  Vue.delete(state.data, index)
}
