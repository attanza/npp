<template>
  <div id="comment_input">
    <article class="media">
      <figure class="media-left">
        <p class="image" :class="avatarSize">
          <img :src="authAvatar">
        </p>
      </figure>
      <div class="media-content">
        <div class="field">
          <p class="control">
            <textarea class="textarea" placeholder="Komen..." rows="1" v-model="body"></textarea>
          </p>
        </div>
        <div class="field is-grouped is-grouped-right">
          <button class="button is-primary is-small" :disabled="disabled" @click="send">
            <span class="icon is-small">
              <i class="fa fa-paper-plane"></i>
            </span>
          </button>
        </div>
      </div>
    </article>
  </div>
</template>
<script>
import authUserData from '../../../mixins/authUserData';

export default {
  name: "comment_input",
  data: () => ({
    body: '',
    disabled: true,
    avatarSize: 'is-48x48',
  }),
  props: ['inputSize'],
  watch: {
    body(){
      if (this.body.length >= 2) {
        this.disabled = false;
      } else {
        this.disabled = true;
      }
    }
  },
  created(){
    if (this.inputSize == 'small') {
      this.avatarSize = 'is-32x32';
    }
  },
  methods: {
    send() {
      this.$emit('newText', this.body);
      this.body = '';
    }
  },
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
.button {
  width: 100px;
}
</style>
