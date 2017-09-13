<template>
  <div :id="'child_reply_'+parent_id" style="display: none">
    <article class="media">
      <figure class="media-left">
        <p class="image is-32x32">
          <img :src="authAvatar">
        </p>
      </figure>
      <div class="media-content">
        <div class="field">
          <p class="control">
            <textarea class="textarea" name="body" v-model="body" placeholder="Tanggapan..." :id="'body_'+parent_id" rows="1"></textarea>
          </p>
        </div>
      </div>
      <div class="media-right">
        <a class="button is-primary is-small" :disabled="disabled" @click="send_comment">
          <span class="icon is-small">
            <i class="fa fa-paper-plane"></i>
          </span>
          <span>Kirim</span>
        </a>
      </div>
    </article>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
export default {
  name: "reply_child",
  data: () => ({
    body: '',
    disabled: true,
  }),
  props: ['dream_id', 'parent_id'],
  watch: {
    body(){
      if (this.body.length > 1) {
        this.disabled = false;
      }
    }
  },
  methods: {
    send_comment() {
      axios.post('/api/parent-comments', this.get_data()).then((resp)=>{
        this.$emit('pushChildComment', resp.data.comment)
        this.body = '';
        this.disabled = true;
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    get_data(){
      return {
        user_id: this.authUser.id,
        dream_id: this.dream_id,
        parent_id: this.parent_id,
        body: this.body
      }
    },
  },
  mixins: [authUserData, catchJsonErrors]
}
</script>
<style lang="scss" scoped>

</style>
