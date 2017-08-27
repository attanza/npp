<template>
  <div id="booster_list">
    <div class="modal" :class="{'is-active' : showModal}">
      <div class="modal-background" @click="onClose"></div>
      <div class="modal-card">
        <header class="modal-card-body boost-header">
          <div class="columns">
            <div class="column">
              <h4 class="subtitle is-4 has-text-warning">{{this.authBoostCount}} Boost</h4>
            </div>
            <div class="column">
              <div class="field has-addons">
                <p class="control is-expanded">
                  <input class="input" type="text" placeholder="Cari..." name="query" v-model="query" @keyup="search">
                </p>
                <p class="control">
                  <a class="button is-warning">
                    <span class="icon"><i class="fa fa-search"></i></span>
                  </a>
                </p>
              </div>
            </div>
          </div>
        </header>
        <section class="modal-card-body">
          <div class="booster-wrapper m-b-10" v-for="user in users" v-if="users.length > 0">
            <div class="columns is-multiline is-mobile is-centered">
              <div class="column is-narrow">
                <a @click="view_user_dream(user.dream_slug)">
                  <figure class="image is-32x32">
                    <img :src="user.avatar">
                  </figure>
                </a>
              </div>
              <div class="column">
                <p>
                  {{user.name}}
                </p>
              </div>
              <div class="column is-3">
                <p class="is-pulled-right is-size-7">{{user.created_at | moment("from", "now") }}</p>
              </div>
            </div>
          </div>
          <paginator :pagination="pagination" :pagesNumber="pagesNumber" :isActived="isActived" @changePage="changePage"></paginator>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-warning is-right" @click="onClose">Tutup</button>
        </footer>
      </div>
    </div>
  </div>
</template>
<script>
import paginationData from '../../mixins/paginationData'
import Paginator from '../admin/Paginator'
import authUserData from '../../mixins/authUserData';

export default {
  name: "booster_list",
  components: {
    Paginator
  },
  props: ['showModal', 'dream_id'],

  data: () => ({
    users: [],
    url: '',
    pagination: {
      total: 0,
      per_page: 2,
      from: 1,
      to: 0,
      current_page: 1,
    },
    offset: 2,
    query: ''
  }),

  mounted() {
    this.url = '/boost/'+this.dream_id+'/listing';
    this.get_users(this.pagination.current_page);
    this.$on('users', function(users) {
      this.users = users;
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    });
  },

  methods: {
    onClose() {
      this.$emit('onClose')
    },

    get_users(page) {
      var vm = this
      axios.post(this.url+'?page=' + page, {
        query: this.query
      }).then((resp) => {
        vm.$emit('users', resp.data.users)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_users(page)
    },

    paginateChange(data){
      this.paginate = data.paginate;
      this.query = data.query;
      this.get_users(this.pagination.current_page);
    },

    search(){
      var getData = this.get_users(1);
      setTimeout(getData, 1000);
    },

    view_user_dream(slug){
      window.location.replace('/dream/'+slug);
    }
  },
  mixins: [paginationData, authUserData]
}
</script>
<style lang="scss" scoped>
.is-right {
  margin-left: auto;
}
.boost-header, .modal-card-foot {
  background-color: #000;
  color: #fff;
}
</style>
