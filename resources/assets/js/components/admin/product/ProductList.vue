<template src="./product_list.html"></template>
<script>
import Paginator from '../Paginator';
import TableSearch from '../TableSearch';
import paginationData from '../../../mixins/paginationData';
import ProductAdd from './ProductAdd'
export default {
  name: "product_list",
  components: {
    Paginator, TableSearch, ProductAdd
  },
  data: () => ({
    products: [],
    url: '/api/admin/products/listing',
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
    showProductAdd: false,
  }),


  mounted() {
    this.get_products(this.pagination.current_page)
    this.$on('products', function(products) {
      this.products = products;
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    });
  },

  methods: {
    get_products(page) {
      var vm = this
      axios.post(this.url+'?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        // console.log(resp);
        vm.$emit('products', resp.data.products.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_products(page)
    },

    paginateChange(data){
      this.paginate = data.paginate;
      this.query = data.query;
      this.get_products(this.pagination.current_page);
    },

    onAdd(){
      this.showProductAdd = true;
    },

    onSave(product){
      this.products.unshift(product);
      this.showProductAdd = false;
    },

    show_product(product_no){
      window.location.replace('/admin/products/'+product_no);
    }
  },
  mixins: [paginationData]
}
</script>
<style lang="scss" scoped>
</style>
