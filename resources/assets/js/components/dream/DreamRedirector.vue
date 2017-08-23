<template>
  <div id="dream_redirector">
  </div>
</template>
<script>
export default {
  name: "dream_redirector",
  data: () => ({

  }),
  props: ['slug', 'comment_id'],
  mounted(){
    console.log(this.slug);
    console.log(this.comment_id);
    window.location.href = '/dream/'+this.slug+'#dream_comment'+this.comment_id;

  }
}
</script>
<style lang="scss" scoped>
</style>
