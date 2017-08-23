<template>
  <div id="comment_root">
    <article class="media m-t-10">
      <figure class="media-left">
        <p class="image" :class="size">
          <img :src="comment.owner.profile.photo_path">
        </p>
      </figure>
      <div class="media-content">
        <div class="content">
          <p>
            <strong>{{comment.owner.first_name}} {{comment.owner.last_name}}</strong>
            <br>
            {{comment.body}}
          </p>
        </div>
        <nav class="level is-mobile">
          <div class="level-left">
            <a class="level-item">
              <span class="icon is-small"><i class="fa fa-reply"></i></span>
            </a>
            <span class="level-item">
              <small class="is-pulled-right">{{comment.created_at | moment("from", "now") }}</small>
            </span>
          </div>
        </nav>
      </div>
      <div class="media-right">
        <button class="delete"></button>
      </div>
    </article>
  </div>
</template>
<script>
export default {
  name: "comment_root",
  data: () => ({

  }),
  props: ['comment', 'size'],
}
</script>
<style lang="scss" scoped>
</style>
