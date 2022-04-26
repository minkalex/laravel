<template>
    <div class="list-group list-group-flush">
        <a v-for="user in usersList" :href="user.href" class="list-group-item list-group-item-action">{{ user.full_name }}</a>
    </div>
</template>

<script>
export default {
    data() {
        return {
            usersList: this.buildMenu()
        }
    },
    props: [
        'users',
    ],
    methods: {
        buildMenu() {
            let list = []
            this.users.forEach((user) => {
                list.push({href: './user/' + user.id, full_name: user.last_name + ' ' + user.name})
            })
            console.log(list)
            return list
        }
    }
}
</script>

<style scoped>

</style>
