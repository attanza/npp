<template>
  <div class="columns is-hidden-desktop is-multiline is-gapless">
    <div class="column">
      <div class="tabs is-fullwidth">
        <ul>
          <li>
            <a @click="menuOpen = true; userOpen = false" v-if="!menuOpen"><span class="icon"><i class="fa fa-bars"></i></span></a>
            <a @click="menuOpen = false" v-else><span class="icon"><i class="fa fa-bars"></i></span></a>
          </li>
          <li>
            <a @click="userOpen = true; menuOpen = false;" v-if="!userOpen"><span class="icon"><i class="fa fa-user"></i></span></a>
            <a @click="userOpen = false" v-else><span class="icon"><i class="fa fa-user"></i></span></a>
          </li>
        </ul>
      </div>

      <nav class="panel" v-show="menuOpen">
        <a class="panel-block" :class="{'is-active' : isHome }" @click="getRedirect('/rumah-negeri-para-pemimmpi')">
          <span class="panel-icon">
            <i class="fa fa-home"></i>
          </span>
          Home
        </a>
        <a class="panel-block" :class="{'is-active' : isBmi }" @click="getRedirect('/berjuta-mimpi-indonesia')">
          <span class="panel-icon">
            <i class="fa fa-cloud"></i>
          </span>
          Berjuta Mimpi Indonesia
        </a>
        <a class="panel-block" :class="{'is-active' : isAbout }" @click="getRedirect('/tentang-negeri-para-pemimmpi')">
          <span class="panel-icon">
            <i class="fa fa-question"></i>
          </span>
          Tentang Kami
        </a>
        <a class="panel-block">
          <span class="panel-icon">
            <i class="fa fa-address-book"></i>
          </span>
          Kontak
        </a>
      </nav>

      <nav class="panel" v-show="userOpen">
        <a class="panel-block" @click="getRedirect('/profile/'+authUser.username)">
          <span class="panel-icon">
            <i class="fa fa-user"></i>
          </span>
          Profile
        </a>
        <a class="panel-block" @click="getRedirect('/dream/'+authDream.slug)">
          <span class="panel-icon">
            <i class="fa fa-cloud"></i>
          </span>
          Mimpiku
        </a>
        <a class="panel-block" @click="getRedirect('/logout')">
          <span class="panel-icon">
            <i class="fa fa-sign-out"></i>
          </span>
          Logout
        </a>
      </nav>

    </div>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';
export default {
  name: "mobile_nav",
  data: () => ({
    menuOpen: false,
    userOpen: false,
    isHome: false, isBmi: false, isAbout: false
  }),
  mounted() {
    this.getCurrentUrl();
  },
  methods: {
    getCurrentUrl(){
      var cur_url = window.location.href;
      switch (cur_url) {
        case baseUrl+'/':
          this.isHome = true;
          break;
        case baseUrl+'/rumah-negeri-para-pemimmpi':
          this.isHome = true;
          break;
        case baseUrl+'/berjuta-mimpi-indonesia':
          this.isBmi = true;
          break;
        case baseUrl+'/tentang-negeri-para-pemimmpi':
          this.isAbout = true;
          break;
        default:

      }
    },
    getRedirect(path) {
      window.location.replace(baseUrl+path);
    },
  },
  mixins: [authUserData],
}
</script>
<style lang="scss" scoped>
.columns.is-gapless:not(:last-child) {
    margin-bottom: 0;
}
.tabs {
  margin: 0;
  padding: 0;
  background-color: #000;
  // opacity: 0.0 - 1.0;

  a {
    color: #ffcc2a;
    &:hover {
      color: hsl(171, 100%, 41%);
      border-bottom: 2px solid #ffcc2a;
    }
  }
}
.panel {
  a {
    color: #000;

    &:hover {
      color: #fff;
      background-color: #000;
      border-color: #000;
    }
  }
}
.panel-block.is-active {
  color: #fff;
  background-color: #000;
  border-color: #000;
}
</style>
