<template>
    <div class="row" style="flex-wrap: unset; margin: unset;" id="vue-users-menu">
        <div class="list-group col-2 list-group-flush" style="padding: unset" id="chat-block">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="pencil" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd"
                          d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </symbol>
            </svg>
            <create-chat-button :user-from-blade="this.UserFromBlade"></create-chat-button>
            <div class="list-group list-group-flush" id="list-tab" role="tablist">
                <div v-for="(chat, index) in chats"
                     :class="'list-group-item ' + checkChatActivation(chat.id)"
                     id="list-home-list"
                     data-bs-toggle="list"
                     role="tab"
                     :aria-controls="'list-chat-' + chat.id"
                     :key="chat.id"
                     v-on:click="setActiveChat(index)"
                >
                    <div class="d-flex justify-content-between mb-2">
                        <h5>{{ chat.title }}</h5>
                        <!--<span class="badge bg-danger rounded-pill">14</span>-->
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button
                            type="button"
                            class="btn btn-outline-dark"
                            v-if="chat.created_by === currentUser.id"
                            data-bs-toggle="offcanvas"
                            :data-bs-target="'#editChat' + chat.id"
                            :aria-controls="'editChat' + chat.id"
                            @click="getUsers(index)"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-trash"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                            <span class="visually-hidden">Button</span>
                        </button>
                        <!-- Modal -->
                        <div
                            class="offcanvas offcanvas-start text-black"
                            tabindex="-1"
                            :id="'editChat' + chat.id"
                            :aria-labelledby="'editChat' + chat.id + 'Label'"
                            v-if="chat.created_by === currentUser.id"
                        >
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title " :id="'editChat' + chat.id + 'Label'">
                                    {{ chat.title }}
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close text-reset"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Close"
                                >
                                </button>
                            </div>
                            <div class="offcanvas-body">
                                <form @submit.prevent="editChat(chat.id)">
                                    <div class="form-floating mb-4">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="floatingInput"
                                            placeholder="chat title"
                                            v-model="chatTitle"
                                        >
                                        <label for="floatingInput">chat title</label>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item active" aria-current="true">participants</li>
                                        <li v-for="user in users" class="list-group-item">
                                            <input
                                                class="form-check-input me-1"
                                                type="checkbox"
                                                :value="user.id"
                                                v-model="checkedUsers"
                                                :disabled="user.id === currentUser.id"
                                            >
                                            {{ user.last_name + ' ' + user.name }}
                                        </li>
                                    </ul>
                                    <div class="d-flex justify-content-end">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-dark mt-4"
                                            data-bs-dismiss="offcanvas">save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <button
                            type="button"
                            class="btn btn-outline-dark"
                            v-if="chat.created_by !== currentUser.id"
                            @click="leaveChat(index)"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-trash"
                                viewBox="0 0 16 16"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-pencil"
                                    viewBox="0 0 16 16"
                                >
                                    <path fill-rule="evenodd"
                                          d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                                    <path fill-rule="evenodd"
                                          d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                                </svg>
                            </svg>
                            <span class="visually-hidden">Button</span>
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-dark"
                            v-if="chat.created_by === currentUser.id"
                            @click="deleteChat(index)"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-trash"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                            </svg>
                            <span class="visually-hidden">Button</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="position-absolute bottom-0 p-3" style="width: 16%">
                <hr>
                <div class="dropdown ">
                    <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle"
                       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong>{{ currentUser.last_name + ' ' + currentUser.name}}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" :href="'/users/' + currentUser.id+ '/edit'">Edit</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/logout">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="b-example-divider"></div>
        <div class="col-10" style="padding: unset; width: 82%">
            <messages-list></messages-list>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters, mapState} from 'vuex'
import CreateChatButton from "./CreateChatButton";
import MessagesList from "./MessagesList";

export default {
    data() {
        return {
            'checkedUsers': [],
            'chatTitle': '',
        }
    },

    props: [
        'UserFromBlade',
    ],

    computed: {
        ...mapGetters([
            'chats',
            'chatsIsLoading',
            'activeChat',
            'currentUser',
            'users'
        ]),
    },

    components: {
        MessagesList,
        CreateChatButton,
    },

    methods: {
        ...mapActions([
            'getChatsFromDb',
            'getMessagesFromDb',
            'updateActiveChat'
        ]),
        setActiveChat(index = undefined) {
            if (undefined === index) {
                this.updateActiveChat({})
            } else {
                this.updateActiveChat(this.chats[index])
            }
            this.getMessagesFromDb()
        },
        checkChatActivation(chatId) {
            if (this.activeChat !== undefined && chatId === this.activeChat.id) {
                return ' active'
            }
            return ''
        },
        getUsers(chatIndex) {
            let self = this
            this.checkedUsers = []
            this.users.forEach(function (userFromDb) {
                self.chats[chatIndex].users.forEach(function (userFromChat) {
                    if (userFromDb.id === userFromChat.id) {
                        self.checkedUsers.push(userFromDb.id)
                    }
                })
            })
            this.chatTitle = this.chats[chatIndex].edited ? '' : this.chats[chatIndex].title
        },
        editChat(chatId) {
            let self = this
            axios.patch('./chats/' + chatId, {usersId: this.checkedUsers, title: this.chatTitle, action: 'edit'})
                .then(function () {
                    self.getChatsFromDb()
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        leaveChat(chatIndex) {
            if (window.confirm("do you really want to leave the chat:\n\n" + this.chats[chatIndex].title + "\n\n?")) {
                let self = this
                axios.patch('./chats/' + this.chats[chatIndex].id, {userId: this.currentUser.id, action: 'leave'})
                    .then(function () {
                        self.getChatsFromDb()
                        self.setActiveChat()
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            }
        },
        deleteChat(chatIndex) {
            if (window.confirm("do you really want to delete the chat:\n\n" + this.chats[chatIndex].title + "\n\n?")) {
                let self = this
                axios.delete('./chats/' + this.chats[chatIndex].id)
                    .then(function () {
                        self.getChatsFromDb()
                        self.setActiveChat()
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            }
        }
    },

    created() {
        this.getChatsFromDb()
        let self = this
        setInterval(function () {
            self.getChatsFromDb()
        }, 30000)
    }
}
</script>

<style>
body {
    min-height: 100vh;
    min-height: -webkit-fill-available;
}

html {
    height: -webkit-fill-available;
}

main {
    flex-wrap: nowrap;
    height: 100vh;
    height: -webkit-fill-available;
    max-height: 100vh;
    overflow-x: auto;
    overflow-y: hidden;
}

.b-example-divider {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
    background-color: rgba(0, 0, 0, .1);
    border: solid rgba(0, 0, 0, .15);
    border-width: 1px 0;
    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
}

#chat-block {
    border-right: 2px;
}

.badge {
    line-height: unset;
}
</style>
