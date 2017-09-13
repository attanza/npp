<template>
  <div id="dream_search">

    <div class="field has-addons has-addons-centered">
      <p class="control is-fullwidth has-icons-left">
        <input class="input is-medium" type="text" name="searchQ" v-model="searchQ" placeholder="Cari...">
        <span class="icon is-medium is-left">
          <i class="fa fa-search"></i>
        </span>
      </p>
      <p class="control">
        <a class="button is-primary is-medium" :class="{'is-loading' : isLoading}" @click="clear">
          <span class="icon">
            <i class="fa fa-times-circle"></i>
          </span>
        </a>
      </p>
    </div>

    <dream-search-result :users="users"
    :searchQ="searchQ" @onClose="clear"></dream-search-result>
  </div>
</template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors';
import DreamSearchResult from './DreamSearchResult';
export default {
  name: "dream_search",
  components: {
    DreamSearchResult
  },
  data: () => ({
    searchQ: '',
    isLoading: false,
    users: [],
  }),
  watch: {
    searchQ(){
      if (this.searchQ.length > 2) {
        this.isLoading = true;
        this.searchData(this.searchQ)
      }
    },
  },

  mounted(){
    this.$on('users', function(users){
      this.users = users;
      this.showSearchResult = true

    });
  },

  methods: {
    searchData: _.debounce(function(searchQ){
      axios.post('/dream-search', {query: searchQ}).then((resp)=>{
        if (resp.status == 200) {
          this.$emit('users', resp.data.users)
        }
        this.isLoading = false;
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },500),

    get_data(searchQ){
      this.isLoading = true;
      axios.post('/dream-search', {query: searchQ}).then((resp)=>{
        if (resp.status == 200) {
          this.$emit('users', resp.data.users)
        }
        this.isLoading = false;
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    clear(){
      this.searchQ = '';
      this.users = [];
    }
  },
  mixins: [catchJsonErrors]
}
</script>
<style lang="scss" scoped>

</style>
