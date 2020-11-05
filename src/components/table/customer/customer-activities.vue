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
          </template>
        </table-dialog>
      </div>
    </template>
    <q-table
      class="main-table"
      :data="data"
      :columns="columns"
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
                    <tooltip position="top">Add activity</tooltip>
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
                    <tooltip position="top">Delete selected activity</tooltip>
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
                    <tooltip position="top">Restore selected activity</tooltip>
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
          <avatar class="cursor-pointer" :activity="props.row" size="30px" />
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
      loading: false,
      columns: [
        { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true, style: 'width: 30px' },
        { name: 'label', align: 'left', label: 'Label', field: 'label', sortable: true, style: 'width: 100px' },
        { name: 'actions', align: 'right', sortable: false }
      ],
      data: [],
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
      edit: true
    }
  },
  props: {
    customer: {
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
    ...mapActions('activity', ['List', 'Show', 'Store', 'Update', 'Delete', 'DeleteMulti', 'Restore', 'RestoreMulti']),
    onRequest (props) {
      console.func('components/table/customer/activities:methods.onRequest()', arguments)
      const { page, rowsPerPage, sortBy, descending, deleted, filter } = props.pagination
      this.loading = true

      this.List({
        customer: this.customer,
        page: page,
        limit: rowsPerPage,
        filter: filter,
        order: sortBy,
        deleted: deleted,
        descending: descending ? 'desc' : 'asc'
      }).then(response => {
        // clear out existing data and add new
        this.data = this.tableData
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
    onAdd (props) {
      console.func('components/table/customer/activities:methods.onAdd()', arguments)
      this.title = 'Add New Contact'
      this.data.activity = {
        type: 'Individual'
      }
      this.add = true
      this.edit = true
      this.$refs.dialog.show()
    },
    onSubmit (props) {
      console.func('components/table/customer/activities:methods.onSubmit()', arguments)
      this.Store(this.data.activity).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onView (props) {
      console.func('components/table/customer/activities:methods.onView()', arguments)
      this.title = `${props.label} Details`
      this.add = false
      this.edit = false
      this.Show(props.id).then(activity => {
        this.data.activity = activity
        this.data.parent_company.push(activity.parent_company)
        this.data.referral_source.push(activity.referral_source)
        this.data.account_manager.push(activity.account_manager)
        this.$refs.dialog.show()
      })
    },
    onEdit (props) {
      console.func('components/table/customer/activities:methods.onEdit()', arguments)
      this.title = `Edit ${props.label} Details`
      this.add = false
      this.edit = true
      this.Show(props.id).then(activity => {
        this.data.activity = activity
        this.$refs.dialog.show()
      })
    },
    onUpdate () {
      console.func('components/table/customer/activities:methods.onUpdate()', arguments)
      this.Update(this.data.activity).then(() => {
        this.$refs.dialog.hide()
      }).catch(error => {
        this.visiable = false
        this.$core.error(error, { title: 'Validation Error' })
      })
    },
    onDelete (props) {
      console.func('components/table/customer/activities:methods.onDelete()', arguments)
      this.$core.confirm('Are you sure you want to delete this activity?').then(() => {
        this.Delete(props).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onDeleteMulti (props) {
      console.func('components/table/customer/activities:methods.onDeleteMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to delete the ' + ids.length + ' selected activit' + (ids.length > 1 ? 'ies' : 'y') + '?').then(() => {
        this.DeleteMulti({
          activities: ids
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
      console.func('components/table/customer/activities:methods.onRestore()', arguments)
      this.$core.confirm('Are you sure you want to restore this activity?').then(() => {
        this.Restore(props).catch(error => {
          this.$core.error(error, { title: 'Validation Error' })
        })
      })
    },
    onRestoreMulti (props) {
      console.func('components/table/customer/activities:methods.onRestoreMulti()', arguments)
      const ids = this.$_.map(this.selected, 'id')
      this.$core.confirm('Are you sure you want to restore the ' + ids.length + ' selected activit' + (ids.length > 1 ? 'ies' : 'y') + '?').then(() => {
        this.RestoreMulti({
          activities: ids
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
      return this.$store.state.activity.data
    },
    permissions () {
      return this.$store.getters['app/getPermissions']('Customer')
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
