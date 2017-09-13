<template>
  <div id="modal_form">
    <div class="modal" :class="{'is-active' : showModal}">
      <div class="modal-background" @click="onClose"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">
            Akun anda belum aktif
          </p>
          <button class="delete" aria-label="close" @click="onClose"></button>
        </header>
        <section class="modal-card-body">
          Kami telah mengirimkan kode aktifasi via email yang anda daftarkan, silahkan aktifkan email anda terlebih dahulu dengan cara mengklik link yang telah kami kirimkan.
        </section>
        <footer class="modal-card-foot">
          <div class="field">
            <div class="control">
              <label class="checkbox">
                <input type="checkbox" name="resend_mail" v-model="resend_mail">
                  Kirimkan ulang kode aktifasi
              </label>
            </div>
          </div>
          <button class="button is-warning" @click="next_process">Tutup</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    resend_mail: false
  }),
  props: ['showModal'],
  methods: {
    next_process() {
      window.eventBus.$emit('confirm_activation', this.resend_mail);
    },
    onClose(){
      this.$emit('onClose');
    }
  }
}
</script>

<style scoped>
.delete:hover {
  background-color: #ffcc2a;
}
</style>
