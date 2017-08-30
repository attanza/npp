export default {
  methods: {
    commitNots(comment, dream, authDream) {
      let commentOwner = comment.owner;
      let dreamOwner = dream.user;
      let parentId = comment.parent_id;
      let msg = '';
      let avatar = commentOwner.profile.photo_path;
      if (commentOwner.id != dreamOwner.id && parentId == 0) { // Others on root Comment
        msg = this.getFullname(commentOwner)+' menanggapi mimpimu';
        this.storeNots(avatar, msg);
        console.log('Others on root Comment');
      } else if (commentOwner.id != dreamOwner.id && parentId != 0) { // Others reply to child
        // to dream Owner
        if (dream.id == authDream.id) {
          msg = this.getFullname(commentOwner)+' menanggapi mimpimu';
          console.log('Others reply to child to dream Owner');
        } else {
          msg = this.getFullname(commentOwner)+' menanggapi mimpi '.this.getFullname(dreamOwner);
          console.log('Others reply to child to others');
        }

      } else if (commentOwner.id == dreamOwner.id && parentId != 0) {
        // Dream Owner reply to child
        msg = this.getFullname(dreamOwner)+' membalas tanggapan mimpinya';
        console.log('Dream Owner reply to child');
      }
    },

    getFullname(user){
      return user.first_name+' '+user.last_name;
    },

    storeNots(notData){
      let data = {
        avatar: notData['avatar'],
        msg: notData['msg'],
        id: notData['id'],
        url: notData['url'],
      }
      this.$store.commit('unread_nots_mutation', data);
    }
  }
}
