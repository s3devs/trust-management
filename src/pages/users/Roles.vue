<template>
  <q-page padding>
    <roles
      ref="roles"
      :table="roles"
      :hidePagination="false"
      :loading="loading"
      :pagination="pagination"
      @request="onRequest"
    />
  </q-page>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data () {
    return {
      loading: false,
      roles: {
        columns: [
          { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true, style: 'width: 30px' },
          { name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true },
          { name: 'slug', align: 'left', label: 'Slug', field: 'slug', sortable: true },
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
      }
    }
  },
  methods: {
    ...mapActions('role', ['List']),
    onRequest (props) {
      const { page, rowsPerPage, sortBy, descending, deleted, filter } = props.pagination
      this.loading = true

      this.List({
        page: page,
        limit: rowsPerPage,
        filter: filter,
        order: sortBy,
        deleted: deleted,
        descending: descending ? 'desc' : 'asc'
      }).then(response => {
        // clear out existing data and add new
        this.roles.data = this.tableData
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
    }
  },
  mounted () {
    this.onRequest({
      pagination: this.pagination
    })
  },
  computed: {
    tableData () {
      return this.$store.state.role.data
    }
  }
}
</script>
