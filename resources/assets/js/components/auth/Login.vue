<template src="./login_form.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors';
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
    email: '',
    password: '',
    remember: false,
    button_processing: '',
    showModal: false,
    pasReveal: false,
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
        this.catchValidationErrors()
	    });
		},

    login(){
      this.button_processing = 'is-loading'
      axios.post('/npp-login', this.get_data()).then((resp)=>{
        // console.log(resp);
        if (resp.status == 200) {
            window.location.replace('/berjuta-mimpi-indonesia');
        } else if (resp.status == 201) {
            this.button_processing = '';
            this.showModal = true;
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
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
      axios.post('/npp-activation/resend', this.get_data()).then((resp)=>{
        if (resp.status == 200) {
            this.throw_noty('success', resp.data.msg)
            this.clear_form();
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
          this.button_processing = ''
        }
      });
    },
    clear_form(){
      this.email = '',
      this.password = '',
      this.remember = false
    },
    forgotPassword(){
      window.location.replace('/password/reset');
    }
  },
  mixins: [catchJsonErrors]
}
</script>
<style lang="scss" scoped>
#login{
  padding: 0px 20px;
}
a {
  color: #00d1b2;
}
a:hover {
  color: #ffcc2a;
}
.checkbox{
  color: #00d1b2;
}
</style>
