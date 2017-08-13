export default {
  methods: {
    catchError(errorResponse){
      let vm = this;
      if (errorResponse.status == 422 || errorResponse.status == 401 || errorResponse.status == 403) {
        _.forEach(errorResponse.data, function(value, key) {
          vm.$toast.open({
            duration: 5000,
            message: _.trim(value),
            type: 'is-danger'
          });
        });
      } else {
        vm.$toast.open({
          duration: 5000,
          message: 'So sorry for this Internal Server Error, please contact our administrator',
          type: 'is-info'
        });
      }
    },
    catchValidationErrors(){
      let errors = _.toArray(this.errors);
      let vm = this;
      _.forEach(errors, function(value) {
        vm.$toast.open({
          duration: 3000,
          message: value[0].msg,
          type: 'is-danger',
        });
      });
    },
    toast_success(msg){
      this.$toast.open({
        duration: 5000,
        type: 'is-success',
        message: msg,
      });
    }

  }
}
