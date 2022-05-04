<template>
    <div>
        <div class="tab-content list-group list-group-flush" id="nav-tabContent">
            <div v-for="message in messages" :key="message.id" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ message.user_fullname }}</h5>
                    <small class="text-muted">{{ message.formatted_date }}</small>
                </div>
                <p class="mb-1">{{ message.text }}</p>
            </div>
        </div>
        <form @submit.prevent="submit">
            <div class="input-group position-absolute bottom-0" style="width: 66.6%">
                <input
                    type="text"
                    class="form-control"
                    placeholder="write a message..."
                    aria-label="Recipient's username"
                    aria-describedby="button-addon2"
                    name="text"
                    v-model="messageText"
                >
                <button class="btn btn-outline-success" type="submit" id="button-addon2">send</button>
            </div>
        </form>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    data() {
        return {
            'messageText': '',
        }
    },

    computed: {
        ...mapGetters([
            'messages',
            'messagesIsLoading',
            'users',
            'currentUser',
            'activeChat',
        ]),
    },

    methods: {
        ...mapActions([
            'addMessageToDb',
            'getMessagesFromDb',
        ]),
        submit() {
            this.addMessageToDb({
                'chat_id': this.activeChat.id,
                'text': this.messageText,
                'user_id': this.currentUser.id
            })
            this.messageText = ''
            this.getMessagesFromDb()
        }
    },

    created() {
        this.getMessagesFromDb()
        let self = this
        setInterval(function () {
            self.getMessagesFromDb()
        }, 5000)
    }
}
</script>
