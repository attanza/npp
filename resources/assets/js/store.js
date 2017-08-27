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
	},

	getters: {

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
		dream_comments_mutation(state, comment){
			state.dream_comments.unshift(comment)
		},
		dream_comments_add_mutation(state, comment){
			state.dream_comments.push(comment)
		},
		dream_comments_mutation_with_index(state, data){
			state.dream_comments[data.index].all_replies_with_owner.push(data.comment)
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
	}
})
