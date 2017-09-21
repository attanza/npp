<template>
  <div id="dream_welcome">
      <p class="is-size-5-desktop is-size-6-mobile has-text-white" v-show="firstStep">
        Terima Kasih sudah ikut berpartisipasi untuk mensukseskan Gerakan Berjuta Mimpi Indonesia, Dukunganmu sungguh sangat berarti bagi kami. <br>
        Ayo segera DEKLARASIKAN MIMPIMU dan kita saling mendukung untuk mewujudkannya bersama INDONESIA. <br>
        Langkah pertama deskripsikan apa mimpimu.
      </p>
      <p class="is-size-4-desktop is-size-6-mobile has-text-white" v-show="secondStep">
        Tinggal satu langkah lagi untuk menyempurnakan mimpimu agar lebih Powerfull. <br>
        Unggah gambar yang mewakili mimpimu.
      </p>
      <p class="is-size-5-desktop is-size-6-mobile has-text-white" v-show="thirdStep">
        Kami ucapkan selamat, karena kamu telah melakukan langkah awal untuk mewujudkan mimpi yaitu berani menunjukkanya kepada DUNIA. <br>
        Ayo kita saling memberi dukungan kepada teman - teman lain yang telah mendeklarasikan mimpinya dalam Berjuta Mimpi Indonesia dengan cara memberikan komentar dan semangat (Boost) kepada mereka.  <br>
        Jangan lupa untuk mengajak teman - teman lainnya untuk bergabung bersama Berjuta Mimpi Indonesia. <br>
      </p>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';

export default {
  name: "dream_welcome",
  data: () => ({
    firstStep: false,
    secondStep: false,
    thirdStep: false,

  }),
  watch: {
    authDream() {
      if (this.authDream.dream == null || this.authDream.dream == '') {
        this.firstStep = true;
      } else {
        this.firstStep = false;
      }

      if (!this.firstStep && this.authDream.medias.length == 0) {
        this.secondStep = true;
      } else {
        this.secondStep = false;
      }

      if (!this.secondStep && !this.firstStep) {
        this.thirdStep = true;
      }
    }
  },
  mounted(){
    window.eventBus.$on('after-upload', this.afterUpload);
  },
  methods: {
    afterUpload() {
      this.secondStep = false;
      this.thirdStep = true;
    }
  },
  mixins: [authUserData]
}
</script>
<style lang="scss" scoped>
</style>
