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
            <tr>
              <th></th>
              <td><a href="javascript:void(0)" @click="showFromChangePass = true">Perbaharui password</a></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <change-password-form :showFromChangePass="showFromChangePass" @onClose="formPassClose"></change-password-form>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';
import moment from 'moment';
import ChangePasswordForm from './ChangePasswordForm'
export default {
  name: "profile_info_contact",
  components: {
    ChangePasswordForm
  },
  data: () => ({
    showFromChangePass: false
  }),
  methods: {
    contact_edit(){
      this.$emit('contact_edit');
    },
    showForm(){
      window.eventBus.$emit('show-form');
    },
    formPassClose(){
      this.showFromChangePass = false;
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
