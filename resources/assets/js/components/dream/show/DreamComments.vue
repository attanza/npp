<template src="./dream_comments.html"></template>
<script>
import authUserData from '../../../mixins/authUserData';
import CommentSlot from './CommentSlot';
import moment from 'moment';
import BackTop from './../../BackTop';
export default {
  name: "dream_comments",
  components: {
    CommentSlot,
    BackTop,
  },
  data: () => ({
    // comments: [],
    disabled: true,
    body: '',
    nextPageLoading: false,
    pagination: {
      total: 0,
      per_page: 2,
      from: 1,
      to: 0,
      current_page: 1,
    },
    username: '',
  }),
  props: ['dream', 'anchor'],
  watch: {
    body(){
      if (this.body.length > 3) {
        this.disabled = false;
      } else {
        this.disabled = true;
      }
    },
    authUser(){
      if (this.authUser != null) {
        this.username = this.authUser.username;
        this.listen(this.username);
      }
    },
  },

  mounted(){
    this.get_comments(this.pagination.current_page);
    this.$on('comments', function(comments) {
      comments.forEach((comment)=>{
        this.$store.commit('dream_comments_mutation', comment);
      })
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination;
      this.nextPageLoading = false;
    });
  },

  methods: {
    get_comments(page) {
      axios.get('/comments/'+this.dream.id+'?page=' + page).then((resp) => {
        // console.log(resp.data.comments.data);
        this.$emit('comments', resp.data.comments.data);
        this.$emit('pagination', resp.data.pagination)
      });
    },
    sendFromRoot(){
      if (this.body.length > 3) {
        let newComment;
        let now = moment();
        newComment = {
          body: this.body,
          dream_id: this.dream.id,
          user_id: this.authUser.id,
          parent_id: 0,
          // profile: this.authProfile,
          // owner: this.authUser,
          // all_replies_with_owner: [],
        }
        this.body = '';
        this.saveComment(newComment);
      }
    },
    saveComment(newComment){
      axios.post('/api/comment', newComment).then((resp)=>{
        if(resp.status == 200){
          this.$store.commit('dream_comments_add_mutation', resp.data.comment);
          this.$scrollTo("#last_root_comment");
        }
      });
    },

    next_page(){
      this.nextPageLoading = true;
      this.changePage(this.pagination.current_page + 1);
    },
    changePage(page) {
      this.pagination.current_page = page
      this.get_comments(page)
    },
    listen(username){
        Echo.private('npp-user.'+username)
        .notification((notification) => {
            if (notification.index != 'index') {
              let data = {
                index: notification.index,
                comment: notification.comment
              }
              this.$store.commit('dream_comments_mutation_with_index', data);
            } else {
              this.$store.commit('dream_comments_add_mutation', notification.comment);
            }
        });
    }
  },
  computed: {
    comments(){
      return this.$store.state.dream_comments;
    },
  },
  mixins: [authUserData],

}
</script>
<style lang="scss" scoped>
.textarea{
  min-height: 50px;
}
#dream_comments {
  padding-bottom: 20px;
  padding-right: 20px;
  max-height: 150vh;
  overflow-y: scroll;
  overflow-x: visible;
}
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
}
</style>
