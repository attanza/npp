<template>
  <div id="dream_photo">
    <div class="card">
      <div class="card-content">
        <div class="media">
          <div class="media-left">
            <!--  if auth -->
            <figure class="image is-48x48" v-if="dream.user.id == authUser.id">
              <img :src="authAvatar" alt="authUser.first_name">
            </figure>
            <!--  if public -->
            <figure class="image is-48x48" v-else>
              <img :src="dream.user.profile.photo_path" alt="dream.user.first_name">
            </figure>
          </div>
          <div class="media-content" v-if="dream.user.id == authUser.id">
            <p class="title is-4">{{authUser.first_name}} {{authUser.last_name}}</p>
            <p class="subtitle is-6">
              {{authDream.created_at | moment("from", "now") }} ~
              <span class="icon"><i class="fa fa-map-marker"></i></span>{{authProfile.location}}
            </p>
          </div>
          <div class="media-content" v-else>
            <p class="title is-4">{{dream.user.first_name}} {{dream.user.last_name}}</p>
            <p class="subtitle is-6">
              {{dream.created_at | moment("from", "now") }} ~
              <span class="icon"><i class="fa fa-map-marker"></i></span>{{dream.user.profile.location}}
            </p>
          </div>
        </div>
      </div>
      <div class="card-image">
        <figure class="image is-1by1" v-if="dream.user.id == authUser.id">
          <img :src="authDreamPhoto" :alt="authDream.dream">
        </figure>
        <figure class="image is-1by1" v-else>
          <img :src="dream.photo" :alt="dream.dream">
        </figure>
      </div>
      <footer class="card-footer" v-if="dream.user.id == authUser.id">
        <a class="card-footer-item" @click="showDreamEdit = true">
          <span class="icon"><i class="fa fa-pencil"></i></span>
        </a>
        <a class="card-footer-item" @click="showUploader">
          <span class="icon"><i class="fa fa-camera"></i></span>
        </a>
      </footer>
    </div>
    <!-- <avatar-upload :imageUrl="image" :uploadURL="uploadURL"></avatar-upload> -->
    <dream-edit-form :showDreamEdit="showDreamEdit" @onCloseDreamEdit="onCloseDreamEdit"></dream-edit-form>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';
// import avatarUpload from '../profile/avatar/AvatarUpload';
import DreamEditForm from './DreamEditForm'

export default {
  name: "dream_photo",
  components: {
    DreamEditForm,
  },
  data: () => ({
    image: '',
    uploadURL: '',
    showDreamEdit: false,
  }),
  props: ['dream'],

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
    window.eventBus.$on('dream_created', this.dreamEdited);
  },

  methods: {
    showUploader(){
      let data = {
        imageUrl : this.image,
        uploadURL : this.uploadURL
      }
      window.eventBus.$emit('showUploader', data);

    },
    afterUpload(image){
      this.$store.commit('dream_photo_mutation', image);
    },
    showForm() {
      window.eventBus.$emit('show-form');
    },
    dreamEdited(){
      if (this.dream.dream != this.authDream.dream) {
        window.location.replace('/dream/'+this.authDream.slug)
      }
    },
    onCloseDreamEdit(){
      this.showDreamEdit = false;
    }
  },
  mixins: [authUserData],
}
</script>
<style lang="scss" scoped>
</style>
