<template>
    <div class="center-screen">
        <b-card header="Login Form"
                header-text-variant="dark"
                header-tag="header"
                header-bg-variant="light"
                style="max-width: 400px;">
            <div class="card-body">
                <b-form @submit="onSubmit">
                    <b-form-group id="userEmail"
                                  label="Email Address:"
                                  label-for="userEmail">
                        <b-form-input id="userEmail"
                                      type="email"
                                      :state="isEmpty(errors.email)"
                                      v-model="form.email">
                        </b-form-input>
                        <b-form-invalid-feedback v-if="errors.email" id="userEmail">
                            {{ errors.email[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group id="userPassword"
                                  label="Password:"
                                  label-for="userPassword">
                        <b-form-input id="userPassword"
                                      type="password"
                                      :state="isEmpty(errors.password)"
                                      v-model="form.password">
                        </b-form-input>
                        <b-form-invalid-feedback v-if="errors.password" id="userPassword">
                            {{ errors.password[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
            </div>
        </b-card>

    </div>
</template>

<script>
    export default {
        middleware: 'guest',
        data : function() {
            return {
                form: {
                    email: null,
                    password: null
                }
            }
        },

        methods: {
            isEmpty(value) {
                return (value === undefined) ? value : false;
            },

            /**
             * submit form
             * @param event
             * @return {Promise.<void>}
             */
            async onSubmit(event) {
                event.preventDefault();
                await this.$auth.login({
                    data: this.form
                })
            }
        }
    }
</script>

<style>
    .center-screen {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10%;
    }
</style>