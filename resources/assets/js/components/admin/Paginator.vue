<template>
  <div id="paginator">
    <nav class="pagination">
      <a class="pagination-previous" v-if="pagination.current_page > 1" @click.prevent="changePage(pagination.current_page = 1)">
        <span class="icon">
          <i class="fa fa-fast-backward"></i>
        </span>
      </a>
      <a class="pagination-previous" v-if="pagination.current_page > 1" @click.prevent="changePage(pagination.current_page - 1)">
        <span class="icon">
          <i class="fa fa-step-backward"></i>
        </span>
      </a>

      <a class="pagination-next" v-if="pagination.current_page < pagination.last_page" @click.prevent="changePage(pagination.current_page + 1)">
        <span class="icon">
          <i class="fa fa-step-forward"></i>
        </span>
      </a>
      <a class="pagination-next" v-if="pagination.current_page < pagination.last_page" @click.prevent="changePage(pagination.current_page = pagination.last_page)">
        <span class="icon">
          <i class="fa fa-fast-forward"></i>
        </span>
      </a>

      <ul class="pagination-list">
        <li v-for="page in pagesNumber">
          <a class="pagination-link" @click.prevent="changePage(page)" v-bind:class="[page == isActived ? 'is-current' : '']">{{page}}</a>
        </li>
      </ul>
    </nav>
  </div>
</template>
<script>
export default {
  name: "paginator",
  props: ['pagination', 'pagesNumber', 'isActived'],
  methods: {
    changePage(page) {
      this.$emit('changePage', page);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
