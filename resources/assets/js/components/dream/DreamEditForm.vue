<template>
  <div id="dream_create">
    <div class="modal" :class="{'is-active' : showDreamEdit}">
      <div class="modal-background" @click="handleClose"></div>
      <div class="modal-card">
        <div class="modal-content">
          <figure >
            <img :src="logo" alt="Image" width="40%">
          </figure>
        </div>
        <section class="modal-card-body">
          <div class="field">
            <label class="label">Apa mimpimu ?</label>
            <div class="control">
              <input name="dream" v-model="dream" type="text" placeholder="Sebutkan mimpimu disini"  v-validate="'required|max:200'" data-vv-as="Mimpimu" :class="{'input': true, 'is-danger': errors.has('dream') }">
              <span v-show="errors.has('dream')" class="help is-danger">{{ errors.first('dream') }}</span>
            </div>
          </div>
          <div class="field">
            <label class="label">Tag / Kata kunci mimpimu</label>
            <div class="control">
              <input name="keyword" v-model="keyword" type="text" placeholder="Tag atau kata kunci mimpimu"  v-validate="'max:200'" data-vv-as="Mimpimu" :class="{'input': true, 'is-danger': errors.has('keyword') }">
              <span v-show="errors.has('keyword')" class="help is-danger">{{ errors.first('keyword') }}</span>
            </div>
          </div>
          <div class="field">
            <label class="label">Tentang mimpimu</label>
            <div class="control">
              <textarea class="textarea" placeholder="Ceritakan tentang mimpimu disini"
                name="description" v-model="description" v-html="description"
              ></textarea>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <a class="card-footer-item" @click="handleClose">Batal</a>
          <a class="card-footer-item" @click="validateBeforeSubmit()">Simpan</a>
        </footer>
      </div>
    </div>
  </div>
</template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors';
import authUserData from '../../mixins/authUserData';
import id from 'vee-validate/dist/locale/id';
import VeeValidate, { Validator } from 'vee-validate';
Validator.addLocale(id);
Vue.use(VeeValidate, {
  locale: 'id'
});
export default {
  name: "dream_create",
  data: () => ({
    dream: '', keyword: '', description: '', slug: '',
    logo: '/images/resource/npp_logo.png',
  }),
  props: ['showDreamEdit'],

  watch: {
    authDream(){
      if (this.authDream) {
        this.fill_form();
      }
    }
  },
  methods: {
    fill_form(){
      this.dream = this.authDream.dream;
      this.keyword = this.authDream.keyword;
      if (this.authDream.description != '' || this.authDream.description != null) {
        this.description = this.strippedContent(this.authDream.description);
      }
      this.slug = this.authDream.slug;
    },
    validateBeforeSubmit(){
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.postDream();
          return;
        }
        this.catchValidationErrors()
	    });
    },
    postDream(){
      axios.post('/api/dream/'+this.authUser.id, this.get_data()).then((resp) => {
        if (resp.status == 200) {
          console.log(resp);
          this.$store.commit('dream_mutation', resp.data.dream);
          if (this.slug != resp.data.dream.slug) {
            window.location.replace('/dream/'+resp.data.dream.slug);
          }          
          this.throw_noty('success','Mimpimu telah diperbaharui');
          this.handleClose();
        }
      });
    },
    get_data(){
      return {
        dream: this.dream,
        keyword: this.keyword,
        description: this.description,
      }
    },
    strippedContent(text) {
      let regex = /(<([^>]+)>)/ig;
      return text.replace(regex, "");
    },
    handleClose(){
      this.$emit('onCloseDreamEdit');
    }
  },
  mixins: [catchJsonErrors, authUserData],

}
</script>
<style lang="scss" scoped>
.modal-card-head {
  background-color: #000;
}
.modal-card-title {
  color: #ffcc2a;
}
.modal-card-foot{
  background-color: #000;
}
.card-image {
  background-color: #000;
  height: auto;
}
</style>
