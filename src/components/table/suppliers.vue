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
            <div class="col-xs-12 q-pt-none">
              <template>
                <div>
                  <q-tabs
                    v-model="tab"
                    inline-label
                    no-caps
                    class="text-primary"
                  >
                    <q-tab name="essential" label="Essential Information" />
                    <q-tab :disable="add" name="contacts" label="Contacts" />
                    <q-tab :disable="add" name="locations" label="Locations" />
                  </q-tabs>
                  <q-separator size="2px"/>
                </div>
              </template>
              <q-tab-panels class="bg-transparent" v-model="tab">
                <q-tab-panel name="essential">
                  <div class="row q-col-gutter-md">
                    <div class="col-xs-12 col-sm-4">
                      <q-input :readonly="!edit" v-model="data.supplier.label" type="text" label="Label" />
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <q-input :readonly="!edit" v-model="data.supplier.company_name" type="text" label="Company Name" />
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <q-select
                        :readonly="!edit" v-model="data.supplier.account_manager_id"
                        label="Account Manager"
                        use-chips
                        use-input
                        map-options
                        :options="data.account_manager"
                        option-value="id"
                        option-label="name"
                        emit-value
                        @filter="onManagerLoad"
                      />
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <q-input :readonly="!edit" v-model="data.supplier.general_contact_number" type="text" label="General Contact Number" />
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <q-input :readonly="!edit" v-model="data.supplier.general_email_address" type="text" label="General Email Address" />
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <q-select
                        :readonly="!edit" v-model="data.supplier.status"
                        label="Status"
                        use-chips
                        map-options
                        :options="[
                          'Active',
                          'On Stop'
                        ]"
                      />
                    </div>
                  </div>
                </q-tab-panel>

                <q-tab-panel name="contacts">
                  <supplier-contacts :supplier="data.supplier.id" :rowsPerPage="15"/>
                </q-tab-panel>

                <q-tab-panel name="locations">
                  <supplier-locations :supplier="data.supplier.id" :rowsPerPage="15"/>
                </q-tab-panel>
              </q-tab-panels>
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
                    <tooltip position="top">Add supplier</tooltip>
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
                    <tooltip position="top">Delete selected supplier</tooltip>
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
                    <tooltip position="top">Restore selected supplier</tooltip>
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
          <avatar class="cursor-pointer" :supplier="props.row" size="30px" />
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
        supplier: {
        },
        account_manager: []
      },
      selected: [],
      title: '',
      visiable: false,
      add: false,
      edit: true,
      tab: 'essential'
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
    ...mapActions('supplier', [
      'List',
      'Show',
      'Store',
      'Update',
      'Delete',
      'DeleteMulti',
      'Restore',
      'RestoreMulti'
    ]),
    onRequest (props) {
      console.func('components/table/suppliers:methods.onRequest()', arguments)
      this.$emit('request', props)
    },
    onCompanyLoad (val, update) {
      this.List({
        filter: val,
        limit: 100
      }).then(company => {
        company.data.forEach(element => {
          this.data.parent_company.push(element)
        })
        update()
      })
    },
    onManagerLoad (val, update) {
      this.$store.dispatch('user/List', {
        filter: val,
        limit: 100
      }).then(company => {
        company.data.forEach(element => {
          this.data.account_manager.push(element)
        })
        update()
      })
    },
    onAdd (props) {
      console.func('components/table/suppliers:methods.onAdd()', arguments)
      this.title = 'Add New Supplier'
      this.data.supplier = {
        type: 'Individual',
        prospect: (this.syncPagination.prospect) ? 1 : 0
      }
      this.add = true
      this.edit = true
      this.$refs.dialog.show()
    },
    onSubmit (props) {
      console.func('components/table/suppliers:methods.onSubmit()', arguments)
      this.Store(this.data.supplier).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onView (props) {
      console.func('components/table/suppliers:methods.onView()', arguments)
      this.title = `${props.label} Details`
      this.add = false
      this.edit = false
      this.Show(props.id).then(supplier => {
        this.data.supplier = supplier
        this.data.account_manager.push(supplier.account_manager)
        this.$refs.dialog.show()
      })
    },
    onEdit (props) {
      console.func('components/table/suppliers:methods.onEdit()', arguments)
      this.title = `Edit ${props.label} Details`
      this.add = false
      this.edit = true
      this.Show(props.id).then(supplier => {
        this.data.supplier = supplier
        this.data.account_manager.push(supplier.account_manager)
        this.$refs.dialog.show()
      })
    },
    onUpdate () {
      console.func('components/table/suppliers:methods.onUpdate()', arguments)
      this.Update(this.data.supplier).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.visiable = false
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onDelete (props) {
      console.func('components/table/suppliers:methods.onDelete()', arguments)
      this.$core.confirm('Are you sure you want to delete this supplier?').then(() => {
        this.Delete(props).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onDeleteMulti (props) {
      console.func('components/table/suppliers:methods.onDeleteMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to delete the ' + ids.length + ' selected supplier' + (ids.length > 1 ? 's' : '') + '?').then(() => {
        this.DeleteMulti({
          suppliers: ids
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
      console.func('components/table/suppliers:methods.onRestore()', arguments)
      this.$core.confirm('Are you sure you want to restore this supplier?').then(() => {
        this.Restore(props).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onRestoreMulti (props) {
      console.func('components/table/suppliers:methods.onRestoreMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to restore the ' + ids.length + ' selected supplier' + (ids.length > 1 ? 's' : '') + '?').then(() => {
        this.RestoreMulti({
          suppliers: ids
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
      return this.$store.getters['app/getPermissions']('Supplier')
    }
  }
}
</script>
