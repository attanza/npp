<template>
  <div :id="'c'+index" style="display: none;">
    <article class="media m-t-10">
      <figure class="media-left">
        <p class="image is-32x32">
          <img :src="this.authProfile.photo_path">
        </p>
      </figure>
      <div class="media-content">
        <div class="field">
          <p class="control">
            <textarea class="textarea" v-model="body" name="body"
            :id="'body_'+index" placeholder="Taggapan..." rows="1" ></textarea>
          </p>
        </div>
        <div class="field is-grouped is-grouped-right">
          <p class="control">
            <a class="button is-primary is-small" :disabled="disabled" @click="sendFromChild">
              <span class="icon is-small m-r-10"><i class="fa fa-paper-plane"></i></span>Kirim
            </a>
          </p>
        </div>
      </div>
    </article>
  </div>
</template>
<script>
import authUserData from '../../../mixins/authUserData';
import moment from 'moment'
export default {
  name: "comment_add",
  data: () => ({
    disabled: true,
    body: '',
  }),

  props: ['comment', 'index'],

  watch: {
    body(){
      if (this.body.length > 3) {
        this.disabled = false;
      } else {
        this.disabled = true;
      }
    }
  },

  mounted(){
    // console.log(this.comment);
  },

  methods: {
    sendFromChild() {
      if (this.body.length > 3) {
        let newComment;
        let now = moment();
        newComment = {
          // all_replies_with_owner: [],
          body: this.body,
          dream_id: this.comment.dream_id,
          user_id: this.authUser.id,
          parent_id: this.comment.id,
          index: this.index,
          // profile: this.authProfile,
          // owner: this.authUser,
        }
        // console.log(newComment);
        this.body = '';

        document.getElementById('c'+this.index).style.display = "none";
        axios.post('/api/comment', newComment).then((resp)=>{
          // console.log(resp);
          if (resp.status == 200) {
            let data = {
              index: this.index,
              comment: resp.data.comment
            }
            this.$store.commit('dream_comments_mutation_with_index', data);
          }
        });
        // this.$scrollTo("#last_child_comment");

      }
    },
  },
  computed: {
    comments_count(){
      return this.$store.getters.dream_comments_count;
    }
  },
  mixins: [authUserData],

}
</script>
<style lang="scss" scoped>
.textarea {
  min-height: 40px;
}
</style>
