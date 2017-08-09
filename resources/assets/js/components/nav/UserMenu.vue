<template>
    <b-dropdown hoverable>
        <button class="button is-info" slot="trigger">
            <span>Hover me!</span>
            <b-icon icon="arrow_drop_down"></b-icon>
        </button>

        <b-dropdown-item>Action</b-dropdown-item>
        <b-dropdown-item>Another action</b-dropdown-item>
        <b-dropdown-item>Something else</b-dropdown-item>
    </b-dropdown>
</template>
<script>
export default {
  name: "user_menu",
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
</style>
