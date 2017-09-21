<template>
  <div id="upload_avatar">
    <div :class="{'modal': true, 'is-active': showUploader }">
      <div class="modal-background" @click="closeModal">
        <div class="field is-grouped is-grouped-right">
          <button class="delete is-large" aria-label="close"></button>
        </div>
      </div>
      <div class="modal-card">
          <p class="image" id="avatarImage">
            <img :src="image" alt="">
          </p>
        <section class="modal-card-body">
          <div class="content">
            <div class="field is-grouped is-grouped-centered">
              <p class="control" v-if="!upload">
                <input name="imageFile" type="file" v-validate="'required|image|size:5000'" data-vv-as="File" :class="{'input': true, 'is-danger': errors.has('imageFile') }" accept="image/*" @change="validateBeforeSubmit">
                <span v-show="errors.has('imageFile')" class="help is-danger">{{ errors.first('imageFile') }}</span>
              </p>
              <p class="control" v-else>
                <button type="button" class="button is-primary" :class="{'is-loading':loading}"
                id="uploadFileCall" v-on:click="uploadFile">
                  <span class="icon m-r-5"><i class="fa fa-upload"></i></span>Upload
                </button>
              </p>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
// mixin
import authUserData from '../../../mixins/authUserData';
import catchJsonErrors from '../../../mixins/catchJsonErrors';
// validator
import id from 'vee-validate/dist/locale/id';
import VeeValidate, { Validator } from 'vee-validate';
Validator.addLocale(id);
Vue.use(VeeValidate, {
  locale: 'id'
});
// cropper
import Cropper from 'cropperjs';

export default {
  name: "upload_avatar",
  data: () => ({
    showUploader: false,
    image: null,
    cropper: null,
    upload: false,
    loading:false,
    uploadURL: '',
  }),
  // props: ['imageUrl', 'uploadURL'],

  mounted(){
    // this.image = this.imageUrl;
    window.eventBus.$on('showUploader', this.setUploader);
    window.eventBus.$on('onBack', this.closeModal);
    this.setUpCropper();
    this.$on('imgUploaded', function (imageData) {
      this.image = imageData
      this.cropper.replace(imageData)
      this.loading = false;
		})
  },

  methods: {
    setUploader: _.debounce(function(data){
      this.image = data.imageUrl;
      this.uploadURL = data.uploadURL;
      this.showUploader = true;
      this.cropper.replace(data.imageUrl)

    }, 200),

    validateBeforeSubmit(e) {
	    this.$validator.validateAll().then((result) => {
        if (result) {
          this.loading = true;
          this.onFileChange(e)
          return;
        }
        this.catchValidationErrors();
	    });
		},
    setUpCropper(){
      // var image = document.getElementsByClassName('avatarImage');
      var image = document.getElementById('avatarImage');
      this.cropper = new Cropper(image, {
        aspectRatio: 1 / 1,
        viewMode: 1,
        dragMode: 'move',
      });
    },
    onFileChange(e) {
			var files = e.target.files || e.dataTransfer.files;
			if (!files.length)
			return;
			this.createImage(files[0]);
			this.upload = true;
		},

		createImage(file) {
			var image = new Image();
			var reader = new FileReader();
			var vm = this;
			reader.onload = (e) => {
				vm.image = e.target.result;
				vm.$emit('imgUploaded', e.target.result)
			};
			reader.readAsDataURL(file);
		},
    uploadFile () {
      axios.post(this.uploadURL, {file: this.cropper.getCroppedCanvas().toDataURL()})
      window.eventBus.$emit('after-upload', this.cropper.getCroppedCanvas().toDataURL())
      this.showUploader = false;
      this.upload = false;
		},
    closeModal(){
      this.showUploader = false;
      this.upload = false;
    }
  },

  mixins: [authUserData, catchJsonErrors]

}
</script>
<style lang="scss" scoped>
.image {
  background-color: #fff;
}
.image img {
  // max-width: 100%;
  // height: auto;
  max-height: 80vh !important;
  height: auto;
  overflow: scroll;
}
</style>
