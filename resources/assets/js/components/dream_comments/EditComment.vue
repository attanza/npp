<template>
  <div id="edit_comment">
    <div class="modal" :class="{'is-active' : showEdit}">
      <div class="modal-background" @click="close"></div>
      <div class="modal-content">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
      <button class="modal-close is-large" aria-label="close" @click="close"></button>
    </div>
  </div>
</template>
<script>
export default {
  name: "edit_comment",
  data: () => ({
    show: false,
  }),
  props: ['comment', 'showEdit'],

  methods: {
    close() {
      this.$emit('editClose');
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
