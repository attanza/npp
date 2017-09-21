<template src="./dream_list.html"></template>
<script>
import BackTop from './../BackTop';
import DreamSearch from './DreamSearch'
import Paginator from '../admin/Paginator'
import paginationData from '../../mixins/paginationData'
export default {
  name: 'DreamList',
  components: {
    BackTop, DreamSearch, Paginator
  },
  data() {
    return {
      dreams: [],
      pagination: {
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      offset: 3,
      paginate: 9,
    }
  },

  mounted() {
    this.get_dreams(this.pagination.current_page);
    this.$on('dreams', function(dreams) {
      this.dreams = dreams;
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination;
    })
    window.eventBus.$on('new_dream_submited', this.addDream);
  },

  methods: {
    get_dreams(page) {
      var vm = this
      axios.post('/dream/listing?page=' + page, {
        paginate: this.paginate
      })
      .then((resp) => {
        vm.$emit('dreams', resp.data.dreams.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_dreams(page)
    },

    addDream(dream){
      this.dreams.push(dream);
    },

    showDream(slug){
      window.location.replace('/dream/'+slug);
    }
  },
  mixins: [paginationData]
}
</script>

<style lang="css" scoped>
.dream-title{
    position: absolute;
    top: 70%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255,255,255,0.8);
    /*background: linear-gradient(rgba(255, 204, 42,0.5),rgba(255, 204, 42,0.5));*/
    padding: 10px;
    text-align: center;
    width: 100%;
		/*font-weight: bold;*/
}
.dream-title:after{
    visibility: hidden;
    content: " ";
    height: 0;
    display: block;
    clear: both;
}
.media-left .image img {
  border-radius: 50%;
}
</style>
