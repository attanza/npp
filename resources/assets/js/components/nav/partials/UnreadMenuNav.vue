<template>
  <div id="main_menu_nav">
    <div class="modal" :class="{'is-active':showUnreadMenu}">
      <div class="modal-background" @click="onClose"></div>
      <div class="modal-content">

        <nav class="panel">
          <p class="panel-heading">
            <span class="icon">
              <i class="fa fa-bell"></i>
            </span>
            <button class="delete pull-right" @click="onClose"></button>
          </p>
          <div v-for="not in authUnreads">
            <a :href="not.url" class="navbar-item">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-32x32">
                    <img :src="not.avatar" alt="">
                  </figure>
                </div>
                <div class="media-content">
                  <span>{{not.msg}}</span>
                </div>
              </div>
            </a>
          </div>
          <a @click="toNotificationsPage" class="navbar-item">
            <span class="has-text-centered">Lihat semua</span>
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

  }),
  props: ['showUnreadMenu'],

  methods: {
    onClose() {
      this.$emit('onClose');
    },
    toNotificationsPage(){
      window.location.replace('/notifikasi');
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
