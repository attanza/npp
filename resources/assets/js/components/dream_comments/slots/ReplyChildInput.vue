<template>
  <div :id="el_id" class="reply-child">
    <article class="media animated fadeIn" :class="{'fadeOutUp' : onCancel}">
      <figure class="media-left">
        <p class="image is-32x32">
          <img :src="authAvatar">
        </p>
      </figure>
      <div class="media-content">
        <div class="content">
          <div class="control">
            <textarea class="textarea" v-model="body" rows="1" style="padding: 3px;" :id="'replyBody_'+comment_id"></textarea>
            <span><small><a @click="cancelEdit">cancel</a></small></span>
          </div>
        </div>
      </div>
      <div class="media-right">
        <button type="button" class="button is-primary" :disabled="disabled" @click="saveComment">
          <span class="icon is-small">
            <i class="fa fa-paper-plane"></i>
          </span>
        </button>
      </div>
    </article>
  </div>
</template>
<script>
import authUserData from '../../../mixins/authUserData';
import catchJsonErrors from '../../../mixins/catchJsonErrors';

export default {
  name: "reply_child_input",
  data: () => ({
    body: '',
    disabled: true,
    onCancel: false,
  }),
  watch:{
    body(){
      if (this.body.length >= 2) {
        this.disabled = false;
      }
    }
  },
  props: ['comment_id', 'dream_id', 'el_id'],
  methods: {
    saveComment() {
      axios.post('/api/parent-comments', this.get_data()).then((resp)=>{
        if (resp.status == 201) {
          this.cancelEdit();
          this.$store.commit('add_child_comment', resp.data.comment);
          window.eventBus.$emit('add_child_comment', resp.data.comment)
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    get_data(){
      return {
        dream_id: this.dream_id,
        user_id: this.authUser.id,
        parent_id: this.comment_id,
        body: this.body
      }
    },
    cancelEdit(){
      this.body = '';
      this.onCancel = true;
      this.hideInput();
    },
    hideInput: _.debounce(function(){
      let el = document.getElementById(this.el_id);
      el.style.display = 'none';
      this.onCancel = false;
    }, 500),
  },
  mixins: [authUserData, catchJsonErrors]
}
</script>
<style lang="scss" scoped>
.reply-child {
  // margin-left: 65px;
  margin-top: 10px;
  margin-bottom: 10px;
  display: none;
}
</style>
