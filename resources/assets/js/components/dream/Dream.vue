<template>
  <div id="dream">
    <dream-create-button v-show="showDreamCreate"></dream-create-button>
    <dream-upload-button v-show="showDreamUpload"></dream-upload-button>
  </div>
</template>
<script>
import DreamCreateButton from './DreamCreateButton';
import DreamUploadButton from './DreamUploadButton';
import authUserData from '../../mixins/authUserData';
export default {
  name: "dream",
  components: {
    DreamCreateButton,
    DreamUploadButton
  },
  data: () => ({
    showDreamCreate: false,
    showDreamUpload: false,
  }),
  mounted() {
    window.eventBus.$on('dream_created', this.dream_created);
    window.eventBus.$on('after-upload', this.afterUpload);

  },
  watch: {
    authDream() {
      if (this.authDream.dream == null || this.authDream.dream == '') {
        this.showDreamCreate = true;
      }

      if (this.authDream.medias.length == 0) {
        this.showDreamUpload = true;
      }
    }
  },
  methods: {
    afterUpload(){
      this.showDreamUpload = false;
      this.$toast.open({
        duration: 5000,
        type: 'is-success',
        message: 'Gambar mimpi akan segera di upload',
      });
    },
    dream_created(){
      this.showDreamCreate = false;
      this.showDreamUpload = true;
    }
  },
  mixins: [authUserData],
}
</script>
<style lang="scss" scoped>
</style>
