<template>
  <div id="table_search" class="m-b-20">
    <nav class="level">
      <div class="level-left">
        <div class="level-item">
          <div class="field">
            <div class="control">
              <div class="select">
                <select v-model="paginate" @change="paginateChange">
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="level-right">
        <div class="level-item">
          <div class="field">
            <p class="control has-icons-right">
              <input class="input" type="text" placeholder="Cari..." v-model="query" @keyup="paginateChange">
              <span class="icon is-small is-right">
                <i class="fa fa-search"></i>
              </span>
            </p>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  name: "table_search",
  data: () => ({
    paginate: 10,
    query: ''
  }),
  // props: ['pagination'],
  methods: {
    paginateChange() {
      let data = {
        paginate: this.paginate,
        query: this.query
      }
      this.$emit('paginateChange', data)
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
