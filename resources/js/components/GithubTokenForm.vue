<template>
    <div class="card mb-3">
        <div class="card-header">GitHub Connection</div>
        <div class="card-body">
            <p>
                Enter your GitHub token below to access your repositories.<br />
                No token?
                <a href="https://docs.github.com/en/free-pro-team@latest/github/authenticating-to-github/creating-a-personal-access-token" target="_blank">
                    Click here
                </a>
                to learn how to make a token.
            </p>
            <b-form @submit.prevent="submit">
                <b-form-group
                    id="tokenInputLabel"
                    label="GitHub Token:"
                    label-for="tokenInput"
                >
                    <b-form-input
                        id="tokenInput"
                        v-model="form.token"
                        type="text"
                        required
                        placeholder="Paste token here"
                    >
                    </b-form-input>
                </b-form-group>
                <b-button
                    type="submit"
                    variant="primary"
                    :disabled="saving"
                >
                    {{saving ? 'Saving...' : 'Save Token'}}
                </b-button>
            </b-form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                saving: false,
                form: {
                    token: this.user.actual_github_token,
                }
            };
        },
        methods: {
            submit(e) {
                this.saving = true;
                this.axios.post('update-github-token', this.form).then(response => {
                    this.saving = false;
                    this.form.token = response.data.user.actual_github_token;
                    Object.assign(this.user, response.data.user);
                }).catch(error => {
                    this.saving = false;
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
