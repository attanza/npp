<template>
  <div id="user_init">

  </div>
</template>
<script>
export default {
  name: "user_init",
  props: ['user'],
  data: () => ({

  }),
  mounted(){
    this.get_user()
  },
  methods: {
    get_user(){
      this.$store.commit('user_mutation', this.user);
      this.$store.commit('profile_mutation', this.user.profile);
      this.$store.commit('avatar_mutation', this.user.profile.photo_path);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
