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
      <div v-for="not in authUnreads">
        <a @click="setRead(not.id, not.url)" class="navbar-item">
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
      <hr class="navbar-divider">
      <a @click="toNotificationsPage" class="navbar-item">
        <span class="has-text-centered">Lihat semua</span>
      </a>
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
      axios.put('/api/notification/'+id).then((resp) =>{
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
.navbar-dropdown a.navbar-item {
    color: #0a0a0a;
    text-align: center;
}
figure img {
  border-radius: 50%;
}
</style>
