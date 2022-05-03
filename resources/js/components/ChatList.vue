<template>
    <div>
        <create-chat-button :user-from-blade="this.UserFromBlade"></create-chat-button>
        <div v-if="chatsIsLoading">Loading....</div>
        <div class="list-group list-group-flush" id="list-tab" role="tablist" v-else>
            <a v-for="(chat, index) in chats"
               class="list-group-item list-group-item-action"
               id="list-home-list"
               data-bs-toggle="list"
               :href="'#list-chat-' + chat.id"
               role="tab"
               :aria-controls="'list-chat-' + chat.id"
               :key="chat.id"
            >
                {{ chat.title }}
            </a>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import CreateChatButton from "./CreateChatButton";
export default {
    data() {
        return {
            active: ''
        }
    },
    props: [
        'UserFromBlade',
    ],

    computed: {
        ...mapGetters([
            'chats',
            'chatsIsLoading'
        ]),
    },

    components: {
        CreateChatButton
    },

    methods: {
        ...mapActions([
            'getChatsFromDb',
        ]),
        active (index) {
            if (0 === index) {
                return 'active'
            } else {
                return ''
            }
        },
    },

    created() {
        this.getChatsFromDb();
    }
}
</script>
