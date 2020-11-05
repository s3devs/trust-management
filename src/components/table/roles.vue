<template>
  <div>
    <template>
      <div>
        <table-dialog
          @submit="onSubmit"
          @update="onUpdate"
          ref="dialog"
          :height="edit ? 'calc(100vh - 130px)' : '100vh'"
          :edit="edit"
          :add="add"
          :loading="visiable"
          :title="title">
          <template slot="body">
            <div class="col-xs-12 col-sm-6">
              <q-input :readonly="!edit" v-model="data.role.name" type="text" label="Name" />
            </div>
            <div class="col-xs-12 col-sm-6">
              <q-input :readonly="!edit" v-model="data.role.slug" type="text" label="Slug" />
            </div>
            <div class="col-xs-12">
              <q-input :readonly="!edit" v-model="data.role.description" type="textarea" label="Description" />
            </div>
            <div class="col-xs-12">
              <div class="text-subtitle1 q-mb-sm q-mt-sm text-dark">Permissions</div>
              <div class="row q-col-gutter-md">
                <div class="col-xs-6 col-sm-3" v-for="(permissions,index) in data.permissions" :key="index">
                  <div class="text-weight-bold">{{permissions.name}}</div>
                  <q-tree
                    :nodes="permissions.children"
                    node-key="id"
                    label-key="name"
                    tick-strategy="leaf"
                    :ticked.sync="data.role.permissions"
                    default-expand-all
                  />
                </div>
              </div>
            </div>
          </template>
        </table-dialog>
      </div>
    </template>
    <q-table
      class="main-table"
      :data="table.data"
      :columns="table.columns"
      flat
      :bordered="bordered"
      row-key="id"
      :hide-pagination="hidePagination"
      :rows-per-page-options="rowsPerPageOptions"
      :filter="syncPagination.filter"
      :pagination.sync="syncPagination"
      :loading="loading"
      selection="multiple"
      :selected.sync="selected"
      @request="onRequest"
    >
      <template v-slot:top>
        <div class="col">
          <div class="row q-col-gutter-md">
            <div class="col-sm-8 col-xs-12">
              <q-btn-group class="q-mr-sm" outline>
                <template>
                  <q-btn
                    squared
                    icon="fal fa-layer-plus"
                    color="positive"
                    size="10px"
                    @click="onAdd"
                    class="q-pa-sm"
                  >
                    <tooltip position="top">Add role</tooltip>
                  </q-btn>
                  <q-btn
                    v-if="!syncPagination.deleted"
                    :disabled="selected.length == 0"
                    squared
                    icon="delete"
                    color="negative"
                    size="10px"
                    class="q-pa-sm"
                    @click="onDeleteMulti"
                  >
                    <tooltip position="top">Delete selected role</tooltip>
                  </q-btn>
                  <q-btn
                    v-else
                    :disabled="selected.length == 0"
                    squared
                    icon="fal fa-trash-undo"
                    color="warning"
                    size="10px"
                    class="q-pa-sm"
                    @click="onRestoreMulti"
                  >
                    <tooltip position="top">Restore selected role</tooltip>
                  </q-btn>
                </template>
              </q-btn-group>
              <q-toggle
                v-if="selected"
                v-model="syncPagination.deleted"
                checked-icon="delete"
                color="red"
                label="View Deleted"
              />
            </div>
            <div class="col-sm-4 col-xs-12 text-right">
              <q-input
                v-model="syncPagination.filter"
                outlined
                square
                placeholder="Quick search"
                hint="First name / Surname / Email"
                dense
              >
                <template v-slot:append>
                  <q-icon
                    v-if="syncPagination.filter === ''"
                    name="fal fa-search"
                    size="14px"
                  />
                  <q-icon
                    v-else
                    name="fal fa-times"
                    class="cursor-pointer"
                    @click="syncPagination.filter = ''"
                    size="14px"
                  />
                </template>
              </q-input>
            </div>
          </div>
        </div>
      </template>
      <template v-slot:body-cell-avatar="props">
        <q-td :props="props">
          <avatar class="cursor-pointer" :role="props.row" size="30px" />
        </q-td>
      </template>
      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-btn
            flat
            dense
            icon="fal fa-ellipsis-h"
          >
            <q-menu
              self="top middle"
              dense
              square
            >
              <q-list dense style="min-width: 100px">
                <q-item
                  v-if="!syncPagination.deleted && permissions.includes('Show')"
                  @click="onView(props.row)"
                  clickable
                  v-close-popup
                  class="q-pt-sm q-pb-sm text-weight-bold text-uppercase"
                  style="font-size: 0.7rem"
                >
                  <q-item-section>view</q-item-section>
                </q-item>
                <q-item
                  v-if="!syncPagination.deleted && permissions.includes('Update')"
                  @click="onEdit(props.row)"
                  clickable
                  v-close-popup
                  class="q-pt-sm q-pb-sm text-weight-bold text-uppercase"
                  style="font-size: 0.7rem"
                >
                  <q-item-section>edit</q-item-section>
                </q-item>
                <q-item
                  v-if="!syncPagination.deleted && permissions.includes('Destroy')"
                  @click="onDelete(props.row)"
                  clickable
                  v-close-popup
                  class="q-pt-sm q-pb-sm text-weight-bold text-uppercase"
                  style="font-size: 0.7rem"
                >
                  <q-item-section>delete</q-item-section>
                </q-item>
                <q-item
                  v-if="syncPagination.deleted && permissions.includes('Destroy')"
                  @click="onRestore(props.row)"
                  clickable
                  v-close-popup
                  class="q-pt-sm q-pb-sm text-weight-bold text-uppercase"
                  style="font-size: 0.7rem"
                >
                  <q-item-section>restore</q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
        </q-td>
      </template>
    </q-table>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  data () {
    return {
      data: {
        role: {}
      },
      selected: [],
      title: '',
      visiable: false,
      isPwd: true,
      isConfPwd: true,
      add: false,
      edit: true
    }
  },
  props: {
    table: {
      required: true,
      type: Object
    },
    pagination: {
      required: true,
      type: Object
    },
    hidePagination: {
      required: false,
      type: Boolean,
      default: () => false
    },
    rowsPerPageOptions: {
      required: false,
      type: Array,
      default: () => [15, 30, 50]
    },
    filter: {
      required: false,
      type: Boolean,
      default: () => true
    },
    bordered: {
      required: false,
      type: Boolean,
      default: () => false
    },
    loading: {
      required: false,
      type: Boolean,
      default: () => false
    }
  },
  watch: {
    'syncPagination.deleted' (val) {
      this.onRequest({
        pagination: this.syncPagination
      })
    }
  },
  methods: {
    ...mapActions('role', ['Show', 'Store', 'Update', 'Delete', 'DeleteMulti', 'Restore', 'RestoreMulti']),
    ...mapActions('app', ['Modules']),
    onRequest (props) {
      console.func('components/table/roles:methods.onRequest()', arguments)
      this.$emit('request', props)
    },
    onAdd (props) {
      console.func('components/table/roles:methods.onAdd()', arguments)
      this.title = 'Add New User'
      this.data.role = {
        permissions: []
      }
      this.add = true
      this.edit = true
      this.$refs.dialog.show()
    },
    onSubmit (props) {
      console.func('components/table/roles:methods.onSubmit()', arguments)
      this.Store(this.data.role).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onView (props) {
      console.func('components/table/roles:methods.onView()', arguments)
      this.title = `${props.name} Details`
      this.add = false
      this.edit = false
      this.Show(props.id).then(role => {
        this.data.role = role
        this.$refs.dialog.show()
      })
    },
    onEdit (props) {
      console.func('components/table/roles:methods.onEdit()', arguments)
      this.title = `Edit ${props.name} Details`
      this.add = false
      this.edit = true
      this.Show(props.id).then(role => {
        this.data.role = role
        this.$refs.dialog.show()
      })
    },
    onUpdate () {
      console.func('components/table/roles:methods.onUpdate()', arguments)
      this.Update(this.data.role).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.visiable = false
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onDelete (props) {
      console.func('components/table/roles:methods.onDelete()', arguments)
      this.$core.confirm('Are you sure you want to delete this role?').then(() => {
        this.Delete(props).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onDeleteMulti (props) {
      console.func('components/table/roles:methods.onDeleteMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to delete the ' + ids.length + ' selected role' + (ids.length > 1 ? 's' : '') + '?').then(() => {
        this.DeleteMulti({
          roles: ids
        }).then(() => {
          this.selected = []
          this.onRequest({
            pagination: this.syncPagination
          })
        }).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onRestore (props) {
      console.func('components/table/roles:methods.onRestore()', arguments)
      this.$core.confirm('Are you sure you want to restore this role?').then(() => {
        this.Restore(props).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onRestoreMulti (props) {
      console.func('components/table/roles:methods.onRestoreMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to restore the ' + ids.length + ' selected role' + (ids.length > 1 ? 's' : '') + '?').then(() => {
        this.RestoreMulti({
          roles: ids
        }).then(() => {
          this.selected = []
          this.onRequest({
            pagination: this.syncPagination
          })
        }).catch(error => {
          this.$core.error(error, { title: 'Error' })
        })
      })
    }
  },
  computed: {
    syncPagination: {
      get () {
        return this.pagination
      },
      set (val) {
        return val
      }
    },
    permissions () {
      return this.$store.getters['app/getPermissions']('User')
    }
  },
  mounted () {
    this.Modules().then(data => {
      this.data.permissions = data.permissions
      this.data.roles = data.roles
    })
  }
}
</script>
