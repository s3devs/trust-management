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
            <div class="text-subtitle1 col-xs-12 text-dark">Essential</div>
            <div class="col-xs-12 col-sm-4">
              <q-input :readonly="!edit" v-model="data.user.first_name" type="text" label="First Name" />
            </div>
            <div class="col-xs-12 col-sm-4">
              <q-input :readonly="!edit" v-model="data.user.surname" type="text" label="Surname" />
            </div>
            <div class="col-xs-12 col-sm-4">
              <q-input :readonly="!edit" v-model="data.user.email" type="text" label="Email Address" />
            </div>
            <div v-if="add" class="col-xs-12 col-sm-4">
              <q-input
                :type="isPwd ? 'password' : 'text'"
                label="Password"
                :readonly="!edit" v-model="data.user.password"
                color="blue-grey-14"
              >
                <template
                  v-slot:append
                >
                  <q-icon
                    :name="isPwd ? 'fal fa-eye-slash' : 'fal fa-eye'"
                    class="cursor-pointer"
                    @click="isPwd = !isPwd"
                    size="16px"
                  />
                </template>
              </q-input>
            </div>
            <div v-if="add" class="col-xs-12 col-sm-4">
              <q-input
                :type="isConfPwd ? 'password' : 'text'"
                label="Password"
                :readonly="!edit" v-model="data.user.password_confirmation"
                color="blue-grey-14"
              >
                <template
                  v-slot:append
                >
                  <q-icon
                    :name="isConfPwd ? 'fal fa-eye-slash' : 'fal fa-eye'"
                    class="cursor-pointer"
                    @click="isConfPwd = !isConfPwd"
                    size="16px"
                  />
                </template>
              </q-input>
            </div>
            <div class="col-xs-12 col-sm-4">
              <q-input :readonly="!edit" v-model="data.user.mobile_number" type="text" label="Phone Number" />
            </div>
            <div class="col-xs-12 col-sm-4">
               <q-input
                :readonly="!edit" v-model="data.user.calendar_color"
                :rules="['anyColor']"
                label="Calendar Colour">
                <template v-slot:prepend>
                  <q-icon
                    :style="{ 'color': data.user.calendar_color }"
                    name="fas fa-square-full"
                  />
                </template>
                <template v-slot:append>
                  <q-icon
                    name="colorize"
                    class="cursor-pointer"
                  >
                    <q-popup-proxy
                      transition-show="scale"
                      transition-hide="scale"
                    >
                      <q-color
                        :readonly="!edit" v-model="data.user.calendar_color"
                        format-model="hex"
                      />
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div class="col-xs-12 col-sm-4">
              <q-select
                :readonly="!edit" v-model="data.user.roles"
                use-chips
                option-value="id"
                option-label="name"
                map-options
                multiple
                :options="data.roles"
                label="Roles"
              />
            </div>
            <div class="col-xs-12">
              <div class="text-subtitle1 text-dark">Employment Details</div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <q-input :readonly="!edit" v-model="data.user.job_role" type="text" label="Job Role" />
            </div>
            <div class="col-xs-12 col-sm-4">
              <q-input type="number" step="0.01" :readonly="!edit" v-model="data.user.hourly_rate_standard" label="Hourly Rate Standard">
                <template v-slot:prepend>
                  <q-icon name="fal fa-pound-sign" />
                </template>
              </q-input>
            </div>
            <div class="col-xs-12 col-sm-4">
              <q-input type="number" step="0.01" :readonly="!edit" v-model="data.user.hourly_rate_overtime" label="Hourly Rate Overtime">
                <template v-slot:prepend>
                  <q-icon name="fal fa-pound-sign" />
                </template>
              </q-input>
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
                    :ticked.sync="data.user.permissions"
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
                    icon="fal fa-user-plus"
                    color="positive"
                    size="10px"
                    @click="onAdd"
                    class="q-pa-sm"
                  >
                    <tooltip position="top">Add user</tooltip>
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
                    <tooltip position="top">Delete selected user</tooltip>
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
                    <tooltip position="top">Restore selected user</tooltip>
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
          <avatar class="cursor-pointer" :user="props.row" size="30px" />
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
        user: {}
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
    ...mapActions('user', ['Show', 'Store', 'Update', 'Delete', 'DeleteMulti', 'Restore', 'RestoreMulti']),
    ...mapActions('app', ['Modules']),
    onRequest (props) {
      console.func('components/table/users:methods.onRequest()', arguments)
      this.$emit('request', props)
    },
    onAdd (props) {
      console.func('components/table/users:methods.onAdd()', arguments)
      this.title = 'Add New User'
      this.data.user = {
        permissions: []
      }
      this.add = true
      this.edit = true
      this.$refs.dialog.show()
    },
    onSubmit (props) {
      console.func('components/table/users:methods.onSubmit()', arguments)
      this.Store(this.data.user).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onView (props) {
      console.func('components/table/users:methods.onView()', arguments)
      this.title = `${props.name} Details`
      this.add = false
      this.edit = false
      this.Show(props.id).then(user => {
        this.data.user = user
        this.$refs.dialog.show()
      })
    },
    onEdit (props) {
      console.func('components/table/users:methods.onEdit()', arguments)
      this.title = `Edit ${props.name} Details`
      this.add = false
      this.edit = true
      this.Show(props.id).then(user => {
        this.data.user = user
        this.$refs.dialog.show()
      })
    },
    onUpdate () {
      console.func('components/table/users:methods.onUpdate()', arguments)
      this.Update(this.data.user).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.visiable = false
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onDelete (props) {
      console.func('components/table/users:methods.onDelete()', arguments)
      this.$core.confirm('Are you sure you want to delete this user?').then(() => {
        this.Delete(props).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onDeleteMulti (props) {
      console.func('components/table/users:methods.onDeleteMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to delete the ' + ids.length + ' selected user' + (ids.length > 1 ? 's' : '') + '?').then(() => {
        this.DeleteMulti({
          users: ids
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
      console.func('components/table/users:methods.onRestore()', arguments)
      this.$core.confirm('Are you sure you want to restore this user?').then(() => {
        this.Restore(props).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onRestoreMulti (props) {
      console.func('components/table/users:methods.onRestoreMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to restore the ' + ids.length + ' selected user' + (ids.length > 1 ? 's' : '') + '?').then(() => {
        this.RestoreMulti({
          users: ids
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
