<template>
  <q-page padding>
    <suppliers
      ref="suppliers"
      :table="suppliers"
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
      suppliers: {
        columns: [
          { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true, style: 'width: 30px' },
          { name: 'label', align: 'left', label: 'Label', field: 'label', sortable: true, style: 'width: 100px' },
          { name: 'company_name', align: 'left', label: 'Company Name', field: 'company_name', sortable: true, style: 'width: 100px' },
          { name: 'general_contact_number', align: 'left', label: 'Contact Number', field: 'general_contact_number', sortable: true, style: 'width: 150px' },
          { name: 'general_email_address', align: 'left', label: 'Email Addresss', field: 'general_email_address', sortable: true, style: 'width: 150px' },
          { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true, style: 'width: 100px' },
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
        prospect: false,
        rowsPerPage: 15,
        rowsNumber: 15
      }
    }
  },
  methods: {
    ...mapActions('supplier', ['List']),
    onRequest (props) {
      const { page, rowsPerPage, sortBy, descending, deleted, filter, prospect } = props.pagination
      this.loading = true

      this.List({
        page: page,
        limit: rowsPerPage,
        filter: filter,
        order: sortBy,
        prospect: prospect,
        deleted: deleted,
        descending: descending ? 'desc' : 'asc'
      }).then(response => {
        // clear out existing data and add new
        this.suppliers.data = this.tableData
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
      return this.$store.state.supplier.data
    }
  }
}
</script>
