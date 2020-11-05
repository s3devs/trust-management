<template>
  <q-dialog
    persistent
    maximized
    transition-show="slide-up"
    transition-hide="slide-down"
    ref="dialog"
  >
    <div class="base-table-view">
      <q-bar class="bg-gm-blue text-white fixed-top toolbar q-pa-lg">
        <div class="text-weight-bold toolbar-top">
          {{ title }}
        </div>
        <q-space />
        <q-btn
          dense
          flat
          icon="close"
          v-close-popup
        >
          <q-tooltip content-class="bg-white text-primary">
            Close
          </q-tooltip>
        </q-btn>
      </q-bar>
      <q-form
        @submit="onSubmit"
        class="no-scroll"
        style="position:initial; padding-top: 50px"
      >
        <div class="scroll q-pa-lg" :style="{ 'height': height}">
          <div class="row q-col-gutter-md">
            <slot name="body">
              <div class="text-h5">Dialog Body</div>
            </slot>
          </div>
          <q-inner-loading :showing="visiable">
            <q-spinner-tail size="50px" color="primary" />
          </q-inner-loading>
        </div>
        <q-separator/>
        <q-toolbar
          v-if="edit"
          class="absolute-bottom q-pa-lg"
        >
          <q-space />
          <q-btn
            square
            color="grey"
            label="Cancel"
            @click="onCancel"
            class="q-pl-md q-pr-md q-mr-sm"
          />
          <q-btn
            square
            label="Save"
            type="submit"
            color="green"
            class="q-pl-md q-pr-md"
          />
        </q-toolbar>
      </q-form>
    </div>
  </q-dialog>
</template>

<script>
export default {
  props: {
    title: {
      required: false,
      type: String,
      default: () => 'Dialog title'
    },
    edit: {
      required: true,
      type: Boolean
    },
    add: {
      required: true,
      type: Boolean
    },
    loading: {
      required: false,
      type: Boolean,
      default: () => false
    },
    height: {
      required: false,
      type: String,
      default: () => '100vh'
    }
  },
  computed: {
    visiable: {
      get () {
        return this.loading
      },
      set (val) {
        return val
      }
    }
  },
  methods: {
    show () {
      console.func('components/base/table-dialog:methods.show()', arguments)
      this.$refs.dialog.show()
    },
    hide () {
      console.func('components/base/table-dialog:methods.hide()', arguments)
      this.$refs.dialog.hide()
    },
    onSubmit (props) {
      console.func('components/base/table-dialog:methods.onSubmit()', arguments)
      this.visiable = true
      if (this.edit && this.add) {
        this.$emit('submit', props)
      } else {
        this.$emit('update', props)
      }
    },
    onCancel () {
      console.func('components/base/table-dialog:methods.onCancel()', arguments)
      this.hide()
    }
  }
}
</script>
<style lang="sass">
.q-tabs
  .q-tab__label
    font-size: 0.7rem !important
    font-weight: bold
.q-dialog .base-table-view
  background: #e6e6e6
.q-dialog .toolbar
  z-index: 1000
.toolbar
  .toolbar-top
    font-size: 0.85rem
</style>
