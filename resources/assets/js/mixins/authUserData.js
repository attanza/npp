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
    authDream(){
      return this.$store.state.dream;
    },
    authDreamPhoto(){
      return this.$store.state.dream_photo;
    },
    isAuth(){
      return this.$store.state.is_auth;
    },
    authUnreads(){
      return this.$store.state.unread_nots;
    },
    authBoostCount(){
      return this.$store.state.boost_count;
    },
    authBooster(){
      return this.$store.state.booster;
    },
    authIsBooster(){
      return this.$store.state.is_booster;
    }
  }
}
