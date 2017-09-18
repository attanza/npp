<template>
  <div id="avatar">
    <div class="card">
      <div class="card-image">
        <figure class="image">
          <img :src="authAvatar" :alt="authUser.name">
        </figure>
      </div>
      <div class="card-content">
        <div class="content has-text-centered">
          <p class="title is-3">{{authUser.first_name}} {{authUser.last_name}}</p>
          <p class="subtitle is-5">{{authUser.email}}</p>
          <p><small>Bergabung: {{ authUser.created_at | moment("DD MMMM YYYY") }}</small></p>
        </div>
      </div>
      <footer class="card-footer">
        <p class="card-footer-item">
          <span>
            <a href="javascript:void(0)" @click="showUploader">Ganti Foto Profil</a>
          </span>
        </p>
      </footer>
    </div>
    <!-- <avatar-upload :imageUrl="profile.photo_path" :uploadURL="uploadURL"></avatar-upload> -->
  </div>
</template>
<script>
import authUserData from '../../../mixins/authUserData';
import catchJsonErrors from '../../../mixins/catchJsonErrors';
// import AvatarUpload from './AvatarUpload'
export default {
  name: "avatar",
  // components: {
  //   'avatar-upload': AvatarUpload
  // },
  props: ['profile'],
  data: () => ({
    uploadURL: '',
  }),
  mounted(){
    this.uploadURL = '/api/profile/upload/'+this.profile.user_id;
    window.eventBus.$on('after-upload', this.afterUpload)

  },
  methods: {
    showUploader(){
      let data = {
        imageUrl : this.profile.photo_path,
        uploadURL : this.uploadURL
      }
      window.eventBus.$emit('showUploader', data);
      this.popStateListener();

    },
    afterUpload(image){
      this.$store.commit('avatar_mutation', image);
    }
  },
  mixins: [authUserData, catchJsonErrors]

}
</script>
<style lang="scss" scoped>
</style>
