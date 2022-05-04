<template>
    <div class="row" style="flex-wrap: unset; margin: unset;" id="vue-users-menu">
        <div class="list-group col-4 list-group-flush" style="padding: unset" id="chat-block">
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
                <a v-for="(chat, index) in chats"
                   :class="'list-group-item list-group-item-action' + checkChatActivation(chat.id)"
                   id="list-home-list"
                   data-bs-toggle="list"
                   :href="'#list-chat-' + chat.id"
                   role="tab"
                   :aria-controls="'list-chat-' + chat.id"
                   :key="chat.id"
                   v-on:click="setActiveChat(index)"
                >
                    {{ chat.title }}
                </a>
            </div>
        </div>
        <div class="col-8" style="padding: unset">
            <messages-list></messages-list>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters, mapState} from 'vuex'
import CreateChatButton from "./CreateChatButton";
import MessagesList from "./MessagesList";

export default {
    props: [
        'UserFromBlade',
    ],

    computed: {
        ...mapGetters([
            'chats',
            'chatsIsLoading',
            'activeChat',
        ]),
    },

    components: {
        MessagesList,
        CreateChatButton
    },

    methods: {
        ...mapActions([
            'getChatsFromDb',
            'getMessagesFromDb',
            'updateActiveChat'
        ]),
        setActiveChat(index) {
            this.updateActiveChat(this.chats[index])
            this.getMessagesFromDb()
        },
        checkChatActivation(chatId) {
            if (this.activeChat !== undefined && chatId === this.activeChat.id) {
                return ' active'
            }
            return ''
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
    #chat-block {
        border-right: 2px;
    }
</style>
