<template>
  <div id="profile_info_detail">
    <div class="card">
      <header class="card-header">
        <div class="card-header-title">
          <p class="is-size-4-desktop">Info Detail</p>
        </div>
        <a class="card-header-icon">
          <span class="icon">
            <i class="fa fa-pencil" @click="detail_edit"></i>
          </span>
        </a>
      </header>
      <div class="card-content">
        <div class="content">
          <table class="table is-striped">
            <tr>
              <th>Tentang Anda</th>
              <td>{{authProfile.about}}</td>
            </tr>
            <tr>
              <th>Kota/Kabupaten</th>
              <td>{{authProfile.location}}</td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td>{{authProfile.address}}</td>
            </tr>
            <tr>
              <th>Telepon</th>
              <td>{{authProfile.phone}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';
export default {
  name: "profile_info_detail",
  data: () => ({

  }),
  methods: {
    detail_edit(){
      this.$emit('detail_edit');
    }
  },
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
.card-header-title, .card-header-icon {
  background-color: #000;
  color: #ffcc2a;
}
</style>
