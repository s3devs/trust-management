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
            <div class="col-sm-4 col-xs-12">
              <q-input :readonly="!edit" v-model="data.contact.label" type="text" label="Label" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input :readonly="!edit" v-model="data.contact.first_name" type="text" label="First Name" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input :readonly="!edit" v-model="data.contact.surname" type="text" label="Surname" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input :readonly="!edit" v-model="data.contact.role" type="text" label="Role" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input :readonly="!edit" v-model="data.contact.email_address" type="text" label="Email Address" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input :readonly="!edit" v-model="data.contact.contact_number" type="text" label="Contact Number" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-select
                :readonly="!edit" v-model="data.contact.location_id"
                label="Location"
                use-chips
                use-input
                map-options
                :options="locations"
                option-value="id"
                option-label="label"
                input-debounce="0"
                emit-value
                @filter="onLocationLoad"
              />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-select :readonly="!edit" v-model="data.contact.default" :options="[
                {
                  label: 'Yes',
                  value: 1
                },
                {
                  label: 'No',
                  value: 0
                }
              ]" emit-value map-options label="Default" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-select :readonly="!edit" v-model="data.contact.accounts" :options="[
                {
                  label: 'Yes',
                  value: 1
                },
                {
                  label: 'No',
                  value: 0
                }
              ]" emit-value map-options label="Accounts" />
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
      :filter="pagination.filter"
      :pagination.sync="pagination"
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
                    <tooltip position="top">Add contact</tooltip>
                  </q-btn>
                  <q-btn
                    v-if="!pagination.deleted"
                    :disabled="selected.length == 0"
                    squared
                    icon="delete"
                    color="negative"
                    size="10px"
                    class="q-pa-sm"
                    @click="onDeleteMulti"
                  >
                    <tooltip position="top">Delete selected contact</tooltip>
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
                    <tooltip position="top">Restore selected contact</tooltip>
                  </q-btn>
                </template>
              </q-btn-group>
              <q-toggle
                v-if="selected"
                v-model="pagination.deleted"
                checked-icon="delete"
                color="red"
                label="View Deleted"
              />
            </div>
            <div class="col-sm-4 col-xs-12 text-right">
              <q-input
                v-model="pagination.filter"
                outlined
                square
                placeholder="Quick search"
                hint="First name / Surname / Email"
                dense
              >
                <template v-slot:append>
                  <q-icon
                    v-if="pagination.filter === ''"
                    name="fal fa-search"
                    size="14px"
                  />
                  <q-icon
                    v-else
                    name="fal fa-times"
                    class="cursor-pointer"
                    @click="pagination.filter = ''"
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
          <avatar class="cursor-pointer" :contact="props.row" size="30px" />
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
                  v-if="!pagination.deleted && permissions.includes('Show')"
                  @click="onView(props.row)"
                  clickable
                  v-close-popup
                  class="q-pt-sm q-pb-sm text-weight-bold text-uppercase"
                  style="font-size: 0.7rem"
                >
                  <q-item-section>view</q-item-section>
                </q-item>
                <q-item
                  v-if="!pagination.deleted && permissions.includes('Update')"
                  @click="onEdit(props.row)"
                  clickable
                  v-close-popup
                  class="q-pt-sm q-pb-sm text-weight-bold text-uppercase"
                  style="font-size: 0.7rem"
                >
                  <q-item-section>edit</q-item-section>
                </q-item>
                <q-item
                  v-if="!pagination.deleted && permissions.includes('Destroy')"
                  @click="onDelete(props.row)"
                  clickable
                  v-close-popup
                  class="q-pt-sm q-pb-sm text-weight-bold text-uppercase"
                  style="font-size: 0.7rem"
                >
                  <q-item-section>delete</q-item-section>
                </q-item>
                <q-item
                  v-if="pagination.deleted && permissions.includes('Destroy')"
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
        contact: {}
      },
      loading: false,
      table: {
        columns: [
          { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true, style: 'width: 30px' },
          { name: 'label', align: 'left', label: 'Label', field: 'label', sortable: true, style: 'width: 100px' },
          { name: 'first_name', align: 'left', label: 'First Name', field: 'first_name', sortable: true, style: 'width: 100px' },
          { name: 'surname', align: 'left', label: 'Surname', field: 'surname', sortable: true, style: 'width: 100px' },
          { name: 'role', align: 'left', label: 'Role', field: 'role', sortable: true, style: 'width: 100px' },
          { name: 'email_address', align: 'left', label: 'Email Address', field: 'email_address', sortable: true, style: 'width: 100px' },
          { name: 'contact_number', align: 'left', label: 'Contact Number', field: 'contact_number', sortable: true, style: 'width: 100px' },
          { name: 'location_id', align: 'left', label: 'Location', field: 'location_id', sortable: true, style: 'width: 100px' },
          { name: 'default', align: 'left', label: 'Default', field: 'default', sortable: true, style: 'width: 100px' },
          { name: 'accounts', align: 'left', label: 'Accounts', field: 'accounts', sortable: true, style: 'width: 100px' },
          { name: 'actions', align: 'right', sortable: false }
        ],
        data: []
      },
      pagination: {
        sortBy: 'id',
        descending: true,
        page: 1,
        filter: '',
        deleted: false,
        rowsPerPage: 15,
        rowsNumber: 15
      },
      selected: [],
      title: '',
      visiable: false,
      add: false,
      edit: true,
      locations: []
    }
  },
  props: {
    supplier: {
      required: true,
      type: Number
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
    rowsPerPage: {
      required: false,
      type: Number,
      default: () => 15
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
    }
  },
  methods: {
    ...mapActions('supplierContact', ['List', 'Show', 'Store', 'Update', 'Delete', 'DeleteMulti', 'Restore', 'RestoreMulti']),
    onRequest (props) {
      console.func('components/table/supplier/contacts:methods.onRequest()', arguments)
      const { page, rowsPerPage, sortBy, descending, deleted, filter } = props.pagination
      this.loading = true

      this.List({
        supplier: this.supplier,
        page: page,
        limit: rowsPerPage,
        filter: filter,
        order: sortBy,
        deleted: deleted,
        descending: descending ? 'desc' : 'asc'
      }).then(response => {
        // clear out existing data and add new
        this.table.data = this.tableData
        // update rowsCount with appropriate value
        this.pagination.rowsNumber = response.total

        // don't forget to update local pagination object
        this.pagination.page = page
        this.pagination.rowsPerPage = rowsPerPage
        this.pagination.sortBy = sortBy
        this.pagination.descending = descending

        // ...and turn of loading indicator
        this.loading = false
      })
    },
    onLocationLoad (val, update) {
      this.$store.dispatch('supplierLocation/List', {
        supplier: this.supplier,
        filter: val,
        limit: 100
      }).then(company => {
        company.data.forEach(element => {
          this.locations.push(element)
        })
        update()
      })
    },
    onAdd (props) {
      console.func('components/table/supplier/contacts:methods.onAdd()', arguments)
      this.title = 'Add New Contact'
      this.data.contact = {}
      this.add = true
      this.edit = true
      this.$refs.dialog.show()
    },
    onSubmit (props) {
      console.func('components/table/supplier/contacts:methods.onSubmit()', arguments)
      this.Store({
        supplier: this.supplier,
        contact: this.data.contact
      }).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onView (props) {
      console.func('components/table/supplier/contacts:methods.onView()', arguments)
      this.title = `${props.label} Details`
      this.add = false
      this.edit = false
      this.Show({
        supplier: this.supplier,
        contact: props
      }).then(contact => {
        this.data.contact = contact
        this.$refs.dialog.show()
      })
    },
    onEdit (props) {
      console.func('components/table/supplier/contacts:methods.onEdit()', arguments)
      this.title = `Edit ${props.label} Details`
      this.add = false
      this.edit = true
      this.Show({
        supplier: this.supplier,
        contact: props
      }).then(contact => {
        this.data.contact = contact
        this.$refs.dialog.show()
      })
    },
    onUpdate () {
      console.func('components/table/supplier/contacts:methods.onUpdate()', arguments)
      this.Update({
        supplier: this.supplier,
        contact: this.data.contact
      }).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.visiable = false
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onDelete (props) {
      console.func('components/table/supplier/contacts:methods.onDelete()', arguments)
      this.$core.confirm('Are you sure you want to delete this contact?').then(() => {
        this.Delete({
          supplier: this.supplier,
          contact: props
        }).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onDeleteMulti (props) {
      console.func('components/table/supplier/contacts:methods.onDeleteMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to delete the ' + ids.length + ' selected contact' + (ids.length > 1 ? 's' : '') + '?').then(() => {
        this.DeleteMulti({
          supplier: this.supplier,
          contacts: ids
        }).then(() => {
          this.selected = []
          this.onRequest({
            pagination: this.pagination
          })
        }).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onRestore (props) {
      console.func('components/table/supplier/contacts:methods.onRestore()', arguments)
      this.$core.confirm('Are you sure you want to restore this contact?').then(() => {
        this.Restore({
          supplier: this.supplier,
          contact: props
        }).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onRestoreMulti (props) {
      console.func('components/table/supplier/contacts:methods.onRestoreMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to restore the ' + ids.length + ' selected contact' + (ids.length > 1 ? 's' : '') + '?').then(() => {
        this.RestoreMulti({
          supplier: this.supplier,
          contacts: ids
        }).then(() => {
          this.selected = []
          this.onRequest({
            pagination: this.pagination
          })
        }).catch(error => {
          this.$core.error(error, { title: 'Error' })
        })
      })
    }
  },
  computed: {
    tableData () {
      return this.$store.state.supplierContact.data
    },
    permissions () {
      return this.$store.getters['app/getPermissions']('Customer')
    }
  },
  watch: {
    'pagination.deleted' (val) {
      this.onRequest({
        pagination: this.pagination
      })
    }
  },
  mounted () {
    this.pagination.rowsPerPage = this.rowsPerPage
    this.pagination.rowsNumber = this.rowsPerPage
    this.onRequest({
      pagination: this.pagination
    })
  }
}
</script>
