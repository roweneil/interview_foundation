<template>
    <div class="card">
        <div class="card-header">Starred Repositories</div>
        <div class="card-body">
            <div>
                <b-button
                    variant="primary"
                    size="sm"
                    @click="fetchRepos"
                    :disabled="!user.actual_github_token"
                >
                    Fetch List
                </b-button>
            </div>
            <b-list-group v-if="!loading && repos && repos.length">
                <b-list-group-item v-for="repo in repos" :key="repo.id">
                    {{repo.name}}
                </b-list-group-item>
            </b-list-group>
            <span v-else-if="!loading && repos && !repos.length">No starred repos found.</span>
            <span v-else-if="loading">Getting your data...</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                loading: false,
                repos: null,
            };
        },
        methods: {
            fetchRepos() {
                this.loading = true;
                this.axios.get('starred-repos').then(response => {
                    this.repos = response.data.repos;
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                    this.$bvToast.toast(error.response.data.error || "Unknown error occurred.", {
                        title: "Error",
                        autoHideDelay: 5000,
                        appendToast: true,
                    });
                });
            }
        }
    }
</script>
