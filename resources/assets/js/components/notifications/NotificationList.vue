<template>
  <div id="notification_list">
    <div class="panel">
      <a class="panel-block animated fadeIn" v-for="not in notifications" :class="{'is-active' : !not.read}" @click="setRead(not.id, not.url)">
        <div class="columns is-mobile">
          <div class="column is-narrow">
            <figure class="image is-64x64">
              <img :src="not.avatar" style="border-radius: 50%;">
            </figure>
          </div>
          <div class="column">
            {{not.msg}} <br>
            <span v-html="not.type" class="npp-not"></span>
            <small>{{not.created_at | moment("from", "now") }}</small>
          </div>
        </div>
      </a>
    </div>
    <paginator :pagination="pagination" :pagesNumber="pagesNumber" :isActived="isActived" @changePage="changePage"></paginator>
  </div>
</template>
<script>
import Paginator from '../admin/Paginator';
import TableSearch from '../admin/TableSearch';
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
export default {
  name: "notification_list",
  components: {
    Paginator, TableSearch
  },
  data: () => ({
    notifications: [],
    url: '/api/notification/listing',
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
    this.get_notifications(this.pagination.current_page)
    this.$on('notifications', function(notifications) {
      this.notifications = notifications;
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    });
  },

  methods: {
    get_notifications(page) {
      var vm = this
      axios.post(this.url+'?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        vm.$emit('notifications', resp.data.notifications)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_notifications(page)
    },

    paginateChange(data){
      this.paginate = data.paginate;
      this.query = data.query;
      this.get_notifications(this.pagination.current_page);
    },

    setRead(id, url) {
      axios.put('/api/notification/'+id).then((resp) =>{
        if (resp.status == 200) {
          window.location.replace(url);
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
  },
  mixins: [paginationData, catchJsonErrors]
}
</script>
<style lang="scss" scoped>
.npp-not{
  color: #00d1b2;
}
</style>
