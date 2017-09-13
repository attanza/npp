<template src="./register.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors';
import id from 'vee-validate/dist/locale/id';
import VeeValidate, {
  Validator
} from 'vee-validate';
import Terms from './Terms';
Validator.addLocale(id);
Vue.use(VeeValidate, {
  locale: 'id'
});
export default {
  name: "register",
  components: {
    Terms
  },
  data: () => ({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    gender: 'Male',
    dd: '',
    mm: '',
    yyyy: '',
    terms: false,
    button_processing: '',
    termsShow: false,
  }),

  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.register();
          return;
        }
        this.catchValidationErrors()
      });
    },
    register() {
      this.button_processing = 'is-loading';
      axios.post('/npp-register', this.get_data()).then((resp) => {
        if (resp.status == 200) {
          this.throw_noty('success', resp.data.msg)
          this.clear_form();
          this.button_processing = '';
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
          this.button_processing = ''
        }
      });
    },
    get_data() {
      return {
        first_name: this.first_name,
        last_name: this.last_name,
        password: this.password,
        email: this.email,
        dob: this.yyyy + '-' + this.mm + '-' + this.dd,
        gender: this.gender
      }
    },
    clear_form() {
      this.first_name = '',
        this.last_name = '',
        this.password = '',
        this.email = '',
        this.gender = 'Male'
      this.dd = '',
        this.yyyy = '',
        this.mm = '',
        this.terms = false
    },
  },

  computed: {
    years() {
      let year = new Date().getFullYear()
      let years = [];
      let y;
      for (y = (year - 15); y > (year - 80); y--) {
        years.push(y);
      }
      return years;
    },
    date_births() {
      let date_births = [];
      let d;
      for (d = 1; d < 32; d++) {
        if (d < 10) {
          date_births.push('0' + d);
        } else {
          date_births.push(d);
        }
      }
      return date_births;
    },
    month_births() {
      let month_births = [];
      let m;
      for (m = 1; m < 13; m++) {
        if (m < 10) {
          month_births.push('0' + m);
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
<style lang="scss" scoped>
.radio label {
    display: inline-block;
    cursor: pointer;
    position: relative;
    padding-left: 25px;
    margin-right: 15px;
    font-size: 13px;
}

input[type=radio] {
    display: none;
}
.radio label:before {
    content: "";
    display: inline-block;

    width: 16px;
    height: 16px;

    margin-right: 10px;
    position: absolute;
    left: 0;
    bottom: 1px;
    background-color: #fff;
    box-shadow: inset 0 2px 3px 0 rgba(0, 0, 0, .3), 0 1px 0 0 rgba(255, 255, 255, .8);

    border-radius: 8px;
}
input[type=radio]:checked + label:before {
    content: "\2022";
    color: #f3f3f3;
    font-size: 30px;
    text-align: center;
    line-height: 18px;
    color: #00d1b2;
}

a {
    color: #00d1b2;
}
a:hover {
    color: #000;
}
</style>
