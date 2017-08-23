<template src="./order_list.html"></template>
<script>
import Paginator from '../Paginator'
import TableSearch from '../TableSearch'

import paginationData from '../../../mixins/paginationData'
export default {
  name: "order_list",
  components: {
    Paginator, TableSearch
  },
  data: () => ({
    orders: [],
    url: '/api/admin/orders/listing',
    pagination: {
      total: 0,
      per_page: 2,
      from: 1,
      to: 0,
      current_page: 1,
    },
    offset: 2,
    paginate: 10,
    query: '',
  }),


  mounted() {
    this.get_orders(this.pagination.current_page)
    this.$on('orders', function(orders) {
      this.orders = orders;
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    });
  },

  methods: {
    get_orders(page) {
      var vm = this
      axios.post(this.url+'?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        // console.log(resp);
        vm.$emit('orders', resp.data.orders.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_orders(page)
    },

    paginateChange(data){
      this.paginate = data.paginate;
      this.query = data.query;
      this.get_orders(this.pagination.current_page);
    },

    get_order_status(id){
      switch (id) {
        case 1:
          return 'Order Baru'

        case 2:
          return 'Pengiriman'

        case 3:
          return 'Selesai'

        case 4:
          return 'Batal'

          break;
        default:

      }
    },

    show_order(order_no){
      window.location.replace('/admin/orders/'+order_no);
    }
  },
  mixins: [paginationData]
}
</script>
<style lang="scss" scoped>
</style>
