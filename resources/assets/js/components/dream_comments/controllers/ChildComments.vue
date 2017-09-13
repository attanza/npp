<template>
  <div id="child_comments">
    <a @click="showChildComments(parent)"><small>Selengkapnya...</small></a>
    <div v-for="comment in parent.replies">
      <comment :avatarSize="'is-32x32'" :comment="comment"
      :dream_id="dream_id" @onUpdate="onUpdate" :el="'child'">
        <img slot="avatar" :src="comment.avatar">
        <strong slot="userName">{{comment.name}}</strong>
        <p slot="body" v-html="comment.body"></p>
        <p slot="created" class="is-size-7">{{comment.created_at | moment("from", "now") }}</p>
      </comment>
    </div>
    <child-comments-modal :showModal="showModal" :parent="currentParent" :dream_id="dream_id" @onClose="closeChildCommentsModal"></child-comments-modal>
  </div>
</template>
<script>
import Comment from '../slots/Comment';
import ChildCommentsModal from './ChildCommentsModal';
import catchJsonErrors from '../../../mixins/catchJsonErrors';

export default {
  name: "child_comments",
  components: {
    Comment, ChildCommentsModal
  },
  props: ['parent', 'dream_id'],
  data: () => ({
    showModal: false,
    currentParent: null
  }),
  mounted(){
    window.eventBus.$on('add_child_comment', this.addChild)
    window.eventBus.$on('reply_child', this.reply_child)
  },
  methods: {
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

    onRefresh(){
      this.$store.commit('clear_comments');
      this.get_comments(this.pagination.current_page);
    },
    showChildComments(parentComment){
      this.currentParent = parentComment;
      this.showModal = true;
    },
    closeChildCommentsModal(){
      this.currentParent = null;
      this.showModal = false;
    },
    reply_child: _.debounce(function(id){
      let elId = "reply_parent_"+id;
      let bodyEl = "replyBody_"+id;
      let el = document.getElementById(elId);
      el.style.display = 'block';
      document.getElementById(bodyEl).focus();
      let scrolEl = "#reply_parent_"+id;
      this.scroll(scrolEl);
    },200),
    addChild(data){
      let el = '#child'+data.id;
      this.scroll(el);
    }
  },
  mixins: [catchJsonErrors]
}
</script>
<style lang="scss" scoped>
</style>
