<template>
    <h1>index</h1>
</template>

<script>
    import api from '../api';

    export default {
        name: "Index",
        data() {
            return {
                access_token: null
            }
        },

        mounted() {
            this.getAccessToken()
        },

        updated() {
            this.getAccessToken()
        },

        methods: {
            getAccessToken() {
                this.access_token = localStorage.getItem('access_token');
            },

            logout() {
                api.post('/api/auth/logout')
                    .then(result => {
                        localStorage.removeItem('access_token');
                        this.$router.push({name: 'user.login'})
                    })
            }
        }
    }
</script>

<style scoped>

</style>
