<template>
  <div id="confirm_modal">
    <div class="modal" :class="{'is-active' : modalActive}">
      <div class="modal-background" @click="close"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">
            <span class="icon is-medium">
              <i class="fa fa-question-circle"></i>
            </span>
          </p>
          <button class="delete" aria-label="close" @click="close"></button>
        </header>
        <section class="modal-card-body">
          <p class="subtitle is-4 has-text-centered">Anda yakin ?</p>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-small is-warning is-otlined is-fullwidth" @click="close">Tidak</button>
          <button class="button is-small is-warning is-otlined is-fullwidth" @click="next">Ya</button>
        </footer>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "confirm_modal",
  data: () => ({
    modalActive: false,
  }),
  mounted(){
    window.eventBus.$on('confirmModalActive', this.confirmModalActive)
  },
  methods: {
    close() {
      this.modalActive = false
    },
    next(){
      this.modalActive = false;
      window.eventBus.$emit('confirmed');
    },
    confirmModalActive(){
      this.modalActive = true;
    }
  }
}
</script>
<style lang="scss" scoped>
.modal-card {
  width: 300px;
}
.modal-card-head, .modal-card-foot {
  background-color: #fff;
}
// .modal-card-body {
//   background-color: #000;
//   color: #fff;
// }
// .subtitle {
//   color: #fff;
// }
</style>
