<template src="./main_nav.html"></template>
<script>
import authUserData from '../../mixins/authUserData';
export default {
  name: "main_nav",
  data: () => ({
    menuActive: false,
    npp_logo: '/images/resource/npp_logo.png',
    siteLink: {
      home: baseUrl+'/home',
      bmi: baseUrl+'/berjuta-mimpi-indonesia',
      about: baseUrl+'/tentang-negeri-para-pemimpi',
      contact: baseUrl+'/kontak-negeri-para-pemimpi',
      login: baseUrl+'/login',
      profile: baseUrl+'/profile/',
      showDream: baseUrl+'/dream/',
      logout: baseUrl+'/logout',


    },
    location: '',
  }),
  created(){
    this.siteLink.home = baseUrl;
    this.location = window.location.pathname;
  },
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
.navbar-burger:hover {
  background-color: #ffcc2a;
}

.navbar-burger.is-active span {
  background-color: #ffcc2a;
}
.navbar-burger span {
  background-color: #ffcc2a;
}

</style>
