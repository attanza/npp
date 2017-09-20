<template>
  <div id="dream_create_button">
    <div class="field is-grouped is-grouped-centered m-t-20">
      <p class="control">
        <button class="button is-primary is-medium" @click="showForm">
          <span class="icon">
            <i class="fa fa-hand-o-right"></i>
          </span>
          <span>Langkah 1: Deskripsikan mimpimu...</span>
        </button>
      </p>
    </div>
  </div>
</template>
<script>
export default {
  name: "dream_create_button",
  data: () => ({
    isOpen: false,
  }),
  methods: {
    showForm() {
      window.eventBus.$emit('show-form');
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
