<template>
  <div id="notification_listener">
  </div>
</template>
<script>
export default {
  name: "notification_listener",
  data: function data() {
    return {
      user: {}
    }
  },

  props: ['username'],

  mounted(){
    this.listen()
  },

  methods: {
    listen(){
      Echo.private('npp-user.'+ this.username)
          .listen('AvatarUploaded', (e) => {
              console.log(e);
              this.$store.commit('avatar_mutation', e.avatar);
          });

      // Echo.private('npp-user.'+ this.username)
      //     .listen('UploadDreamListener', (e) => {
      //         this.$store.commit('dream_mutation', e.dream)
      //         this.$store.commit('dream_image_mutation', e.dream.gallery.photo_path)
      //
      //         // throw_noty('success', 'Foto mimpi anda sudah diperbaharui')
      //     });
    }
  }
}
</script>
<style lang="scss">
</style>
