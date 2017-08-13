<template>
  <div id="user_init">

  </div>
</template>
<script>
export default {
  name: "user_init",
  data: () => ({

  }),
  mounted(){
    this.get_user()
  },
  methods: {
    get_user(){
      axios.get('/api/user-data').then((resp) => {
        if (resp.status == 200) {
          this.$store.commit('user_mutation', resp.data.user);
          this.$store.commit('profile_mutation', resp.data.user.profile);
          this.$store.commit('avatar_mutation', resp.data.user.profile.photo_path);
          this.$store.commit('dream_mutation', resp.data.user.dream);
          this.$store.commit('dream_photo_mutation', resp.data.user.dream.photo);
        }
      });
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
