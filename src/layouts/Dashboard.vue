<template>
  <q-layout view="hHh lpR fFf">
    <q-header bordered reveal class="bg-white text-grey-14">
      <div class="menu-closed">
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          :icon="!leftDrawerOpen?'far fa-align-center':'far fa-times'"
          aria-label="Menu"
        />
      </div>

      <q-toolbar>
        <q-toolbar-title shrink class="text-weight-bolder">
          Go Media CRM<div class="text-subtitle2">Breadcrumb data missing</div>
        </q-toolbar-title>
        <q-space />
        <template>
          <div class="row no-wrap q-col-gutter-md">
            <div class="column self-center">
              <q-btn dense round flat icon="notifications">
                <q-badge color="red" text-color="white" floating>2</q-badge>
                <q-menu
                  auto-close
                  square
                  max-width="width: 400px; max-width:95vw"
                  :offset="[10, 0]">
                  <q-list style="width: 400px; max-width:95vw">
                    <q-item-section header class="text-white text-bolder bg-grey q-pl-md q-pa-sm">
                      You have 4 messages
                    </q-item-section>
                    <notification v-for="item in notifications" :key="item.id" :notification="item" />
                  </q-list>
                </q-menu>
              </q-btn>
            </div>
            <div v-if="user" class="column self-center">
              <q-item class="q-pa-none cursor-pointer">
                <q-item-section class="q-pa-none q-mr-xs" avatar style="min-width:auto">
                  <avatar class="cursor-pointer" size="30px" :user="user"/>
                </q-item-section>
                <q-item-section class="gt-sm q-pa-none">{{user.name}}</q-item-section>
                <q-item-section side class="gt-sm q-pa-none" style="padding: 0"><q-icon name="expand_more"></q-icon></q-item-section>
                <q-menu
                  auto-close
                  square
                  :offset="[10, 0]">
                  <q-list style="width: 200px">
                    <q-item clickable>
                      <q-item-section style="min-width:auto" avatar>
                        <q-icon color="primary" name="edit" size="xs" />
                      </q-item-section>
                      <q-item-section class="q-pl-none">Edit Profile</q-item-section>
                    </q-item>
                    <q-separator/>
                    <q-item clickable>
                      <q-item-section style="min-width:auto" avatar>
                        <q-icon color="primary" name="lock" size="xs" />
                      </q-item-section>
                      <q-item-section class="q-pl-none">Change Password</q-item-section>
                    </q-item>
                    <q-separator/>
                    <q-item @click="onLogout" clickable>
                      <q-item-section style="min-width:auto" avatar>
                        <q-icon color="primary" name="exit_to_app" size="xs" />
                      </q-item-section>
                      <q-item-section class="q-pl-none">Logout</q-item-section>
                    </q-item>
                  </q-list>
                </q-menu>
              </q-item>
            </div>
          </div>
        </template>
      </q-toolbar>
    </q-header>

    <q-drawer
      show-if-above
      v-model="leftDrawerOpen"
      side="left"
      :width="200"
      :breakpoint="1023"
      content-class="bg-gm-blue"
      class="q-pa-none q-ma-none"
    >
      <q-scroll-area
        class="fit q-pa-none"
        :style="($q.screen.lt.md ? 'margin-top: 90px;height: calc(100% - 130px)!important' : 'height: calc(100% - 40px)!important')"
      >
        <q-list class="q-pa-none">
          <links
            v-for="link in sideLinks"
            :key="link.title"
            v-bind="link"
          />
      </q-list>
      </q-scroll-area>
      <q-toolbar class="absolute-top menu-toolbar lt-md">
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          icon="fal fa-times"
          aria-label="Menu"
        />
      </q-toolbar>
    </q-drawer>

    <q-page-container>
      <router-view :key="pageKey" />
    </q-page-container>
  </q-layout>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data () {
    return {
      leftDrawerOpen: false,
      pageKey: Date.now(),
      sideLinks: [
        {
          title: 'Dashboard',
          icon: 'fal fa-tachometer',
          route: 'Dashboard'
        },
        {
          title: 'Customers',
          icon: 'fal fa-handshake-alt',
          route: 'Customers'
        },
        {
          title: 'Suppliers',
          icon: 'fal fa-person-carry',
          route: 'Suppliers'
        },
        {
          title: 'Prospects',
          icon: 'fal fa-calculator',
          route: 'Prospects'
        },
        {
          title: 'Users',
          icon: 'fal fa-users',
          route: 'Users'
        },
        {
          title: 'Roles',
          icon: 'fal fa-users-cog',
          route: 'Roles'
        }
      ],
      appName: process.env.APP_NAME
    }
  },
  methods: {
    ...mapActions('app', ['Logout']),
    onLogout () {
      this.Logout().then(() => {
        this.$router.push({ name: 'Login' })
      })
    }
  },
  watch: {
    $route: function (newRoute) {
      this.pageKey = Date.now()
    }
  },

  computed: {
    user: {
      get () {
        return this.$store.state.app.user
      },
      set (val) {
        this.$store.commit('app/currentUser', val)
      }
    },
    notifications: {
      get () {
        return this.$store.state.app.notifications
      },
      set (val) {
        this.$store.commit('app/updateNotifications', val)
      }
    }
  }
}
</script>
<style lang="sass">
  .q-drawer--mini .logo img
    width: 100%

  .nav-active
    background: $gmBlueDark
    color: white !important
    border-left: 3px solid white

  .q-item__section--avatar
    min-width: auto

</style>
