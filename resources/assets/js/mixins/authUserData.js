export default {
  computed: {
    authUser(){
      return this.$store.state.user;
    },
    authProfile(){
      return this.$store.state.profile;
    },
    authAvatar(){
      return this.$store.state.avatar;
    },
  }
}
