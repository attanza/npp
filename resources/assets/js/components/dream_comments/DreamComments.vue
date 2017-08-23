<template>
  <div id="dream_comments">
    <div class="box">
      <p class="title is-3">{{dream.dream}}</p>
      <p class="subtitle is-5">{{dream.description}}</p>
    </div>
    <comment-input :dream_id="dream.id" :size="'is-48x48'"></comment-input>
    <div class="comments-wrapper m-t-10">
      <comment-list :dream_id="dream.id"></comment-list>
    </div>
  </div>
</template>
<script>
import CommentInput from './CommentInput'
import CommentList from './CommentList'

export default {
  name: "dream_comments",
  components: {
    CommentInput, CommentList
  },
  data: () => ({

  }),
  props: ['dream'],
}
</script>
<style lang="scss" scoped>
</style>
