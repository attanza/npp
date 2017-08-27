<template>
  <div class="navbar-item has-dropdown is-hoverable">
    <div class="navbar-link">
      <span class="icon">
        <i class="fa fa-bell"></i>
      </span>
      <span class="tag is-warning is-rounded m-b-20">
        {{authUnreads.length}}
      </span>
    </div>
    <div class="navbar-dropdown is-right">
      <div class="navbar-item " v-for="not in authUnreads">
        <a href="#" class="media">
          <div class="media-left">
            <figure class="image is-64x64">
              <img :src="not.avatar">
            </figure>
          </div>
          <div class="media-content">
              <p style="word-wrap: break-word;" class="is-black">
                <strong>{{not.comment_owner}}</strong>
                <br>
                {{not.msg}}
              </p>
          </div>
        </a>
      </div>
      <div class="navbar-item">
          <a href="#">Lihat semua</a>
      </div>
    </div>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';

export default {
  name: "unread_nots",
  data: () => ({

  }),
  mixins: [authUserData],

}
</script>
<style lang="scss" scoped>
.level-item a {
  color: #000;
  display: block;
}
.level-item a:hover {
  background-color: #ccc;
}
.navbar-dropdown {
  min-width: 200px;
  max-width: 600px;
}
.media-content p {
  color: #000;
}
.navbar-item {
  border-bottom: 1px solid #ccc;
  a {
    color: #00d1b2;
    &:hover {
      color: #000;
    }
  }
}
.navbar-item:first-child {
  border-bottom: none;
}
.navbar-item:last-child {
  border-bottom: none;
}
.navbar-item:hover {
  background-color: #f5f5f5;
}
figure img {
  border-radius: 3px;
  box-shadow: 3px 3px 3px #acacac;
}
</style>
