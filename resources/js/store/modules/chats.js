export default {
    state: {
        users: [],
        currentUser: {},
        chatsIsLoading: false,
        messagesIsLoading: false,
        chatList: [],
        messagesList: [],
        activeChat: {}
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
        messages: state => state.messagesList,
        chatsIsLoading: state => state.chatsIsLoading,
        messagesIsLoading: state => state.messagesIsLoading,
        activeChat: state => state.activeChat,
    },

    actions: {
        getUsersFromDb({state}) {
            axios.get('./users')
                .then(({data}) => {
                    state.users = data
                })
        },
        getCurrentUserFromDb({state}, userId) {
            axios.get('./users/' + userId)
                .then(({data}) => {
                    state.currentUser = data
                })
        },

        getChatsFromDb({state}) {
            state.chatsIsLoading = true;
            return axios.get('./chats')
                .then(({data}) => {
                    let chats = data
                    data.forEach(function (chat, index) {
                        if (0 === chat.title.length) {
                            return axios.get('./chats/' + chat.id + '/participants')
                                .then(({data}) => {
                                    let foundUser = data.filter(function (user) {
                                        return user.id !== state.currentUser.id
                                    })
                                    chats[index].title = foundUser[0].last_name + ' ' + foundUser[0].name
                                    chats[index].edited = true
                                })
                        }
                    })
                    state.chatList = chats
                })
                .finally(() => {
                    state.chatsIsLoading = false;
                });
        },

        addChatToDb({actions}, objNewChat) {
            return axios.post('./chats', objNewChat)
                .then(({data}) => {
                    console.log(data)
                });
        },

        getMessagesFromDb({state}) {
            if (Object.keys(state.activeChat).length > 0) {
                state.messagesIsLoading = true;
                return axios.get('./messages?chat_id=' + state.activeChat.id)
                    .then(({data}) => {
                        state.messagesList = data
                    })
                    .finally(() => {
                        state.messagesIsLoading = false;
                    });
            }
        },

        addMessageToDb({actions}, objNewMessage) {
            return axios.post('./messages', objNewMessage)
        },

        updateActiveChat({state}, objChat) {
            state.activeChat = objChat
        },

        updateMessageInDb({state}, objMessage) {
            return axios.patch('./messages/' + objMessage.id, {text: objMessage.text});
        },

        deleteMessageFromDb({state}, messageId) {
            return axios.delete('./messages/' + messageId);
        },
    }
}
