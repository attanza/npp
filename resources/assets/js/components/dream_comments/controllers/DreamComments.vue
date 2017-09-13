<template src="../views/dream_comments.html"></template>
<script>
import authUserData from '../../../mixins/authUserData';
import catchJsonErrors from '../../../mixins/catchJsonErrors';
import CommentInput from '../slots/CommentInput';
import ParentComments from './ParentComments';
export default {
  name: "",
  components: {
    CommentInput, ParentComments
  },
  data: () => ({

  }),
  watch: {
    isAuth(){
      if (this.isAuth) {
        this.listen(this.dream.slug)
      }
    },
  },
  props: ['dream'],
  methods: {
    saveComment(text) {
      axios.post('/api/parent-comments', this.get_data(text)).then((resp)=>{
        if (resp.status == 201) {
          this.$store.commit('dream_comments_add_mutation', resp.data.comment);
          let el = '#parent'+resp.data.comment.id;
          this.scroll(el);
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    get_data(text){
      return {
        dream_id: this.dream.id,
        user_id: this.authUser.id,
        parent_id: 0,
        body: text
      }
    },
    listen(slug){
      Echo.private('npp-dream.'+slug)
      .listen('NewCommentEvent', (e) => {
        if (e.owner_id !== this.authUser.id) {
          let comment = e.comment;
          if (comment.parent_id == 0) {
            this.$store.commit('dream_comments_add_mutation', comment);
          } else {
            this.$store.commit('add_child_comment', comment);
          }
        }
      });
    },

  },
  mixins: [authUserData, catchJsonErrors]

}
</script>
<style lang="scss" scoped>
</style>
