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
        console.log(errorResponse);
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
    },
    scroll: _.debounce(function(el){
      this.$scrollTo(el);
    },500),
  }
}
// 200: OK. The standard success code and default option.
// 201: Object created. Useful for the store actions.
// 204: No content. When an action was executed successfully, but there is no content to return.
// 206: Partial content. Useful when you have to return a paginated list of resources.
// 400: Bad request. The standard option for requests that fail to pass validation.
// 401: Unauthorized. The user needs to be authenticated.
// 403: Forbidden. The user is authenticated, but does not have the permissions to perform an action.
// 404: Not found. This will be returned automatically by Laravel when the resource is not found.
// 500: Internal server error. Ideally you're not going to be explicitly returning this, but if something unexpected breaks, this is what your user is going to receive.
// 503: Service unavailable. Pretty self explanatory, but also another code that is not going to be returned explicitly by the application.
