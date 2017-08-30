<template>
  <div id="notification_listener">
  </div>
</template>
<script>
import commitNotification from '../../mixins/commitNotification';
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
              this.$store.commit('avatar_mutation', e.avatar);
          });
      Echo.private('npp-user.'+ this.username)
          .listen('UploadDreamEvent', (e) => {
              this.$store.commit('dream_photo_mutation', e.dream.photo);
              window.eventBus.$emit('new_dream_submited', e.dream);
          });
      Echo.private('npp-user.'+ this.username)
          .listen('UnreadNotsEvent', (e) => {
            this.storeNots(e.data)
          });
    },

  },
  mixins: [commitNotification]
}
</script>
<style lang="scss">
</style>
