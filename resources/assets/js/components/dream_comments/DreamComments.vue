<template src="./dream_comments.html"></template>
<script>
import ParentComments from './ParentComments';
import authUserData from '../../mixins/authUserData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
export default {
  name: "dream_comments",
  components: {
    ParentComments
  },
  data: () => ({
    body: '',
    disabled: true,
  }),
  props: ['dream'],
  watch: {
    body(){
      if (this.body.length > 1) {
        this.disabled = false;
      }
    }
  },
  mounted(){
    window.eventBus.$on('deleteComment', this.deleteComment);
  },
  methods: {
    send_comment() {
      axios.post('/api/parent-comments', this.get_data()).then((resp)=>{
        window.eventBus.$emit('onNewComment', resp.data.comment)
        this.body = '';
        this.disabled = true;
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    },
    get_data(){
      return {
        user_id: this.authUser.id,
        dream_id: this.dream.id,
        parent_id: 0,
        body: this.body
      }
    },
  },
  mixins: [authUserData, catchJsonErrors]
}
</script>
<style lang="scss" scoped>
</style>
