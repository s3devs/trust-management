<template>
  <q-expansion-item
    v-if="sub_link"
    v-model="active"
    expand-separator
    :icon="icon"
    :label="title"
    header-class="text-white"
    expand-icon-class="text-white"
    active-class="nav-active"
    @click="active = !active"
    :to="route"
  >
    <q-item v-for="(item, index) in sub_link" :key="index"
      clickable
      tag="a"
      :to="{ name: item.route }"
      v-ripple
      active-class="nav-active"
      class="q-pa-md q-ma-none"
      style="color: #8ee5f7; font-weight: 500"

    >
      <q-item-section avatar style="min-width: auto" class="q-pr-md">
        <q-icon :name="item.icon" size="16px" dense></q-icon>
      </q-item-section>

      <q-item-section>
        <q-item-label dense>{{ item.title }}</q-item-label>
      </q-item-section>
    </q-item>
  </q-expansion-item>
  <q-item
    v-else
    clickable
    tag="a"
    :to="{ name: route }"
    v-ripple
    active-class="nav-active"
    class="q-pa-md q-ma-none"
    style="color: #8ee5f7; font-weight: 500"
  >
    <q-item-section avatar style="min-width: auto" class="q-pr-md">
        <q-icon :name="icon" size="16px" dense></q-icon>
    </q-item-section>

    <q-item-section>
      <q-item-label dense>{{ title }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    },

    route: {
      type: String,
      default: ''
    },

    icon: {
      type: String,
      default: ''
    },

    sub_link: {
      title: {
        type: String,
        required: true
      },

      route: {
        type: String,
        default: ''
      },

      icon: {
        type: String,
        default: ''
      }
    }
  },
  data () {
    return {
      active: false
    }
  }
}
</script>
<style lang="sass">
  .q-expansion-item .q-item__section--avatar
    min-width: auto
  .nav-active
    background: $gmBlueDark
    color: white !important
    border-left: 3px solid white
</style>
