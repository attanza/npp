<template>
  <div id="comment_slot">
    <article class="media" v-for="(comment, index) in comments" :id="'comment_'+index">

      <figure class="media-left">
        <p class="image is-48x48">
          <img :src="comment.owner.profile.photo_path" v-if="comment.owner">
        </p>
      </figure>

      <div class="media-content" :id="'#dream_comment_'+comment.id">
        <div class="content">
          <p>
            <strong v-if="comment.owner">
              {{comment.owner.first_name}} {{comment.owner.last_name}}
            </strong>
            <br>
            <span v-html="comment.body"></span>
          </p>
        </div>
        <nav class="level is-mobile">
          <div class="level-left">
            <a class="level-item">
              <span class="icon is-small" @click="showForm(index)"><i class="fa fa-reply"></i></span>
            </a>
            <span class="level-item">
              <small class="is-pulled-right">{{comment.created_at | moment("from", "now") }}</small>
            </span>
          </div>
        </nav>

        <!--  Child comments -->
        <div class="comment-child">
          <div v-if="comment.all_replies_with_owner != null || comment.all_replies_with_owner != []">
            <comment-slot-child :comment_data="comment.all_replies_with_owner" :parent_index="index"></comment-slot-child>
          </div>
          <comment-add :comment="comment" :index="index"></comment-add>
        </div>
      </div>
      <div class="media-right" v-if="comment.dream_id == authDream.id">
        <button class="delete"></button>
      </div>
    </article>
    <div id="last_root_comment"></div>
  </div>
</template>
<script>
import CommentSlotChild from './CommentSlotChild';
import CommentAdd from './CommentAdd';

import authUserData from '../../../mixins/authUserData';
export default {
  name: "comment_slot",
  components: {
    CommentSlotChild,
    CommentAdd
  },
  data: () => ({
    comments: [],
  }),

  props: ['comment_data'],

  watch: {
    comment_data(){
      if (this.comment_data != null) {
        this.comments = this.comment_data;
      }
    }
  },

  // mounted(){
  //   this.comments = this.comment_data;
  //   console.log('from parrent slot',this.comments);
  // },

  methods: {
    showForm(index){
      document.getElementById('c'+index).style.display = "block";
      document.getElementById('body_'+index).focus();
    },
  },
  mixins: [authUserData],
}
</script>
<style lang="scss" scoped>
.comment-child {
  // border-left: 1px solid #ccc;
  padding-left: 10px;
  margin-left: -40px;
}
</style>
