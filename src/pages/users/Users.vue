<template>
  <q-page padding>
    <users
      ref="users"
      :table="users"
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
      users: {
        columns: [
          { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true, style: 'width: 30px' },
          { name: 'avatar', align: 'left', label: 'Avatar', field: 'avater', sortable: false, style: 'width: 30px' },
          { name: 'first_name', align: 'left', label: 'First Name', field: 'first_name', sortable: true },
          { name: 'surname', align: 'left', label: 'Surname', field: 'surname', sortable: true },
          {
            name: 'last_login_date',
            align: 'left',
            label: 'Last Login',
            field: row => row.last_login_date ? row.last_login_date.date_time : 'Never',
            sortable: false
          },
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
    ...mapActions('user', ['List']),
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
        this.users.data = this.tableData
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
      return this.$store.state.user.data
    }
  }
}
</script>
