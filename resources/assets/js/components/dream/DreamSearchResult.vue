<template>
  <div id="dream_search_result">
    <div class="modal" :class="{'is-active' : users.length > 0}">
      <div class="modal-background" @click="onClose"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Hasil pencarian untuk "{{searchQ}}"</p>
          <button class="delete" aria-label="close" @click="onClose"></button>
        </header>
        <section class="modal-card-body">
          <article class="media" v-for="user in users">
            <figure class="media-left">
              <a class="image is-48x48" @click="showDream(user.slug)">
                <img :src="user.avatar">
              </a>
            </figure>
            <div class="media-content">
              <div class="content">
                <a @click="showDream(user.slug)">
                  <strong>{{user.name}}</strong> <small>{{user.email}}</small>
                  <br>
                  {{user.dream}}
                </a>
              </div>
            </div>
          </article>
        </section>
        <!-- <footer class="modal-card-foot">
          <button class="button move-right" @click="onClose">Tutup</button>
        </footer> -->
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "dream_search_result",
  data: () => ({

  }),
  props: ['users', 'searchQ'],
  methods: {
    onClose() {
      this.$emit('onClose');
    },
    showDream(slug){
      window.location.replace('/dream/'+slug);
    }
  }
}
</script>
<style lang="scss" scoped>
.modal-card-foot {
  justify-content: space-between;
}
.move-right {
  margin-left: auto;
}
.modal-card-head {
  background-color: #000;
}
.modal-card-title{
  color: #ffcc2a;
  font-size: 14px;
}
.media-content .content a{
  color: #000;
}
.media-content .content a:hover{
  color: #00d1b2;
}
figure img {
  border-radius: 50%;
}
</style>
