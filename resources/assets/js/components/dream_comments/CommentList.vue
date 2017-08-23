<template>
  <div id="comment_list">
    <!--  Paginator -->
    <div class="columns is-mobile m-t-10" v-if="pagination.total > 2 && pagination.to !== pagination.total">
      <div class="column">
        <a href="javascript:void(0)" @click="next_page">
          sebelumnya ...
        </a>
        <span class="icon is-small" v-show="nextPageLoading">
          <i class="fa fa-spinner fa-spin"></i>
        </span>
      </div>
      <div class="column">
        <div class="is-pulled-right">
          <span class="m-r-10">
            <small>{{pagination.to}} dari {{pagination.total}}</small>
          </span>
        </div>
      </div>
    </div>
    <!-- End of Paginator -->

    <div class="comment-wrapper">
      <div v-for="comment in comments">
        <comment-view :comment="comment" :size="'is-32x32'"></comment-view>
        <div class="child-comments-wrapper m-l-20" v-if="comment.all_replies_with_owner" v-for="comment in comment.all_replies_with_owner">
          <comment-view :comment="comment" :size="'is-24x24'"></comment-view>
        </div>
        <div class="comment-input">
          <comment-input-small :comment="comment"></comment-input-small>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
import CommentView from './CommentView';
import CommentInput from './CommentInput';
import CommentInputSmall from './CommentInputSmall';
export default {
  name: "comment_list",
  components: {
    CommentView, CommentInput, CommentInputSmall
  },
  data: () => ({
    comments: [],
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
  }),
  props: ['dream_id'],
  mounted(){
    this.get_comments(this.pagination.current_page);
    this.$on('comments', function(comments) {
      comments.forEach((comment)=>{
        this.comments.unshift(comment);
      })
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination;
      this.nextPageLoading = false;
    })
    // console.log(this.comments);
    window.eventBus.$on('newComment', this.newComment);

  },
  methods: {
    get_comments(page) {
      this.isLoading = true;
      axios.get('/comments/'+this.dream_id+'?page=' + page).then((resp) => {
        // console.log(resp.data.comments.data);
        this.$emit('comments', resp.data.comments.data);
        this.$emit('pagination', resp.data.pagination)
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
    newComment(newComment){
      this.comments.push(newComment);
    }
  },
}
</script>
<style lang="scss" scoped>
.comment-wrapper {
  margin-top: 10px;
  padding-top: 20px;
  padding-right: 20px;
  max-height: 100vh;
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
.child-comments-wrapper{
  padding-left: 10px;
  border-left: 1px solid #ccc;
}
</style>
