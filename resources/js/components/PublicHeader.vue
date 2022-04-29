<template>
    <div v-if="data.user" class="d-flex justify-content-end mb-3">
        {{ data.user.last_name + ' ' + data.user.name }} [<a :href="items[0].href"
                                                             class="link-success">{{ items[0].title }}</a> / <a
        :href="items[1].href" class="link-success">{{ items[1].title }}</a>]
    </div>
    <div v-else class="d-flex justify-content-end">
        <div class="btn-group mb-5" role="group" aria-label="Basic outlined example">
            <a v-for="item in items" :href="item.href" class="btn btn-outline-success">{{ item.title }}</a>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex'

export default {
    data() {
        return {
            items: []
        }
    },
    props: [
        'data',
    ],
    computed: {
        ...mapGetters([
            'getCurrentUser',
        ]),
    },
    methods: {
        ...mapActions([
            'setNewUser',
        ]),
    },
    mounted() {
        if (null !== this.data.user) {
            this.items = [
                {href: this.data.routes.main + '/users/' + this.data.user.id + '/edit', title: 'Edit'},
                {href: this.data.routes.logout, title: 'Sign out'}
            ]
        } else {
            this.items = [
                {href: this.data.routes.main + '/login', title: 'Login'},
                {href: this.data.routes.main + '/signup', title: 'Sign-up'}
            ]
        }
    }
}
</script>

<style scoped>

</style>
