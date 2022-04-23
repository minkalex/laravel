<template>

</template>

<script>
export default {
    props: [
        'sessionPostId',
        'sessionCommentId',
        'sessionSubcommentId',
    ],
    mounted() {
        console.log(this.sessionPostId);
        console.log(this.$refs);
    }
}
</script>

<style scoped>

</style>
