<template>
  <div class="columns" id="login">
    <div class="column">
      <div class="field">
        <p class="control has-icons-left">
          <input name="email" id="email"  v-model="email" v-validate="'required|email'" :class="{'input': true, 'is-danger': errors.has('email') }" data-vv-as="Alamat Email" type="text" placeholder="Alamat Email">
          <span class="icon is-small is-left">
            <i class="fa fa-envelope"></i>
          </span>
        </p>
        <p class="m-t-10">
          <div class="field">
              <b-checkbox v-model="remember" name="remember"><span style="color: #ffcc2a;">Ingat saya</span> </b-checkbox>
          </div>
        </p>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <p class="control has-icons-left">
          <input class="input" type="password" placeholder="Password" name="password" id="password" v-model="password"   v-validate="'required'":class="{'input': true, 'is-danger': errors.has('password') }" data-vv-as="Password" >
          <span class="icon is-small is-left">
            <i class="fa fa-lock"></i>
          </span>
        </p>
        <p class="m-t-5">
          <a href="javascript:void(0)">Lupa password ?</a>
        </p>
      </div>
    </div>
    <div class="column is-narow">
      <button class="button is-warning is-fullwidth" v-bind:class="button_processing" @click="validateBeforeSubmit()">
        Login
      </button>
    </div>
    <b-modal :active.sync="showModal" has-modal-card>
        <modal-form></modal-form>
    </b-modal>
  </div>
</template>
<script>
import id from 'vee-validate/dist/locale/id';
import VeeValidate, { Validator } from 'vee-validate';
Validator.addLocale(id);
Vue.use(VeeValidate, {
  locale: 'id'
});
import ModalForm from './ActivationModalForm';
export default {
  name: "login",
  components: {
      ModalForm
  },
  data: () => ({
    email: 'admin@admin.com',
    password: 'password',
    remember: '',
    button_processing: '',
    showModal: false,
  }),
  mounted(){
    window.eventBus.$on('confirm_activation', this.confirm_activation);
  },
  methods: {
    validateBeforeSubmit() {
	    this.$validator.validateAll().then((result) => {
        if (result) {
          this.login();
          return;
        }
        let errors = _.toArray(this.errors);
        let vm = this;
        _.forEach(errors, function(value) {
          vm.$toast.open({
            duration: 3000,
            message: value[0].msg,
          });
        });
	    });
		},

    login(){
      this.button_processing = 'is-loading'
      axios.post('/npp-login', this.get_data()).then((resp)=>{
        if (resp.status == 200) {
            window.location.replace('/');
        } else if (resp.status == 201) {
            this.button_processing = '';
            this.showModal = true;
        }
      }).catch(error => {
        if (error.response) {
          let vm = this;
          _.forEach(error.response.data, function(value, key) {
            vm.$toast.open({
              duration: 3000,
              message: _.trim(value),
            });
          });
          this.button_processing = ''
        }
      });
    },

    get_data(){
      return {
        email: this.email,
        password: this.password,
        remember: this.remember,
      }
    },

    confirm_activation(resend_mail){
      this.showModal = false;
      if (resend_mail) {
          this.request_resend_mail();
      }
    },
    request_resend_mail(){
      this.$toast.open({
        duration: 3000,
        message: 'Email akan segera dikirmkan.',
      });
    }
  }
}
</script>
<style lang="scss" scoped>
#login{
  padding: 0px 20px;
}
</style>
