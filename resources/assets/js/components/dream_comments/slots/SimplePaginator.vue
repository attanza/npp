<template>
  <div id="simple_paginator">
    <nav class="level is-mobile">
      <div class="level-left">
        <div class="level-item">
          <tooltip label="Lihat tanggapan sebelumnya" placement="top-right">
            <a v-if="pagination.current_page < pagination.last_page" @click.prevent="changePage(pagination.current_page + 1)">
              <span><small>Sebelumnya...</small></span>
            </a>
          </tooltip>
          <span class="icon is-small" v-show="loader.morePage">
            <i class="fa fa-spinner fa-spin"></i>
          </span>
        </div>
      </div>
      <div class="level-right">
        <div class="level-item">
          <small v-if="pagination.total !== 0">
            {{pagination.to}} dari {{pagination.total}}
          </small>
        </div>
        <div class="level-item">
          <a class="m-t-5" @click="onRefresh">
            <span div="icon is-small">
              <i class="fa fa-refresh"></i>
            </span>
          </a>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>
import Tooltip from 'vue-bulma-tooltip';
export default {
  name: "simple_paginator",
  components: {
    Tooltip
  },
  data: () => ({

  }),
  props: ['pagination', 'loader'],
  methods: {
    changePage(page){
      this.$emit('changePage', page);
    },
    onRefresh(){
      this.$emit('onRefresh');
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
