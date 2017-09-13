<template>
  <div id="main_menu_nav">
    <div class="modal" :class="{'is-active':showProfileMenu}">
      <div class="modal-background" @click="onClose"></div>
      <div class="modal-content">

        <nav class="panel">
          <p class="panel-heading">
            <span class="icon">
              <i class="fa fa-user"></i>
            </span>
            <button class="delete pull-right" @click="onClose"></button>
          </p>
          <a class="panel-block" :href="siteLink.profile+authUser.username" :class="{'is-active' : location == '/profile/'+authUser.username}">
            <span class="panel-icon">
              <i class="fa fa-user"></i>
            </span>
            Profile
          </a>
          <a class="panel-block" :href="siteLink.showDream+authDream.slug" :class="{'is-active' : location == '/dream/'+authDream.slug}">
            <span class="panel-icon">
              <i class="fa fa-cloud"></i>
            </span>
            Mimpiku
          </a>
          <a class="panel-block" :href="siteLink.logout">
            <span class="panel-icon">
              <i class="fa fa-sign-out"></i>
            </span>
            Logout
          </a>
        </nav>
      </div>
      <button class="modal-close is-large" aria-label="close" @click="onClose"></button>
    </div>
  </div>
</template>
<script>
import authUserData from '../../../mixins/authUserData';
export default {
  name: "main_menu_nav",
  data: () => ({
    siteLink: {
      profile: baseUrl+'/profile/',
      showDream: baseUrl+'/dream/',
      logout: baseUrl+'/logout',
    },
    location: '',
  }),
  props: ['showProfileMenu'],
  created(){
    this.siteLink.home = baseUrl;
    this.location = window.location.pathname;
  },
  methods: {
    onClose() {
      this.$emit('onClose');
    }
  },
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
.panel-heading {
  background-color: #000;
  color: #ffcc2a;
}
.panel-block {
  color: #fff;
  &.is-active {
    color: #ffcc2a;
    .panel-icon {
      color: #ffcc2a;
    }
  }
}
.panel-block:hover {
  color: #ffcc2a;
  background-color: transparent;
  .panel-icon {
    color: #ffcc2a;
  }
}

</style>
