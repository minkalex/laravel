export default {
    state: {
        users: [],
        currentUser: {},
        chatsIsLoading: false,
        chatList: []
    },
    mutations: {
        addChat(state, objChat) {
            state.chatList.unshift(objChat)
        }
    },
    getters: {
        users: state => state.users,
        currentUser: state => state.currentUser,
        chats: state => state.chatList,
        chatsIsLoading: state => state.chatsIsLoading,
    },

    actions: {
        getUsersFromDb ({state}) {
            axios.get('./users')
                .then(({data}) => {
                    state.users = data
                })
        },
        getCurrentUserFromDb ({state}, userId) {
            axios.get('./users/' + userId)
                .then(({data}) => {
                    state.currentUser = data
                })
        },

        /*addGetChat({dispatch}, data) {
            if (data !== undefined) {
                return dispatch('addChatToDb', data);
            }

            return dispatch('getChatsFromDb');
        },*/

        getChatsFromDb ({state}) {
            state.chatsIsLoading = true;
            return axios.get('./chats')
                .then(({data}) => {
                    state.chatList = data
                })
                .finally(() => {
                    state.chatsIsLoading = false;
                });
        },

        addChatToDb({actions}, objNewChat) {
            return axios.post('./chats', objNewChat);
        }
    }
}
