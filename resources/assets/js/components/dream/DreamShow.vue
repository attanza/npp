<template>
  <div id="dream_show">
    <div class="field is-grouped is-grouped-centered m-t-20">
      <p class="control">
        <button class="button is-primary is-medium" @click="showDream">
          <span class="icon">
            <i class="fa fa-cloud"></i>
          </span>
          <span>Lihat mimpimu</span>
        </button>
      </p>
    </div>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';

export default {
  name: "dream_show",
  data: () => ({

  }),
  methods: {
    showDream() {
      console.log('show');
      if (this.authDream) {
        window.location.replace('/dream/'+this.authDream.slug)
      }
    }
  },
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
</style>
