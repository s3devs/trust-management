import core from '../../services/core'

export function hasPermission (state) {
  console.func('store/app/getters:hasPermission()', arguments)
  return module => {
    if (state.user.permissions) {
      if (state.user.permissions.find(item => item.module === module)) {
        return true
      }
      return false
    }
    return false
  }
}
export function getPermissions (state) {
  console.func('store/app/getters:getPermissions()', arguments)
  return module => {
    if (state.user.permissions) {
      var permissions = state.user.permissions.filter(item => item.module === module)
      permissions = core.$_.map(permissions, 'name')
      console.log('permissions', permissions)
      return permissions
    }
    return []
  }
}
