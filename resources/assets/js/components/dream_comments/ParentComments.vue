<template src="./parent_comments.html"></template>
<script>
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import ChildComments from './ChildComments';
import ReplyChild from './ReplyChild';
import Tooltip from 'vue-bulma-tooltip';
import authUserData from '../../mixins/authUserData';
import EditComment from './EditComment'
export default {
  name: "parent_comments",
  components: {
    ChildComments, ReplyChild, Tooltip, EditComment
  },
  data: () => ({
    comments: [],
    url: '',
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
    currentComment: {}, showEdit: false
  }),
  props: ['dream'],
  watch: {
    isAuth(){
      if (this.isAuth) {
        this.listen(this.dream.slug)
      }
    },
    currentComment(){
      if (this.currentComment != {}) {
        this.showEdit = true;
      } else {
        this.showEdit = false;
      }
    }
  },

  mounted(){
    this.loader.parent = true
    this.url = '/dream-comments/parent-comments/'+this.dream.id+'?page=';
    this.get_comments(this.pagination.current_page);
    this.$on('comments', function(comments) {
      comments.forEach((comment)=>{
        this.comments.unshift(comment);
        // this.$store.commit('dream_comments_mutation', comment)
      });
      this.loader.parent = false;
      this.loader.morePage = false;
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    });
    window.eventBus.$on('onNewComment', this.pushComment)
    window.eventBus.$on('closeChildComments', this.closeChildComments);
  },
  methods: {
    get_comments(page) {
      axios.get(this.url+page).then((resp)=>{
        this.$emit('comments', resp.data.data)
        this.$emit('pagination', resp.data.pagination)
        this.loader.refresh = false;
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
    pushComment(comment){
      this.comments.push(comment);
      let el = '#parent_'+comment.id;
      this.scroll(el);
    },
    scroll: _.debounce(function(el){
      this.$scrollTo(el);
    },500),
    show_form(comment){
      let parent_id = comment.id;
      document.getElementById('child_reply_'+parent_id).style.display = "block";
      document.getElementById('body_'+parent_id).focus();
    },
    get_refresh(){
      this.loader.refresh = true;
      // this.comments = [];
      this.clearComments();
      this.get_comments(this.pagination.current_page);
    },
    pushChildComment(comment){
      console.log('push child');
      this.$store.commit('pushChild', comment);
      document.getElementById('child_reply_'+comment.parent_id).style.display = "none";
      let el = '#child_'+comment.id;
      this.scroll(el);
    },
    closeChildComments(comments){
      let parentComment = _.find(this.comments, ['id', comments[0].parent_id]);
      let newChild = _.takeRight(comments, 2);
      parentComment.replies = newChild;
      let el = '#child_'+newChild[0].id;
      this.scroll(el);
    },
    clearComments(){
      this.$store.commit('clear_comments');
    },
    closeEdit(){
      this.currentComment = {};
      this.showEdit = false;
      console.log(this.showEdit);

    },

    listen(slug){
      Echo.private('npp-dream.'+slug)
      .listen('NewCommentEvent', (e) => {
        if (e.owner_id !== this.authUser.id) {
          if (e.comment.parent_id == 0) {
            this.pushComment(e.comment)
          } else {
            this.pushChildComment(e.comment)
          }
        }
      });
    },

  },
  // computed: {
  //   comments(){
  //     return this.$store.state.dream_comments;
  //   }
  // },

  mixins: [paginationData, catchJsonErrors, authUserData]
}
</script>
<style lang="scss" scoped>
#loader {
   width: 100%;
   height: 100%;
   top: 0;
   left: 0;
   position: relative;
   display: block;
   opacity: 0.7;
  //  background-color: #fff;
   background:rgba(0,0,0,0.5);
   z-index: 99;
   text-align: center;
}
#loading-el {
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 100;
}
</style>
