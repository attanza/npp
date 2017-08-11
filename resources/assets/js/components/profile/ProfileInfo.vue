<template>
  <div id="profile_info">
    <div class="content">
      <profile-info-contact v-show="showContact" @contact_edit="showContact = false"></profile-info-contact>
      <profile-info-contact-edit v-show="!showContact" @contact_edit="showContact = true"
          :user="user_data">
      </profile-info-contact-edit>
    </div>
    <div class="content">
      <profile-info-detail v-show="showDetail" @detail_edit="showDetail = false"></profile-info-detail>
      <profile-info-detail-edit v-show="!showDetail" @detail_edit="showDetail = true"
          :profile="user_data.profile">
      </profile-info-detail-edit>
    </div>
  </div>
</template>
<script>
import ProfileInfoContact from './ProfileInfoContact';
import ProfileInfoContactEdit from './ProfileInfoContactEdit';
import ProfileInfoDetail from './ProfileInfoDetail';
import ProfileInfoDetailEdit from './ProfileInfoDetailEdit';

export default {
  name: "profile_info",
  components: {
    'profile-info-contact': ProfileInfoContact,
    'profile-info-contact-edit': ProfileInfoContactEdit,
    'profile-info-detail': ProfileInfoDetail,
    'profile-info-detail-edit': ProfileInfoDetailEdit,
  },
  data: () => ({
    showContact: true,
    showDetail: true,
  }),
  props: ['user_data'],

}
</script>
<style lang="scss" scoped>
</style>
