export default{
  methods: {
    commitCurrentParentComment(id) {
      this.$store.commit('currentParentComment_mutation', id);
    },
    clearComments(){
      this.$store.commit('clear_comments');
    },
    markDelete(id){
      let strike = "strike_"+id;
      let unstrike = "unstrike_"+id;
      let delete_btn = "delete_child_"+id;
      let undo_btn = "undo_delete_child_"+id;
      document.getElementById(strike).style.display = "block";
      document.getElementById(undo_btn).style.display = "block";
      document.getElementById(unstrike).style.display = "none";
      document.getElementById(delete_btn).style.display = "none";

    },
    undoDeleteChild(id){
      let strike = "strike_"+id;
      let unstrike = "unstrike_"+id;
      let delete_btn = "delete_child_"+id;
      let undo_btn = "undo_delete_child_"+id;
      document.getElementById(strike).style.display = "none";
      document.getElementById(undo_btn).style.display = "none";
      document.getElementById(unstrike).style.display = "block";
      document.getElementById(delete_btn).style.display = "block";
    },

    deleteComment(comment){
      axios.delete('/api/comment/'+comment.id).then((resp)=>{
        console.log(resp);
        if (resp.status == 200) {
          let el = document.getElementById("child_article_"+comment.id);
          el.classList.add("flipInX");
          this.undoDeleteChild(comment.id)
          this.$store.commit('replaceParent', resp.data.comment);
        }
      }).catch(error => {
        if (error.response) {
          this.catchError(error.response);
        }
      });
    }
  },
  computed: {
    currentParentComment(){
      return this.$store.state.currentParentComment;
    },
  }
}
