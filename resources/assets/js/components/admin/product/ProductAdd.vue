<template src="./product_add.html"></template>
<script>
import catchJsonErrors from '../../../mixins/catchJsonErrors';
import id from 'vee-validate/dist/locale/id';
import VeeValidate, { Validator } from 'vee-validate';
Validator.addLocale(id);
Vue.use(VeeValidate, {
  locale: 'id'
});
export default {
  name: "product_add",
  data: () => ({
    code: '', name: '', stock: '', description: '', price: '',
  }),
  props: ['showProductAdd'],
  methods: {
    onClose() {
      this.$emit('onClose');
      this.clearForm();
    },
    validateBeforeSubmit() {
	    this.$validator.validateAll().then((result) => {
        if (result) {
          this.saveProduct();
          return;
        }
        this.catchValidationErrors()
	    });
		},
    saveProduct(){
      axios.post('/api/admin/products', this.getData()).then((resp)=>{
        if (resp.status == 201) {
          this.throw_noty('success', 'Produk ditambahkan');
          this.clearForm();
          this.$emit('onSave', resp.data.product)
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    getData(){
      return {
        code: this.code,
        name: this.name,
        price: this.price,
        stock: this.stock,
        description: this.description
      }
    },
    clearForm(){
      this.code = '';
      this.name = '';
      this.stock = '';
      this.price = '';
      this.description = '';

    }
  },
  mixins: [catchJsonErrors]
}
</script>
<style lang="scss" scoped>
</style>
