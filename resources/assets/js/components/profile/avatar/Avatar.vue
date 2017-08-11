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
    <avatar-upload :profile="profile"></avatar-upload>
  </div>
</template>
<script>
import authUserData from '../../../mixins/authUserData';
import AvatarUpload from './AvatarUpload'
export default {
  name: "avatar",
  components: {
    'avatar-upload': AvatarUpload
  },
  props: ['profile'],
  data: () => ({

  }),
  mounted(){
  },
  methods: {
    showUploader(){
      window.eventBus.$emit('showUploader');
    }
  },
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
</style>
