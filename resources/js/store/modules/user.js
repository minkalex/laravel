export default {
    state: {
        user: {}
    },
    mutations: {
        setUser (state, objUser) {
            state.user = objUser
        }
    },
    getters: {
        getCurrentUser(state) {
            //if (Object.keys(state.user).length !== 0) {
                return state.user;
            //}
        },
    },
    actions: {
        async setNewUser(context, objUser) {
            context.commit('setUser', objUser);
        }
    }
}
