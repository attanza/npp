<template src="./order_form.html"></template>
<script>
import id from 'vee-validate/dist/locale/id';
import VeeValidate, { Validator } from 'vee-validate';
Validator.addLocale(id);
Vue.use(VeeValidate, {
  locale: 'id'
});
import catchJsonErrors from '../../mixins/catchJsonErrors';
import authUserData from '../../mixins/authUserData';
export default {
  name: "order_form",
  data: () => ({
    name: '', phone: '', qty: '', address: '', long: '', lat: '', location: '', email: '',
    is_check: false,
  }),
  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.submit();
          return;
        }
        this.catchValidationErrors();
      });
    },
    submit(){
      axios.post('/order', this.get_data()).then((resp)=>{
        // console.log(resp);
        if (resp.status == 200) {
          this.clear_data();
          this.throw_noty('success',resp.data.msg)
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    get_data(){
      return {
        name: this.name,
        email: this.email,
        phone: this.phone,
        qty: this.qty,
        address: this.address,
        lat: this.lat,
        lng: this.lng,
        location: this.location,
        product_id: 1,
      }
    },
    handelCheckbox(){
      if (!this.isAuth) {
        this.throw_noty('info', 'Anda belum login');
        this.is_check = false;
      } else {
        this.fill_data();
      }
    },
    fill_data(){
      this.name = this.authUser.first_name+' '+this.authUser.last_name;
      this.email = this.authUser.email;
      this.phone = this.authProfile.phone;
      this.address = this.authProfile.address;
      this.lat = this.authProfile.lat;
      this.lng = this.authProfile.phone;
      this.location = this.authProfile.location
      this.is_check = false;
    },
    clear_data(){
      this.name = '';
      this.email = '';
      this.phone = '';
      this.address = '';
      this.qty = '';
    },
  },


  mixins: [catchJsonErrors, authUserData]

}
</script>
<style lang="scss" scoped>
.box{
  background-color: #ffcc2a;
}
</style>
