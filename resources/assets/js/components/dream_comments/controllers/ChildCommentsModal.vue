<template src="../views/child_comments_modal.html"></template>
<script>
import authUserData from '../../../mixins/authUserData';
import catchJsonErrors from '../../../mixins/catchJsonErrors';
import paginationData from '../../../mixins/paginationData';
import SimplePaginator from '../slots/SimplePaginator';
import Comment from '../slots/Comment';
import ReplyChildInput from '../slots/ReplyChildInput';
export default {
  name: "child_comments_modal",
  components: {
    Comment, SimplePaginator, ReplyChildInput
  },
  data: () => ({
    comments: [],
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
  props: ['showModal', 'parent', 'dream_id'],
  watch: {
    showModal(){
      if (this.showModal == true) {
        this.onRefresh();
      }
    }
  },
  mounted(){
    window.eventBus.$on('reply_modal', this.reply_modal)
    window.eventBus.$on('add_child_comment', this.AddChild)
  },
  methods: {
    closeModal() {
      this.$emit('onClose');
      this.comments = [];
    },
    get_comments(page) {
      axios.get('/dream-comments/child-comments/'+this.parent.id+'?page='+page).then((resp)=>{
        if (resp.status == 206) {
          this.pagination = resp.data.pagination;
          resp.data.data.forEach((comment)=>{
            this.comments.unshift(comment)
            this.loader.morePage = false;
          });
          this.pagination = resp.data.pagination;
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
      // this.$store.commit('clear_comments');
      this.comments = [];
      this.get_comments(this.pagination.current_page);
    },
    onUpdate(data){
      axios.put('/api/parent-comments/'+data.id, data).then((resp)=>{
        if (resp.status == 200) {
          this.$store.commit('dream_comments_edit_mutation', resp.data.comment);
          let commentEdit = _.find(this.comments, function(c){
            return c.id == data.id
          })
          commentEdit.body = data.body;
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    reply_modal: _.debounce(function(id){
      let elId = "reply_modal_"+id;
      let bodyEl = "replyBody_"+id;
      let el = document.getElementById(elId);
      el.style.display = 'block';
      document.getElementById(bodyEl).focus();
      // let scrolEl = "#reply_modal_"+id;
      // this.scroll(scrolEl);
    },200),
    AddChild(data){
      this.comments.push(data);
      let el = '#modal'+data.id;
      this.scroll(el);
    }
  },
  mixins: [authUserData, catchJsonErrors, paginationData]
}
</script>
<style lang="scss" scoped>
.media .media {
    border-top: 0px;
}
.reply-child {
  // margin-left: -65px;
  position: relative;
}
</style>
