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
        <a @click="setRead(not.id, not.url)">
          <div class="columns is-mobile">
            <div class="column is-narrow">
              <figure class="image is-64x64">
                <img :src="not.avatar">
              </figure>
            </div>
            <div class="column">
              <p style="word-wrap: break-word; color: #000;">
                {{not.msg}}
              </p>
            </div>
          </div>
        </a>
      </div>
      <div class="navbar-item">
        <center>
          <a @click="toNotificationsPage">Lihat semua</a>
        </center>
      </div>
    </div>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';
import catchJsonErrors from '../../mixins/catchJsonErrors';

export default {
  name: "unread_nots",
  data: () => ({

  }),
  methods: {
    setRead(id, url) {
      axios.get('/api/notification/'+id).then((resp) =>{
        if (resp.status == 200) {
          window.location.replace(url);
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    toNotificationsPage(){
      window.location.replace('/notifikasi');
    }
  },
  mixins: [authUserData, catchJsonErrors],
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
// .navbar-item:first-child {
//   border-bottom: none;
// }
// .navbar-item:last-child {
//   border-bottom: none;
// }
// .navbar-item:hover {
//   background-color: #f5f5f5;
// }
// .media-left figure img {
//   border-radius: 0px;
//   box-shadow: 3px 3px 3px #acacac;
// }
.image img {
  // border-radius: 50%;
  box-shadow: 3px 3px 3px #acacac;
}
</style>
