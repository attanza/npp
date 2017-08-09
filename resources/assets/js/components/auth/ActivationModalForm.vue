<template>
  <div class="modal-card">
    <header class="modal-card-head">
        <p class="modal-card-title">Akun anda belum aktif</p>
    </header>
    <section class="modal-card-body">
      <p class="content">
        Kami telah mengirimkan email aktifasi via email yang anda daftarkan.
      </p>
        <b-checkbox v-model="resend_mail">Kirim ulang email aktifasi ?</b-checkbox>
    </section>
    <footer class="modal-card-foot">
      <div class="columns">
        <div class="column">
          <button class="button is-black is-outlined" @click="next_process">Tutup</button>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
    export default {
      data: () => ({
        resend_mail: false
      }),
      methods: {
        next_process(){
          window.eventBus.$emit('confirm_activation', this.resend_mail);
        }
      }
    }
</script>

<style scoped>
    .modal-card {
        width: auto;
    }
    /*.modal-card-head {
      background-color: #000;
      color: #fff;
    }*/
</style>
