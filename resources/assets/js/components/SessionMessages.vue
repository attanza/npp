<template>
  <div id="session_messages">

  </div>
</template>
<script>
export default {
  name: "session_messages",
  props: ['type', 'message'],
  mounted(){
    if (this.type != null || this.type != '') {
      this.send_notification();
    }
  },
  methods: {
    send_notification(){
      console.log(this.message);
      let type;
      if (this.type == 'success') {
        type = 'is-success';
      } else {
        type = 'is-danger';
      }
      this.$toast.open({
        duration: 5000,
        message: this.message,
        type: type
      })

    }
  }
}
</script>
<style lang="scss" scoped>
</style>
