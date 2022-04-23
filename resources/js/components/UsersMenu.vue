<template>
    <!--@foreach ($objUsers as $objUser)
    <a href="./user/{{ $objUser->id }}"
       class="list-group-item list-group-item-action">{{ $objUser->full_name }}@if($objUser->id === \Illuminate\Support\Facades\Auth::id())
        (you) @endif</a>
    @endforeach-->
    <p>asdasdasdasdasasads</p>
</template>

<script>
export default {
    props: [
        'users',
    ],
    mounted() {
        console.log(this.users)
        console.log('sdasdasd')
    }
}
</script>

<style scoped>

</style>
