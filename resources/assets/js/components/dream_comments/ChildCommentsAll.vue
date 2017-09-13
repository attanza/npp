<template src="./child_comments_all.html"></template>
<script>
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import ReplyChild from './ReplyChild';
import Tooltip from 'vue-bulma-tooltip';
import childComments from '../../mixins/childComments';
import authUserData from '../../mixins/authUserData';
export default {
  name: "child_comments_all",
  components: {
    ReplyChild, Tooltip
  },
  props: ['dream_id'],
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
    showModal: false,
    commentIdToBeDelete: '',
    showConfirm: false
  }),
  watch: {
    currentParentComment(){
      if (this.currentParentComment != null) {
        this.url = '/dream-comments/child-comments/'+this.currentParentComment.id+'?page=';
        this.get_comments(this.pagination.current_page);
        this.showModal = true;
      }
    }
  },
  mounted(){
    this.$on('comments', function(comments) {
      comments.forEach((comment)=>{
        this.comments.unshift(comment);
      });
      this.parrentLoad = false;
      this.morePageLoad = false;
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    });
    this.$on('onDelete', function(comment){
      let newComments = _.pull(this.comments, comment);
      this.comments = [];
      this.comments = newComments;
    });

  },
  methods: {
    closeModal(){
      let comments = this.comments;
      this.comments = [];
      this.showModal = false;
      this.commitCurrentParentComment(null);
      window.eventBus.$emit('closeChildComments', comments);
    },
    get_comments(page) {
      axios.get(this.url+page).then((resp)=>{
        this.$emit('comments', resp.data.data)
        this.$emit('pagination', resp.data.pagination)
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    changePage(page) {
      this.pagination.current_page = page
      this.get_comments(page)
    },
    pushChildComment(comment){
      this.comments.push(comment);
    },
    get_refresh(){
      this.onRefresh = true;
      this.comments = [];
      this.get_comments(this.pagination.current_page);
    },
  },
  mixins: [paginationData, catchJsonErrors, childComments, authUserData]
}
</script>
<style lang="scss" scoped>
.modal {
  z-index: 100;
}
.media {
  border-top: 0px;
}
.is-right {
  margin-left: auto;
}
.modal-card-head {
  background-color: #fff;
}
</style>
