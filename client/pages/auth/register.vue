<template>
    <div class="center-screen">
        <b-card header="Sign Up"
                header-text-variant="dark"
                header-tag="header"
                header-bg-variant="light"
                style="max-width: 400px;">
            <div class="card-body">
                <b-form @submit="onSubmit">
                    <b-form-group id="userName"
                                  label="Username:"
                                  label-for="userName">
                        <b-form-input id="userName"
                                      type="text"
                                      :state="isEmpty(errors.name)"
                                      v-model="form.name">
                        </b-form-input>
                        <b-form-invalid-feedback v-if="errors.name" id="userName">
                            {{ errors.name[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
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
                    <b-form-group id="userPasswordConfirm"
                                  label="Password Confirmation:"
                                  label-for="userPasswordConfirm">
                        <b-form-input id="userPasswordConfirmation"
                                      type="password"
                                      v-model="form.password_confirmation">
                        </b-form-input>
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
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null
                }
            }
        },

        methods: {
            /**
             * Is validation needed
             */
            isEmpty(value) {
                return (value === undefined) ? value : false;
            },

            /**
             * registers the User and logs the User in
             * @param event
             * @return {Promise.<void>}
             */
            async onSubmit(event) {
                event.preventDefault();
//                await this.$auth.register({
//                    data: this.form
//                });
                await this.$axios.post('auth/register', this.form);

                await this.$auth.login({
                    data: {
                        email: this.form.email,
                        password: this.form.password
                    }
                });

                this.$router.push('/');
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