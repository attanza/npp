<template src="./child_comments.html"></template>
<script>
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import Tooltip from 'vue-bulma-tooltip';
import childComments from '../../mixins/childComments';
import authUserData from '../../mixins/authUserData';
import ConfirmModal from '../../components/ConfirmModal';
export default {
  name: "child_comments",
  components: {
    Tooltip, ConfirmModal
  },
  data: () => ({
    cur_parent_comment: null,
  }),
  props: ['index', 'dream_id'],
  mounted(){
    window.eventBus.$on('closeChildComments', this.closeChildComments);
    window.eventBus.$on('confirmed', this.deleteComment);
  },

  watch: {
    cur_parent_comment(){
      if (this.cur_parent_comment != null) {
        this.commitCurrentParentComment(this.cur_parent_comment);
      }
    }
  },

  methods: {
    show_form(parent_id){
      document.getElementById('child_reply_'+parent_id).style.display = "block";
      document.getElementById('body_'+parent_id).focus();
    },
    closeChildComments(){
      this.cur_parent_comment = null;
    },


  },
  computed: {
    comments(){
      return this.$store.state.dream_comments;
    },
    comment(){
      return this.comments[this.index];
    }
  },

  mixins: [paginationData, catchJsonErrors, childComments, authUserData]
}
</script>
<style lang="scss" scoped>
.page-child {
  font-size: 12px;
}
.level {
  margin-bottom: 5px;
}
</style>
