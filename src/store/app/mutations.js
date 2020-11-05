export function currentUser (state, playload) {
  state.user = playload
}
export function Authenticated (state, playload) {
  state.authenticated = playload
}

export function getMenus (state, playload) {
  state.menus = playload
}
