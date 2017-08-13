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
		}
	}
})
