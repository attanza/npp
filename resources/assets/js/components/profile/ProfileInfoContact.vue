<template>
  <div id="profile_info_contact">
    <div class="card">
      <header class="card-header">
        <div class="card-header-title">
          <p class="is-size-4-desktop">Info Kontak</p>
        </div>
        <a class="card-header-icon" @click="contact_edit">
          <span class="icon">
            <i class="fa fa-pencil"></i>
          </span>
        </a>
      </header>
      <div class="card-content">
        <div class="content">
          <table class="table is-striped">
            <tr>
              <th>Nama Depan</th>
              <td>{{authUser.first_name}} {{authUser.last_name}}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{authUser.email}}</td>
            </tr>
            <tr>
              <th>Username</th>
              <td>{{authUser.username}}</td>
            </tr>
            <tr>
              <th>Tanggal lahir</th>
              <td>{{ authUser.dob | moment("DD MMM YYYY") }}</td>
            </tr>
            <tr>
              <th>Gender</th>
              <td>{{authUser.gender}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';
import moment from 'moment'
export default {
  name: "profile_info_contact",
  data: () => ({

  }),
  methods: {
    contact_edit(){
      this.$emit('contact_edit');
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
