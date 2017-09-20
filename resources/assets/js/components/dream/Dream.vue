<template>
  <div id="dream">
    <dream-create-button v-show="showDreamCreate"></dream-create-button>
    <dream-upload-button v-show="showDreamUpload"></dream-upload-button>
    <dream-show v-show="dreamShow"></dream-show>
  </div>
</template>
<script>
import DreamCreateButton from './DreamCreateButton';
import DreamUploadButton from './DreamUploadButton';
import DreamShow from './DreamShow';

import authUserData from '../../mixins/authUserData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
export default {
  name: "dream",
  components: {
    DreamCreateButton,
    DreamUploadButton,
    DreamShow
  },
  data: () => ({
    showDreamCreate: false,
    showDreamUpload: false,
    dreamShow: false,
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

      if (!this.showDreamCreate && this.authDream.medias.length == 0) {
        this.showDreamUpload = true;
      }

      if (!this.showDreamCreate && !this.showDreamUpload) {
        this.dreamShow = true;
      }
    }
  },
  methods: {
    afterUpload(){
      this.showDreamUpload = false;
      this.throw_noty('success', 'Gambar mimpi akan segera di upload');
    },
    dream_created(){
      this.showDreamCreate = false;
      this.showDreamUpload = true;
    }
  },
  mixins: [authUserData, catchJsonErrors],
}
</script>
<style lang="scss" scoped>
</style>
