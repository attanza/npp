<template src="./contact_form.html"></template>
<script>
import id from 'vee-validate/dist/locale/id';
import VeeValidate, { Validator } from 'vee-validate';
Validator.addLocale(id);
Vue.use(VeeValidate, {
  locale: 'id'
});
import moment from 'moment';
import catchJsonErrors from '../../mixins/catchJsonErrors';
export default {
  name: "profile_info_contact_edit",
  data: () => ({
    first_name: '', last_name: '', email: '', user_id: '',
    username: '', dd: '', mm: '', yyyy: '', gender: '',
    old_username: '',
  }),
  props: ['user'],
  mounted(){
    this.fill_form();
  },
  methods: {
    fill_form(){
      this.first_name = this.user.first_name
      this.last_name = this.user.last_name
      this.email = this.user.email
      this.dob = this.user.dob
      this.yyyy = moment(this.dob).format('YYYY')
      this.mm = moment(this.dob).format('MM')
      this.dd = moment(this.dob).format('DD')
      this.gender = this.user.gender
      this.username = this.user.username
      this.old_username = this.user.username
      this.user_id = this.user.id
    },
    cancel_contact_edit(){
      this.fill_form();
      this.$emit('contact_edit');
    },
    validateBeforeSubmit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.update();
          return;
        }
        this.catchValidationErrors();
      });
    },
    update(){
      axios.put('/api/profile/'+this.user_id, this.get_data()).then((resp)=>{
        if (resp.status == 200) {
          if (this.old_username != resp.data.user.username) {
              window.location.replace('/profile/'+resp.data.user.username);
          }
          this.$store.commit('user_mutation', resp.data.user);
          this.$emit('contact_edit');
          this.toast_success('Data diperbaharui')
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    get_data(){
      return {
        first_name: this.first_name,
        last_name: this.last_name,
        username: this.username,
        email: this.email,
        dob: this.yyyy+'-'+this.mm+'-'+this.dd,
        gender: this.gender
      }
    },
  },
  computed: {
  	years () {
  		let year = new Date().getFullYear()
  		let years = [];
  		let y;
  		for(y = (year - 15); y > (year - 80 ); y--){
  			years.push(y);
  		}
  		return years;
  	},
    date_births(){
      let date_births = [];
      let d;
      for (d = 1; d < 32; d++) {
        if (d < 10) {
          date_births.push('0'+d);
        } else {
          date_births.push(d);
        }
      }
      return date_births;
    },
    month_births(){
      let month_births = [];
      let m;
      for (m = 1; m < 13; m++) {
        if (m < 10) {
          month_births.push('0'+m);
        } else {
          month_births.push(m);
        }
      }
      return month_births;
    }
  },
  mixins: [catchJsonErrors]
}
</script>
<style src="./contact_form.css"></style>
