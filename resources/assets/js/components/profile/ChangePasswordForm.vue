<template>
  <div id="change_password_form">
    <div class="modal" :class="{'is-active' : showModal}">
      <div class="modal-background" @click="modalShow = false"></div>
      <div class="modal-card">
        <div class="modal-content">
          <figure >
            <img :src="logo" alt="Image" width="40%">
          </figure>
        </div>
        <section class="modal-card-body">
          <label class="label">Password lama</label>
          <p class="control">
              <input name="old_password" v-model="old_password" v-validate="'required|min:6'" data-vv-as="Password lama" :class="{'input': true, 'is-danger': errors.has('old_password') }" type="password">
              <span v-show="errors.has('old_password')" class="help is-danger">{{ errors.first('old_password') }}</span>
          </p>

          <label class="label">Password baru</label>
          <p class="control">
              <input name="password" id="password" v-model="password" v-validate="'required|min:6'" data-vv-as="Password" :class="{'input': true, 'is-danger': errors.has('password') }" type="password">
              <span v-show="errors.has('password')" class="help is-danger">{{ errors.first('password') }}</span>
          </p>

          <label class="label">Password konfirmasi</label>
          <p class="control">
              <input name="password_confirmation" id="password_confirmation" v-model="password_confirmation" v-validate="'required|min:6|confirmed:password'" data-vv-as="Konfirmasi password" :class="{'input': true, 'is-danger': errors.has('password_confirmation') }" type="password">
              <span v-show="errors.has('password_confirmation')" class="help is-danger">{{ errors.first('password_confirmation') }}</span>
          </p>
        </section>

        <footer class="modal-card-foot">
          <a class="card-footer-item" @click="showModal = false">Batal</a>
          <a class="card-footer-item" @click="validateBeforeSubmit()">Simpan</a>
        </footer>
      </div>
    </div>
  </div>
</template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors';
import authUserData from '../../mixins/authUserData';
import id from 'vee-validate/dist/locale/id';
import VeeValidate, { Validator } from 'vee-validate';
export default {
  name: "change_password_form",
  data: () => ({
    showModal:false,
    logo: '/images/resource/npp_logo.png',
    old_password: '', password: '', password_confirmation: '',

  }),
  mounted(){
    window.eventBus.$on('show-form', this.showForm);

  },
  methods: {
    showForm() {
      this.showModal = true
    },
    validateBeforeSubmit(){
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.resetPassword();
          return;
        }
        this.catchValidationErrors()
	    });
    },
    resetPassword(){
      axios.post('/api/reset-password/'+this.authUser.id, this.getData()).then((resp)=>{
        if (resp.status == 200) {
            this.toast_success(resp.data.msg);
            this.showModal = false;
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    getData(){
      return {
        old_password: this.old_password,
        password: this.password,
        password_confirmation: this.password_confirmation,
      }
    }
  },
  mixins: [catchJsonErrors, authUserData],

}
</script>
<style lang="scss" scoped>
.modal-card-head {
  background-color: #000;
}
.modal-card-title {
  color: #ffcc2a;
}
.modal-card-foot{
  background-color: #000;
}
.card-image {
  background-color: #000;
  height: auto;
}
.content figure {
    text-align: left;
}
</style>
