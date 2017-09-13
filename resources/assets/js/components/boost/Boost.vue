<template>
  <div id="boost">
    <ul class="list-inline">
      <li v-show="this.isAuth && this.authIsBooster">
        <div class="boosted" :class="{'animated rubberBand':isBoost}">
          <a>
            <span class="icon is-medium">
              <i class="fa fa-bolt"></i>
            </span>
          </a>
        </div>
      </li>
      <li v-show="this.isAuth && !this.authIsBooster">
        <div class="boost">
          <a @click="giveBoost">
            <span class="icon is-medium">
              <i class="fa fa-bolt"></i>
            </span>
          </a>
        </div>
      </li>
      <li v-show="!this.isAuth">
        <span class="icon is-medium">
          <i class="fa fa-bolt"></i>
        </span>
      </li>
      <li>
        <h4 class="subtitle is-4">{{this.authBoostCount}} Boost</h4>
      </li>
    </ul>
    <div class="box m-t-10 animated fadeInLeft" v-show="authBoostCount > 0">
      <ul class="list-inline">
        <li v-for="user in this.authBooster">
          <tooltip :label="user.name" placement="top-right">
            <a @click="view_user_dream(user.dream_slug)">
              <figure class="image is-32x32 booster">
                <img :src="user.avatar" alt="user.name">
              </figure>
            </a>
          </tooltip>
        </li>
        <li>
          <a @click="showModal = true" v-show="authBoostCount > 10">Lihat semua</a>
        </li>
      </ul>
    </div>
    <booster-list :showModal="showModal" :dream_id="dream_id" @onClose="showModal = false"></booster-list>
  </div>
</template>
<script>
import authUserData from '../../mixins/authUserData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import commitNotification from '../../mixins/commitNotification';
import BoosterList from './BoosterList';
import Tooltip from 'vue-bulma-tooltip';
export default {
  name: "boost",
  components: {
    BoosterList, Tooltip
  },
  data: () => ({
    showModal: false,
    isBoost: false,
  }),
  props: ['dream_id'],

  watch: {
    isAuth(){
      if (this.isAuth) {
        this.listen(this.authUser.username)
      }
    }
  },

  mounted(){
    this.get_boosts();
  },
  methods: {
    get_boosts(){
        axios.get('/boost/'+this.dream_id).then((resp)=>{
          if (resp.status == 200) {
            // console.log(resp);
            this.$store.commit('boost_count_mutation', resp.data.boost_count);
            resp.data.boosterData.forEach((boost)=>{
              this.$store.commit('booster_mutation', boost);
            });
            this.$store.commit('is_booster_mutation', resp.data.is_booster);
            isBoost: false,
            this.isBoost = true;
          }
        }).catch(error => {
          if (error.response) {
            this.catchError(error.response);
          }
        });
    },
    giveBoost() {
      axios.get('/api/boost/'+this.dream_id).then((resp)=>{
        if (resp.status == 200) {
          this.$store.commit('booster_mutation', resp.data.booster);
          this.$store.commit('is_booster_mutation', true);
          this.$store.commit('boost_add_mutation');
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },

    listen(username){
      Echo.private('npp-user.'+ username)
          .listen('BoostEvent', (e) => {
              this.add_booster(e);
          });
    },

    add_booster(e){
      let data = {
        name: e.name,
        avatar: e.avatar
      }
      this.$store.commit('booster_mutation', data);
      this.$store.commit('boost_add_mutation');
    },

    view_user_dream(slug){
      window.location.replace('/dream/'+slug);
    }
  },
  mixins: [authUserData, catchJsonErrors, commitNotification],
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
  padding-right: 5px;
  padding-left: 5px;
}
.boost {
  background-color: #ffcc2a;
  color: #fff;
  border-radius: 50%;
}
.boost a {
  color: #fff;
}
.boost a:hover {
  color: #00d1b2;
}
.boosted {
  background-color: #ffcc2a;
  color: #fff;
  border-radius: 50%;
  border: 2px solid #00d1b2;
}
.booster img {
  border-radius: 50%;
}
</style>
