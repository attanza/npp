<template src="./terms.html"></template>
<script>
export default {
  name: "tems",
  data: () => ({

  }),
  props: ['termsShow'],
  methods: {
    onClose() {
      this.$emit('onClose');
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
.modal {
  position: relative;
   z-index:100 !important;
}
</style>
