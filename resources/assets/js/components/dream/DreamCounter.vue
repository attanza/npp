<template>
  <div id="dream_counter">
    <center>
      <ul class="list-inline" @click="toBmi">
        <li v-for="value in dreamCounts">
          <div class="box-npp animated fadeInDown">
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
    bmiUrl: baseUrl+'/berjuta-mimpi-indonesia'
  }),
  mounted(){
    this.getDreamCount();
  },
  methods: {
    getDreamCount() {
      axios.get('/dream/count').then((resp)=>{
        // console.log(resp);
        if (resp.status == 200) {
          let num = resp.data.dream_count.toString();
          // let num = '123456789';
          let text_num = this.form_counter(num)
          this.dreamCounts = Array.from(text_num);
        }
      })
    },
    form_counter(num){
      if (num < 10) {
        return '000000'+num;
      } else if (num < 100) {
        return '00000'+num;
      } else if (num < 1000) {
        return '0000'+num;
      } else if (num < 10000) {
        return '000'+num;
      } else if (num < 100000) {
        return '00'+num;
      } else if (num < 1000000) {
        return '0'+num;
      } else {
        return num;
      }
    },
    toBmi(){
      window.location.replace(this.bmiUrl);
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
.box-npp {
  padding: 4px 8px;
  border: 2px solid #000;
  background-color: #fff;
}
.list-inline:hover{
  cursor: pointer;
}
</style>
