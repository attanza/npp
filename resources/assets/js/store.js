import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
	state: {
		user: {},
		profile: {},
		avatar: '',
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
		}
	}
})
