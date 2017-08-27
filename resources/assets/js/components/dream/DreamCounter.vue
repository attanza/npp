<template>
  <div id="dream_counter">
    <center>
      <ul class="list-inline">
        <li v-for="value in dreamCounts">
          <div class="box">
            <p class="is-size-4 has-text-centered">{{value}}</p>
          </div>
        </li>
      </ul>
    </center>
  </div>
</template>
<script>
export default {
  name: "dream_counter",
  data: () => ({
    dreamCounts: [],
  }),
  mounted(){
    this.getDreamCount();
  },
  methods: {
    getDreamCount() {
      axios.get('/dream/count').then((resp)=>{
        // console.log(resp);
        if (resp.status == 200) {
          let dreams = resp.data.dream_count.toString();
          this.dreamCounts = Array.from(dreams);
          console.log(this.dreamCounts);
        }
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.list-inline {
  padding-left: 0;
  margin-left: -5px;
  list-style: none;
}
.list-inline > li {
  display: inline-block;
  padding-right: 3px;
  padding-left: 3px;
}
.box {
  padding: 8px;
}
</style>
