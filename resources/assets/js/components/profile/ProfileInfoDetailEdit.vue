<template>
  <div id="profile_info_detail_edit">
    <div class="card">
      <header class="card-header">
        <div class="card-header-title">
          <p class="is-size-4-desktop">Edit Detail</p>
        </div>
        <a class="card-header-icon" @click="cancel_edit">
          <span class="icon">
            <i class="fa fa-times-circle fa-3x"></i>
          </span>
        </a>

      </header>
      <div class="card-content">
        <div class="field">
          <label class="label">Tentang anda</label>
          <p class="control">
            <textarea name="about" v-model="about" class="textarea"></textarea>
          </p>
        </div>

        <div class="field">
          <label class="label">Alamat</label>
          <p class="control">
            <textarea name="address" v-model="address" class="textarea"></textarea>
          </p>
        </div>
        <div class="field">
          <label class="label">Lokasi</label>
          <p class="control g-map">
            <gmap-autocomplete @place_changed="setPlace"></gmap-autocomplete>
          </p>
        </div>

        <div class="field">
          <label class="label">Telepon</label>
          <p class="control">
            <input type="text" name="phone" v-model="phone" class="input">
          </p>
        </div>

      </div><!-- card-content -->
      <footer class="card-footer">
        <a class="card-footer-item" @click="cancel_edit">Batal</a>
        <a class="card-footer-item" @click="submit">Simpan</a>
      </footer>
    </div>
  </div>
</template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors';
import * as VueGoogleMaps from 'vue2-google-maps';
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyCYUffiM_hEO-sLHdpeKx3UHvTp6tm9i8s',
    libraries: 'places'
  }
});
export default {
  name: "profile_info_detail_edit",
  data: () => ({
    about: '', lat: '', lng: '', address: '', phone: '', user_id: '',
    address: '', location: '',
  }),
  props: ['profile'],
  mounted(){
    this.fill_form();
  },
  methods: {
    cancel_edit() {
      this.fill_form();
      this.$emit('detail_edit')
    },
    fill_form(){
      this.about = this.profile.about;
      this.lat = this.profile.lat;
      this.lng = this.profile.lng;
      this.address = this.profile.address;
      this.location = this.profile.location;
      this.phone = this.profile.phone;
      this.user_id = this.profile.user_id;
    },
    get_data(){
      return{
        about: this.about,
        lat: this.lat,
        lng: this.lng,
        address: this.address,
        location: this.location,
        phone: this.phone,
        user_id: this.user_id,
      }
    },
    getAddressData: function (addressData, placeResultData) {
      this.address = addressData;
    },
    setPlace(place){
        this.lat = place.geometry.location.lat(),
        this.lng = place.geometry.location.lng()
        this.location = place.formatted_address;
    },
    submit(){
      if (this.user_id != null) {
        axios.put('/api/profile/'+this.user_id+'/detail', this.get_data()).then((resp)=>{
          if (resp.status == 200) {
            this.$store.commit('profile_mutation', resp.data.profile);
            this.$emit('detail_edit');
            this.toast_success('Data diperbaharui');
          }
        }).catch(error => {
          if (error.response) {
            this.catchError(error.response);
          }
        });
      }
    }
  },
  mixins: [catchJsonErrors]

}
</script>
<style lang="scss" scoped>
textarea,
.textarea {
  min-height: 50px;
  height: auto;
}
.g-map input{
  -moz-appearance: none;
  -webkit-appearance: none;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  border: 1px solid transparent;
  border-radius: 3px;
  -webkit-box-shadow: none;
  box-shadow: none;
  display: -webkit-inline-box;
  display: -ms-inline-flexbox;
  display: inline-flex;
  font-size: 1rem;
  height: 2.25em;
  -webkit-box-pack: start;
  -ms-flex-pack: start;
  justify-content: flex-start;
  line-height: 1.5;
  padding-bottom: calc(0.375em - 1px);
  padding-left: calc(0.625em - 1px);
  padding-right: calc(0.625em - 1px);
  padding-top: calc(0.375em - 1px);
  position: relative;
  vertical-align: top;
  background-color: white;
  border-color: #dbdbdb;
  color: #363636;
  -webkit-box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
  box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
  max-width: 100%;
  width: 100%;
}
</style>
