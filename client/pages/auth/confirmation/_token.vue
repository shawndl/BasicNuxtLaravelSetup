<template>
    <div>

    </div>
</template>

<script>
    export default {
        created() {
            this.verifyToken(this.$route.params.token);
        },

        methods: {
            /**
             * checks if the token is valid
             * @return {Promise.<void>}
             */
            async verifyToken(token) {
                this.$axios.$get('auth/activate/' +  token)
                    .then(response => this.$router.push('login'))
                    .catch(error => console.log(error));
            }
        }
    }
</script>