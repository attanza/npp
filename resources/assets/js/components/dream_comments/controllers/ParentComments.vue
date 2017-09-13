<template src='../views/parent_comments.html'></template>
<script>
import Comment from '../slots/Comment';
import authUserData from '../../../mixins/authUserData';
import catchJsonErrors from '../../../mixins/catchJsonErrors';
import paginationData from '../../../mixins/paginationData';
import SimplePaginator from '../slots/SimplePaginator';
import ChildComments from './ChildComments'
import ReplyChildInput from '../slots/ReplyChildInput';
export default {
  name: "parent_comments",
  components: {
    Comment, SimplePaginator, ChildComments, ReplyChildInput
  },
  props: ['dream_id'],
  data: () => ({
    pagination: {
      total: 0,
      per_page: 2,
      from: 1,
      to: 0,
      current_page: 1,
    },
    offset: 2,
    loader: {
      morePage: false, parent: false, refresh: false
    },
  }),

  created(){
    this.get_comments(this.pagination.current_page);
    window.eventBus.$on('reply_parent', this.reply_parent)
    window.eventBus.$on('onDelete', this.onDelete);
  },
  methods: {
    get_comments(page) {
      axios.get('/dream-comments/parent-comments/'+this.dream_id+'?page='+page).then((resp)=>{
        if (resp.status == 206) {
          this.pagination = resp.data.pagination;
          resp.data.data.forEach((comment)=>{
            this.$store.commit('dream_comments_mutation', comment);
            this.loader.morePage = false;
          });
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    reply_parent: _.debounce(function(id){
      let elId = "reply_parent_"+id;
      let bodyEl = "replyBody_"+id;
      let el = document.getElementById(elId);
      el.style.display = 'block';
      document.getElementById(bodyEl).focus();
      let scrolEl = "#reply_parent_"+id;
      this.scroll(scrolEl);
    },200),
    onUpdate(data){
      axios.put('/api/parent-comments/'+data.id, data).then((resp)=>{
        if (resp.status == 200) {
          this.$store.commit('dream_comments_edit_mutation', resp.data.comment);
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    onDelete(id){
      axios.delete('/api/comment/'+id).then((resp)=>{
        if (resp.status == 200) {
          this.onRefresh();
          this.throw_noty('success', 'Komen dihapus')
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },

    changePage(page) {
      this.loader.morePage = true;
      this.pagination.current_page = page
      this.get_comments(page)
    },

    onRefresh(){
      this.pagination.current_page = 1
      this.$store.commit('clear_comments');
      this.get_comments(this.pagination.current_page);
    },

  },
  computed: {
    parentComments(){
      return this.$store.state.dream_comments;
    }
  },
  mixins: [authUserData, catchJsonErrors, paginationData]

}
</script>
<style lang="scss" scoped>
</style>
