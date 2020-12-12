<template>
    <div>
        <template v-if="user">
            <github-token-form :user="user"></github-token-form>
        </template>
        <template v-else>
            <p>Loading...</p>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: null,
            }
        },
        mounted() {
            this.fetchUser();
        },
        methods: {
            fetchUser() {
                this.axios.get('user').then(response => {
                    this.user = response.data;
                }).catch(error => {
                    // todo: replace with a pretty error
                    alert("There was an error fetching the user.");
                });
            }
        }
    }
</script>
