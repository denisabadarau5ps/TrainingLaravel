<template>
    <div class="login-container">
        <h1>Admin login</h1>
        <form
            method="post"
            @submit.prevent="login"
        >
            <input type="hidden" name="_token" :value="csrf">
            <label for="username">Username</label>
            <input
                v-model="username"
                type="text"
                id="username"
                name="username"
            >
            <br>
            <span class="errors">{{ usernameError }}</span>
            <br>
            <label for="password">Password</label>
            <input
                v-model="password"
                type="password"
                id="password"
                name="password"
            >
            <br>
            <span class="error">{{ passwordError }}</span>
            <br>
            <input
                type="submit"
                value="Login">
        </form>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            username: '',
            password: '',
            usernameError: '',
            passwordError: '',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    methods: {
        async login() {
            axios.post(
                'api/login',
                {
                    'username': this.username,
                    'password': this.password,
                })
            .then(() => {
                this.$router.push('products');
            })
            .catch(error => {
                console.log(error);
                this.usernameError = error.response.data.error.username[0];
                this.passwordError = error.response.data.error.password[0];
            });
        },
    }
}
</script>

<style scoped>
    .login-container {
        margin: auto;
        width: 20%;
        border: 3px solid black;
        padding: 30px;
        text-align: center;
    }
    .errors{
        color:red;
    }
</style>
