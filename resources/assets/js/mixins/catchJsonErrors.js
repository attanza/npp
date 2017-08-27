export default {
  methods: {
    catchError(errorResponse){
      let vm = this;
      if (errorResponse.status == 422 || errorResponse.status == 401 || errorResponse.status == 403) {
        _.forEach(errorResponse.data, function(value, key) {
          vm.throw_noty('error', _.trim(value));
        });
      } else {
        vm.throw_noty('error', 'So sorry for this Internal Server Error, please contact our administrator');

      }
    },
    catchValidationErrors(){
      let errors = _.toArray(this.errors);
      let vm = this;
      _.forEach(errors, function(value) {
        vm.throw_noty('error', value[0].msg);
      });
    },
    toast_success(msg){
      this.$toast.open({
        duration: 5000,
        type: 'is-success',
        message: msg,
      });
    },
    throw_noty(type, msg){
      new Noty({
        type: type,
        text: msg,
        layout: 'topCenter',
        theme: 'metroui',
        timeout: 5000,
        progressBar: true,
      }).show();
    }

  }
}
