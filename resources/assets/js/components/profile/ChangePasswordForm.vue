<template>
  <div id="change_password_form">
    <div class="modal" :class="{'is-active' : showFromChangePass}">
      <div class="modal-background" @click="onClose"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Perbaharui Password</p>
          <button class="delete" aria-label="close" @click="onClose"></button>
        </header>
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
          <a class="card-footer-item" @click="onClose">Batal</a>
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
  props: ['showFromChangePass'],
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
            this.throw_noty('success', resp.data.msg);
            this.onClose();
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
    },
    clear_form(){
      this.old_password = '';
      this.password = '';
      this.password_confirmation = '';
    },
    onClose(){
      this.clear_form();
      this.$emit('onClose');
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
@media only screen and (max-width: 1022px){
  .modal-card {
    padding-top: 80px;
  }
}

</style>
