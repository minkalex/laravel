export default {
    state: {
        users: [],
        currentUser: {},
        chatList: []
    },
    mutations: {
        addChat(state, objChat) {
            state.chatList.unshift(objChat)
        }
    },
    getters: {
        users(state) {
            return state.users;
        },
        currentUser(state) {
            return state.currentUser;
        },
        chats(state) {
            return state.chatList;
        },
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
        updateChats (context, objNewChat) {
            console.log(objNewChat)
            axios.post('./chats', objNewChat)
            .then(function (response) {
                console.log(response);
                //this.getChatsFromDb
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        getChatsFromDb ({state}) {
            axios.get('./chats')
                .then(({data}) => {
                    state.chatList = data
                })
        },
    }
}
