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
      let type;
      if (this.type == 'success') {
        type = 'success';
      } else {
        type = 'error';
      }
      this.throw_noty(type, this.message);
    },
    throw_noty(type, msg){
      new Noty({
        type: type,
        text: msg,
        layout: 'topCenter',
        theme: 'metroui',
        timeout: 5000,
        progressBar: true,
      }).show();
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
