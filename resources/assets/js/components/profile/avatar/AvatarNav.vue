<template>
  <img :src="authAvatar" :alt="authUser.first_name" style="border-radius: 50%">
</template>
<script>
import authUserData from '../../../mixins/authUserData';

export default {
  name: "avatar_nav",
  data: () => ({

  }),
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
</style>
