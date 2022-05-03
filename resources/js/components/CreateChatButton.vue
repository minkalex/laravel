<template>
    <div class="btn-group w-100">
            <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false" data-bs-auto-close="outside">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img">
                    <use xlink:href="#pencil"/>
                </svg>
                new chat
            </button>
            <ul class="dropdown-menu">
                <div class="accordion accordion-flush" id="accordionExample">
                    <form @submit.prevent="submit">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    step #1
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">
                                        <li v-for="obUser in otherUsers" class="list-group-item" :key="obUser.id">
                                            <input class="form-check-input me-1"
                                                   type="checkbox" :value="obUser.id" v-model="checkedUsers" :name="obUser.id">
                                            {{ fullName(obUser) }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    step #2
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="chat-title" name="chat-title"
                                               placeholder="chat title" v-model="chatTitle">
                                        <label for="chat-title">chat title</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    step #3
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <button type="submit" class="btn btn-link text-decoration-none link-success">create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </ul>
        </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

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
            'users', 'currentUser'
        ]),
        otherUsers: function () {
            let currentUserId = this.currentUser.id
            return this.users.filter(function (user) {
                return user.id !== currentUserId
            })
        },
    },
    methods: {
        ...mapActions([
            'getUsersFromDb', 'getCurrentUserFromDb', 'addChatToDb', 'getChatsFromDb'
        ]),
        fullName(objUser) {
            return objUser.last_name + ' ' + objUser.name
        },
        submit() {
            this.addChatToDb({
                'usersId': this.checkedUsers,
                'title': this.chatTitle,
                'created_by': this.currentUser.id
            })
            this.getChatsFromDb()
        }
    },
    mounted() {
        this.getUsersFromDb()
        this.getCurrentUserFromDb(this.UserFromBlade.id)
    }
}
</script>
