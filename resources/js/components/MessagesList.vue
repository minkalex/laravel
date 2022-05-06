<template>
    <div>
        <div class="tab-content list-group list-group-flush" id="nav-tabContent">
            <div v-for="(message, index) in messages" :key="message.id" class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ message.user_fullname }}</h5>
                    <small class="text-muted">{{ message.formatted_date }}</small>
                </div>
                <p class="mb-1" ref="messageText">{{ message.text }}</p>
                <figcaption class="blockquote-footer mt-1" v-if="message.replied_to">
                    {{ getRepliedMessage(message.replied_to, 'text') }} by <cite
                    title="Source Title">{{ getRepliedMessage(message.replied_to, 'user_fullname') }}</cite>
                </figcaption>
                <div class="d-flex justify-content-end">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-dark" v-if="message.user_id === currentUser.id"
                                data-bs-toggle="modal" :data-bs-target="'#editMessage' + message.id">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                            <span class="visually-hidden">Button</span>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" :id="'editMessage' + message.id" tabindex="-1" aria-hidden="true"
                             v-if="message.user_id === currentUser.id">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form @submit.prevent="editMessage(index)">
                                        <div class="modal-body">
                                            <textarea class="form-control" :id="'editedMessage' + index">{{ message.text }}</textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                close
                                            </button>
                                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-dark" v-if="message.user_id !== currentUser.id"
                                @click="replyMessage(index)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash" viewBox="0 0 16 16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                                </svg>
                            </svg>
                            <span class="visually-hidden">Button</span>
                        </button>
                        <button type="button" class="btn btn-outline-dark" v-if="message.user_id === currentUser.id"
                                @click="deleteMessage(index)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash" viewBox="0 0 16 16">
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
        </div>
        <form @submit.prevent="addMessage">
            <div class="input-group position-absolute bottom-0" style="width: 82%">
                <textarea class="form-control" placeholder="write a message..." name="text" v-model="messageText"
                          ref="inputMessage"></textarea>
                <!--<input
                    type="text"
                    class="form-control"
                    placeholder="write a message..."
                    aria-label="Recipient's username"
                    aria-describedby="button-addon2"
                    name="text"
                    v-model="messageText"
                >-->
                <button class="btn btn-outline-dark" type="submit" id="button-addon2">send</button>
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
            'repliedTo': null,
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
            'updateMessageInDb',
            'deleteMessageFromDb',
        ]),
        addMessage() {
            let objNewMessage = {}
            if (null !== this.repliedTo) {
                objNewMessage.text = this.messageText.replace(this.repliedTo.text + '\n***\n', '')
                objNewMessage.replied_to = this.repliedTo.id
            } else {
                objNewMessage.text = this.messageText
            }
            objNewMessage.chat_id = this.activeChat.id
            objNewMessage.user_id = this.currentUser.id
            this.addMessageToDb(objNewMessage)
            this.messageText = ''
            this.repliedTo = null
            this.getMessagesFromDb()
        },
        editMessage(index) {
            this.updateMessageInDb({
                id: this.messages[index].id,
                text: document.querySelector('#editedMessage' + index).value,
            })
            this.getMessagesFromDb()
        },
        deleteMessage(index) {
            if (window.confirm("Do you really want to delete message:\n\n" + this.messages[index].text + "\n\n?")) {
                this.deleteMessageFromDb(this.messages[index].id)
                this.getMessagesFromDb()
            }
        },
        replyMessage(index) {
            this.messageText = this.messages[index].text + '\n***\n'
            this.repliedTo = this.messages[index]
            this.$refs.inputMessage.focus()
        },
        getRepliedMessage(repliedToId, neededParameter = undefined) {
            let message = this.messages.filter(function (message) {
                return message.id === repliedToId
            })
            if (undefined === neededParameter) {
                return message
            } else {
                message = message[0]
                return message[neededParameter]
            }
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
