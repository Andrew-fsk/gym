<template>
    <h1>header</h1>
    <router-link :to="{ name: 'about' }" class="nav-link"
                 active-class="active">about
    </router-link>
</template>

<script>
    export default {
        name: "Header"
    }
</script>

<style scoped>

</style>
