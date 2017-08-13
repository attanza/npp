<template>
  <div id="dream_create_button">
    <div class="field is-grouped is-grouped-centered m-t-20">
      <p class="control">
        <button class="button is-primary is-medium" @click="showForm">
          <span class="icon">
            <i class="fa fa-hand-o-right"></i>
          </span>
          <span>Deklarasikan mimpimu disini</span>
        </button>
      </p>
    </div>
    <dream-create-form></dream-create-form>
  </div>
</template>
<script>
import DreamCreateForm from './DreamCreateForm'
export default {
  name: "dream_create_button",
  components: {
    DreamCreateForm
  },
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
