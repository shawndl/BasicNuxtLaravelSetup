<template>
    <b-container fluid>
        <b-form @submit="onSubmit">
            <b-card header="User Password"
                    header-text-variant="dark"
                    header-tag="header"
                    header-bg-variant="light"
                    style="max-width: 600px;">
                <div class="card-body">
                    <b-row class="mt-2">
                        <b-col sm="4">
                            <label for="current_password" class="float-right">Current Password: </label>
                        </b-col>
                        <b-col sm="8">
                            <b-form-input id="current_password"
                                          type="password"
                                          name="current_password"
                                          v-model="form.current_password"
                                          :state="isEmpty(errors.current_password)"
                                          placeholder="Please enter your current password!">
                            </b-form-input>
                            <b-form-invalid-feedback v-if="errors.current_password" id="userEmail">
                                {{ errors.current_password[0] }}
                            </b-form-invalid-feedback>
                        </b-col>
                    </b-row>
                    <b-row class="mt-2">
                        <b-col sm="4">
                            <label for="password" class="float-right">Password: </label>
                        </b-col>
                        <b-col sm="8">
                            <b-form-input id="password"
                                          type="password"
                                          name="password"
                                          v-model="form.password"
                                          :state="isEmpty(errors.password)"
                                          placeholder="Please enter your new password!">
                            </b-form-input>
                            <b-form-invalid-feedback v-if="errors.password" id="userEmail">
                                {{ errors.password[0] }}
                            </b-form-invalid-feedback>
                        </b-col>
                    </b-row>
                    <b-row class="mt-2">
                        <b-col sm="4">
                            <label for="password_confirmation" class="float-right">Confirm Password: </label>
                        </b-col>
                        <b-col sm="8">
                            <b-form-input id="password_confirmation"
                                          type="password"
                                          name="password_confirmation"
                                          v-model="form.password_confirmation"
                                          :state="isEmpty(errors.password_confirmation)"
                                          placeholder="Please confirm your new password!">
                            </b-form-input>
                        </b-col>
                    </b-row>
                    <b-row class="mt-5">
                        <b-col sm="2" offset="10">
                            <b-button variant="primary" type="submit">
                                Edit
                            </b-button>
                        </b-col>
                    </b-row>
                </div>
            </b-card>
        </b-form>
    </b-container>
</template>

<script>
    import AbstractForm from '../../../components/abstract/AbstractForm.vue';

    export default  {
        extends: AbstractForm,
        data : function() {
            return {
                form: {
                    password: '',
                    current_password: '',
                    password_confirmation: ''
                }
            }
        },

        methods: {
            /**
             * submits a form to update the index information
             * @param event
             * @return void
             */
            onSubmit(event) {
                event.preventDefault();
                this.$axios.post('profile/password', this.form);
            }
        }
    }
</script>