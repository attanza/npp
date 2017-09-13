<template>
  <div id="mobile_nav">
    <div class="tabs is-fullwidth is-centered is-hidden-desktop">
      <ul>
        <li>
          <a @click="showMainMenu = true">
            <span class="icon">
              <i class="fa fa-bars"></i>
            </span>
          </a>
        </li>

        <li v-if="isAuth">
          <a>
            <span class="icon" @click="showUnreadMenu = true">
              <i class="fa fa-bell"></i>
            </span>
            <span class="tag is-warning is-rounded">
              {{authUnreads.length}}
            </span>
          </a>
        </li>

        <li v-if="isAuth">
          <a @click="showProfileMenu = true">
            <span class="icon">
              <i class="fa fa-user"></i>
            </span>
          </a>
        </li>
      </ul>
    </div>
    <main-menu-nav :showMainMenu="showMainMenu" @onClose="onClose"></main-menu-nav>
    <profile-menu-nav :showProfileMenu="showProfileMenu" @onClose="onClose"></profile-menu-nav>
    <unread-menu-nav :showUnreadMenu="showUnreadMenu" @onClose="onClose"></unread-menu-nav>

  </div>
</template>
<script>
import MainMenuNav from './partials/MainMenuNav';
import ProfileMenuNav from './partials/ProfileMenuNav';
import UnreadMenuNav from './partials/UnreadMenuNav';
import authUserData from '../../mixins/authUserData';

export default {
  name: "mobile_nav",
  components: {
    MainMenuNav, ProfileMenuNav, UnreadMenuNav
  },
  data: () => ({
    showMainMenu: false,
    showProfileMenu: false,
    showUnreadMenu: false,
  }),
  methods: {
    onClose() {
      this.showMainMenu = false;
      this.showProfileMenu = false;
      this.showUnreadMenu = false;
    }
  },
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
</style>
