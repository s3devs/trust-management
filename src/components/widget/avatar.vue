<template>
  <q-avatar v-if="user.avatar" :size="size" color="primary" text-color="white">
    <img :src="user.avatar">
    <q-badge v-if="user.status" color="transparent" floating>
      <q-icon dense round name="brightness_1" :color="(user.status == 'online')? 'positive' : 'grey'" size="10px"/>
    </q-badge>
    <tooltip position="top">{{user.name}}</tooltip>
  </q-avatar>
  <q-avatar v-else-if="user.name" :size="size" color="primary" text-color="white">
    <span>{{ user.name.charAt(0) }}</span>
    <q-badge v-if="user.status" color="transparent" floating>
      <q-icon dense round name="brightness_1" :color="(user.status == 'online')? 'positive' : 'grey'" size="10px"/>
    </q-badge>
    <tooltip position="top">{{user.name}}</tooltip>
  </q-avatar>
  <q-avatar v-else-if="user.company_name" :size="size" color="primary" text-color="white">
    <span>{{ user.company_name.charAt(0) }}</span>
    <q-badge v-if="user.status" color="transparent" floating>
      <q-icon dense round name="brightness_1" :color="(user.status == 'online')? 'positive' : 'grey'" size="10px"/>
    </q-badge>
    <tooltip position="top">{{user.company_name}}</tooltip>
  </q-avatar>
</template>

<script>
export default {
  props: {
    user: {
      required: true,
      type: Object
    },
    size: {
      required: false,
      type: String,
      default: '60px'
    }
  }
}
</script>
