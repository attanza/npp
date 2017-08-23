<template src="./dream_list.html"></template>dani.lesmiadi@gma
<script>
import BackTop from './../BackTop';
export default {
  name: 'DreamList',
  components: {
    BackTop
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
      isLoading: false,
    }
  },

  computed: {
    isActived() {
      return this.pagination.current_page
    },

    pagesNumber() {
      if (!this.pagination.to) {
        return []
      }

      var from = this.pagination.current_page - this.offset
      if (from < 1) {
        from = 1
      }

      var to = from + (this.offset * 2)
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page
      }

      var pagesArray = []
      while (from <= to) {
        pagesArray.push(from)
        from++
      }

      return pagesArray
    },
  },

  mounted() {
    this.get_dreams(this.pagination.current_page);
    this.$on('dreams', function(dreams) {
      this.dreams = dreams;
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination;
      this.isLoading = false;
    })
    window.eventBus.$on('new_dream_submited', this.addDream);
  },

  methods: {
    get_dreams(page) {
      this.isLoading = true;
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
  }
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
