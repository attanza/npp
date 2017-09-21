<template>
  <div id="dream_upload_button">
    <div class="field is-grouped is-grouped-centered m-t-20">
      <p class="control">
        <button class="button is-primary is-medium" @click="showUploader">
          <span class="icon">
            <i class="fa fa-camera"></i>
          </span>
          <span>Unggah gambar mimpimu...</span>
        </button>
      </p>
    </div>
    <!-- <avatar-upload :imageUrl="image" :uploadURL="uploadURL"></avatar-upload> -->
  </div>
</template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors';
import authUserData from '../../mixins/authUserData';
// import avatarUpload from '../profile/avatar/AvatarUpload';
export default {
  name: "dream_upload_button",
  // components: {
  //   avatarUpload
  // },
  data: () => ({
    image: '',
    uploadURL: '',
  }),
  watch: {
    authDream(){
      if (this.authDream) {
        this.uploadURL = baseUrl+'/api/dream/'+this.authDream.id+'/upload';
      }
    },
    authDreamPhoto(){
      if (this.authDreamPhoto != '') {
        this.image = this.authDreamPhoto
      } else {
        this.image = baseUrl+'/images/resource/default_dream.jpg';
      }
    }
  },
  mounted (){
    window.eventBus.$on('after-upload', this.afterUpload);
  },
  methods: {
    showUploader(){
      let data = {
        image: this.image,
        uploadURL: this.uploadURL,
      }
      window.eventBus.$emit('showUploader', data);
    },
    afterUpload(image){
      this.$store.commit('dream_photo_mutation', image);
    }
  },
  mixins: [authUserData, catchJsonErrors]
}
</script>
<style lang="scss" scoped>
</style>
