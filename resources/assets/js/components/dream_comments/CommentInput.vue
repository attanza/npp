<template>
  <div id="comment_input">
    <article class="media">
      <figure class="media-left">
        <p class="image" :class="size">
          <img :src="authAvatar">
        </p>
      </figure>
      <div class="media-content">
        <div class="field">
          <p class="control">
            <textarea class="textarea" placeholder="Tanggapan anda..." v-model="body" rows="1"></textarea>
          </p>
        </div>
        <nav class="level is-mobile">
          <div class="level-left">

          </div>
          <div class="level-right">
            <div class="level-item">
              <a class="button is-primary" :disabled="disabled" @click="sendComment">
                <span class="icon is-small m-r-5">
                  <i class="fa fa-paper-plane"></i>
                </span>
                Kirim
              </a>
            </div>
          </div>
        </nav>
      </div>
    </article>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';

export default {
  name: "comment_input",
  data: () => ({
    body: '',
    disabled: true,
  }),
  props: ['dream_id', 'size'],
  watch: {
    body(){
      if (this.body.length > 3) {
        this.disabled = false;
      } else {
        this.disabled = true;
      }
    }
  },
  methods: {
    sendComment() {
      let newComment = {
        dream_id: this.dream_id,
        user_id: this.authUser.id,
        owner: this.authUser,
        // profile: this.authProfile,
        body: this.body,
        parent_id: 0,
      }
      this.body = '';
      console.log(newComment);
      window.eventBus.$emit('newComment', newComment);
    }
  },
  mixins: [authUserData],

}
</script>
<style lang="scss" scoped>
</style>
