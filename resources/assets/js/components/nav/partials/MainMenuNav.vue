<template>
  <div id="main_menu_nav">
    <div class="modal" :class="{'is-active':showMainMenu}">
      <div class="modal-background" @click="onClose"></div>
      <div class="modal-content">

        <nav class="panel">
          <p class="panel-heading">
            <span class="icon">
              <i class="fa fa-bars"></i>
            </span>
            <button class="delete pull-right" @click="onClose"></button>
          </p>
          <a class="panel-block" :href="siteLink.home" :class="{'is-active' : location == '/'}">
            <span class="panel-icon">
              <i class="fa fa-home"></i>
            </span>
            Home
          </a>
          <a class="panel-block" :href="siteLink.bmi" :class="{'is-active' : location == '/berjuta-mimpi-indonesia'}">
            <span class="panel-icon">
              <i class="fa fa-cloud"></i>
            </span>
            Berjuta Mimpi Indonesia
          </a>
          <a class="panel-block" :href="siteLink.about" :class="{'is-active' : location == '/tentang-negeri-para-pemimpi'}">
            <span class="panel-icon">
              <i class="fa fa-question"></i>
            </span>
            Tentang Kami
          </a>
          <a class="panel-block" :href="siteLink.contact" :class="{'is-active' : location == '/kontak-negeri-para-pemimpi'}">
            <span class="panel-icon">
              <i class="fa fa-address-book"></i>
            </span>
            Kontak
          </a>
        </nav>
      </div>
      <button class="modal-close is-large" aria-label="close" @click="onClose"></button>
    </div>
  </div>
</template>
<script>
export default {
  name: "main_menu_nav",
  data: () => ({
    siteLink: {
      home: baseUrl+'/home',
      bmi: baseUrl+'/berjuta-mimpi-indonesia',
      about: baseUrl+'/tentang-negeri-para-pemimpi',
      contact: baseUrl+'/kontak-negeri-para-pemimpi',
    },
    location: '',
  }),
  props: ['showMainMenu'],
  created(){
    this.siteLink.home = baseUrl;
    this.location = window.location.pathname;
  },
  methods: {
    onClose() {
      this.$emit('onClose');
    }
  }
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
