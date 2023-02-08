<template>
    <div class="p-4 d-flex align-items-center justify-content-center row">
        <form class="col-lg-4 col-sm-12 border-1 border-light border p-2">
            <h1 class="text-center">Settings</h1>
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
            <p class="text-success" v-if="success">{{success}}</p>
            <div class="d-flex justify-content-center">
                <input @click.prevent="update" type="submit" value="Save" class="btn btn-primary">
            </div>
        </form>
    </div>
</template>

<script>
    import api from "../../api";
    export default {
        name: "Edit.vue",
        data() {
            return {
                name: '',
                email: '',
                error: '',
                password: '',
                password_confirmation: '',
                success: ''
            }
        },

        mounted() {
            this.setUserInfo();
        },

        methods:{
            setUserInfo(){
                api.post('/api/auth/me').then( result => {
                    this.name = result.data.name;
                    this.email = result.data.email;
                })
            },
            update(){
                this.success = '';
                this.error = '';
                api.patch(' api/auth/user/update', {
                    name : this.name,
                    email : this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                }).then( result => {
                    this.name = result.data.name;
                    this.email = result.data.email;
                    this.password = this.password_confirmation = '';
                    this.success = 'Update successful'
                }).catch(error => {
                    this.error = error.response.data.message;
                });
            }
        }

    }
</script>

<style scoped>

</style>
