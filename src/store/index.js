import Vue from 'vue'
import Vuex from 'vuex'

import app from './app'
import user from './user'
import role from './role'

import customer from './customer'
import contact from './customer/contact'
import location from './customer/location'
import referral from './customer/referral'

import supplier from './supplier'
import supplierContact from './supplier/contact'
import supplierLocation from './supplier/location'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      app,
      user,
      role,
      customer,
      contact,
      location,
      referral,
      supplier,
      supplierContact,
      supplierLocation
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV
  })

  return Store
}
