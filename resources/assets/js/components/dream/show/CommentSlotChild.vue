<template>
  <div id="comment_slot">
    <article class="media m-t-10" v-for="(comment, index) in comments" :id="'comment.'+parent_index+'-'+index">
      <figure class="media-left">
        <p class="image is-32x32">
          <img :src="comment.owner.profile.photo_path" v-if="comment.owner">
        </p>
      </figure>
      <div class="media-content">
        <div class="content">
          <p>
            <strong v-if="comment.owner">{{comment.owner.first_name}} {{comment.owner.last_name}}</strong>
            <br>
            <span v-html="comment.body"></span>
          </p>

        </div>
        <nav class="level is-mobile">
          <div class="level-left">
            <a class="level-item" @click="showForm" v-show="isAuth">
              <span class="icon is-small"><i class="fa fa-reply"></i></span>
            </a>
            <span class="level-item">
              <small class="is-pulled-right">{{comment.created_at | moment("from", "now") }}</small>
            </span>
          </div>
        </nav>
      </div>
      <div class="media-right" v-if="comment.dream_id == authDream.id">
        <button class="delete"></button>
      </div>
    </article>
  </div>
</template>
<script>
import CommentAdd from './CommentAdd';

import authUserData from '../../../mixins/authUserData';
export default {
  name: "comment_slot",
  components: {
    CommentAdd,
  },
  data: () => ({
    comments: [],
  }),
  props: ['comment_data', 'parent_index'],

  watch: {
    comment_data(){
      if (this.comment_data != null) {
        this.comments = this.comment_data;
      }
    }
  },

  mounted(){
    this.comments = this.comment_data;
  },

  methods: {
    showForm(){
      document.getElementById('c'+this.parent_index).style.display = "block";
      document.getElementById('body_'+this.parent_index).focus();
    }
  },

  mixins: [authUserData],

}
</script>
<style lang="scss" scoped>
</style>
