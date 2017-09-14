<template>
  <div :id="el+comment.id">
    <article class="media animated" :class="{'' : isDeleted}">
      <a :href="'/dream/'+comment.owner_dream_slug">
        <figure class="media-left">
          <p class="image" :class="avatarSize">
            <slot name="avatar"></slot>
          </p>
        </figure>
      </a>
      <div class="media-content">
        <div class="content">
          <slot name="userName"></slot>
          <div v-if="!isEdit">
            <slot name="body"></slot>
          </div>

          <div class="columns is-mobile animated fadeIn" v-else>
            <div class="column">
              <div class="control is-expanded">
                <textarea class="textarea" v-model="editedBody" :id="'editedBody_'+comment.id" rows="1" v-html="cleanBody" style="padding: 3px;"></textarea>
              </div>
            </div>
            <div class="column is-narrow">
              <button type="button" class="button is-primary" :disabled="disabled" @click="editComment">
                <span class="icon is-small">
                  <i class="fa fa-paper-plane"></i>
                </span>
              </button>
            </div>
          </div>
        </div>
        <nav class="level is-mobile" v-if="isAuth">
          <!--  Reply Section -->
          <div class="level-left">
            <a class="level-item" @click="replyChild">
              <span class="icon is-small"><i class="fa fa-reply"></i></span>
            </a>
            <div class="level-item">
              <slot name="created"></slot>
            </div>
          </div>

          <div class="level-right" v-if="!askDelete">
            <!--  Edit Section -->
            <div class="level-item" v-if="comment.owner_id == authUser.id">
              <a @click="isEdit = true" v-if="!isEdit">
                <span class="icon is-small">
                  <i class="fa fa-pencil"></i>
                </span>
              </a>
              <a @click="isEdit = false" v-else>
                <span style="font-size: 12px;">Cancel edit</span>
              </a>
            </div>
            <div class="level-item" v-if="comment.owner_id == authUser.id || dream_id == authDream.id">
              <a @click="askDelete = true">
                <span class="icon is-small">
                  <i class="fa fa-trash"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="level-right" v-else>
            <div class="level-item">
              <ul class="list-inline">
                <li>Hapus ?</li>
                <li><a @click="deleteComment">Ya</a></li>
                <li><a @click="askDelete = false">Tidak</a></li>
              </ul>
            </div>
          </div>


        </nav>
        <slot name="childComments"></slot>
      </div>
    </article>
  </div>
</template>
<script>
import authUserData from '../../../mixins/authUserData';
export default {
  name: "comment",
  data: () => ({
    askDelete: false,
    isEdit: false,
    editedBody: '',
    disabled: true,
    isDeleted: false
  }),
  props: ['avatarSize', 'comment', 'dream_id', 'el'],
  watch: {
    editedBody(){
      if (this.editedBody.length >= 2) {
        this.disabled = false;
      }
    },
    isEdit(){
      if (this.isEdit == true) {
        this.prepareBody();
      }
    }
  },
  methods: {
    deleteComment() {
      // window.eventBus.$emit('deleteParentComment', this.comment.id);
      window.eventBus.$emit('onDelete', this.comment.id);
      this.askDelete = false;
      this.isDeleted = true;
    },
    editComment(){
      let data = {
        id: this.comment.id,
        body: this.editedBody,
        dream_id: this.dream_id,
        user_id: this.authUser.id,
        parent_id: this.comment.parent_id,
      }
      // window.eventBus.$emit('editParentComment', data);
      this.$emit('onUpdate', data);
      this.isEdit = false;
    },
    prepareBody: _.debounce(function(){
      let elId = "editedBody_"+this.comment.id;
      let el = document.getElementById(elId);
      Stretchy.resize(el);
      el.focus();
    }, 500),
    replyChild(){
      let id;
      if (this.comment.parent_id == 0) {
        id = this.comment.id;
      } else {
        id = this.comment.parent_id
      }
      let emitName = 'reply_'+this.el
      window.eventBus.$emit(emitName, id)
    }
  },
  computed: {
    cleanBody(){
      let rex = /(<([^>]+)>)/ig;
      return this.comment.body.replace(rex, "").trim();
    }
  },
  mixins: [authUserData]

}
</script>
<style lang="scss" scoped>
.list-inline {
  padding-left: 0;
  margin-left: -5px;
  list-style: none;
  font-size: 12px;
}
.list-inline > li {
  display: inline-block;
  padding-right: 5px;
  padding-left: 5px;
}
.media-content {
  margin-top: -5px;
}
.media .content:not(:last-child) {
    margin-bottom: 0.15rem;
}
.level:not(:last-child) {
    margin-bottom: 0.5rem;
}
</style>
