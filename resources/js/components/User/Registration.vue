<template>
    <div class="p-4 d-flex align-items-center justify-content-center row">
        <form class="col-lg-4 col-sm-12 border-1 border-light border p-2">
            <h1 class="text-center">Register form</h1>
            <div class="mb-3">
                <label for="name" class="form-label">Your name</label>
                <input v-model="name" type="text" name="name" class="form-control" id="name" placeholder="Your name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input v-model="email" autocomplete="off" type="email" name="email" class="form-control" id="email" placeholder="Your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Your password</label>
                <input v-model="password" type="password" class="form-control" id="password" placeholder="Your password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm password</label>
                <input v-model="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm password">
            </div>
            <p class="text-danger" v-if="error">{{error}}</p>
            <div class="d-flex justify-content-center">
                <input @click.prevent="store" type="submit" value="Register" class="btn btn-primary">
            </div>
            <p class="pt-2 text-center">Or <router-link v-if="!access_token" :to="{ name: 'user.login' }" >login</router-link></p>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Registration",

        data() {
            return {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                error: '',
                access_token: ''
            }
        },

        mounted() {
            this.access_token = localStorage.getItem('access_token');
        },

        methods: {
            store() {
                axios.post('/api/users', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                }).then( result => {
                    localStorage.setItem('access_token', result.data.access_token);
                    this.$router.push({name : 'main.index'});
                }).catch(error => {
                    this.error = error.response.data.message;
                });
            }
        }
    }
</script>

<style scoped>

</style>
