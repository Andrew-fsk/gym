<template>
    <div class="p-4 d-flex align-items-center justify-content-center row">
        <form class="col-lg-4 col-sm-12 border-1 border-light border p-2">
            <h1 class="text-center">Login form</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input v-model="email" type="email" class="form-control" id="email" placeholder="Your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input v-model="password" type="password" class="form-control" id="password" placeholder="Your password">
            </div>
            <p class="text-danger" v-if="error">{{error}}</p>
            <div class="d-flex justify-content-center">
                <button @click.prevent="login" type="submit" class="btn btn-primary">Login</button>
            </div>
            <p class="pt-2 text-center">Or <router-link v-if="!access_token" :to="{ name: 'user.registration' }" >register</router-link></p>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Login",
        data() {
            return {
                email: '',
                password: '',
                access_token: '',
                error: '',
            }
        },

        mounted() {
            this.access_token = localStorage.getItem('access_token');
        },

        methods: {
            login() {
                axios.post('/api/auth/login', {email: this.email, password: this.password})
                .then(result => {
                    localStorage.setItem('access_token', result.data.access_token);
                    this.$router.push({name:'main.index'});
                }).catch(error => {
                    this.error = error.response.data.error;
                });
            }
        }
    }
</script>

<style scoped>

</style>
