import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
	state: {
		user: {},
		profile: {},
		avatar: '',
		dream: '',
		dream_photo: '',
		is_auth: false,
		dream_comments: [],
		unread_nots: [],
		boost_count: 0,
		booster: [],
		is_booster: false,
		currentParentComment: {},
	},

	getters: {
		get_comments(state){
			return state.dream_comments;
		}
	},

	mutations: {
		user_mutation(state, user){
			state.user = user
		},
		profile_mutation(state, profile){
			state.profile = profile
		},
		avatar_mutation(state, avatar){
			state.avatar = avatar
		},
		dream_mutation(state, dream){
			state.dream = dream
		},
		dream_photo_mutation(state, dream_photo){
			state.dream_photo = dream_photo
		},
		is_auth_mutation(state, is_auth){
			state.is_auth = is_auth
		},
		unread_nots_mutation(state, nots){
			state.unread_nots.push(nots)
		},
		boost_count_mutation(state, boost_count){
			state.boost_count = boost_count
		},
		boost_add_mutation(state){
			state.boost_count = state.boost_count + 1
		},
		booster_mutation(state, boost){
			state.booster.push(boost)
		},
		is_booster_mutation(state, p){
			state.is_booster = p
		},
		currentParentComment_mutation(state, comment){
			state.currentParentComment = comment
		},
		// Comments
		dream_comments_mutation(state, comment){
			state.dream_comments.unshift(comment)
		},
		clear_comments(state){
			state.dream_comments = [];
		},
		dream_comments_add_mutation(state, comment){
			state.dream_comments.push(comment)
		},
		dream_comments_edit_mutation(state, comment){
			// detect if comment is parent or child comment
			if (comment.parent_id == 0) {
				// if parent
				let index = _.findIndex(state.dream_comments, function(dc) {
					return dc.id == comment.id;
				});
				state.dream_comments.splice(index, 1, comment);
			} else {
				// if child
				// get the parent id
				let parent = _.find(state.dream_comments, function(c){
					return c.id == comment.parent_id;
				})
				// get child index
				let childIndex = _.findIndex(parent.replies, function(p) {
					return p.id == comment.id;
				});
				// replace child
				parent.replies.splice(childIndex, 1, comment);
			}

		},
		// Child Comment
		add_child_comment(state, comment){
			let index = _.findIndex(state.dream_comments, function(dc) {
				return dc.id == comment.parent_id;
			});
			let parent = state.dream_comments[index];
			parent.replies.push(comment);
			state.dream_comments.splice(index, 1, parent);
		},
	}
})
