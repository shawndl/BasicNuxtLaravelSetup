<template>
    <b-container fluid>
        <b-form @submit="onSubmit">
            <b-card header="User Profile"
                    header-text-variant="dark"
                    header-tag="header"
                    header-bg-variant="light"
                    style="max-width: 600px;">
                <div class="card-body">
                    <b-row class="my-1">
                        <b-col sm="3">
                            <label for="name">Name: </label>
                        </b-col>
                        <b-col sm="9">
                            <b-form-input id="name"
                                          type="text"
                                          name="name"
                                          v-model="form.name"
                                          :state="isEmpty(errors.name)"
                                          placeholder="Please select a username!"
                                          required>
                            </b-form-input>
                            <b-form-invalid-feedback v-if="errors.name" id="name">
                                {{ errors.name[0] }}
                            </b-form-invalid-feedback>
                        </b-col>
                    </b-row>
                    <b-row class="my-1">
                        <b-col sm="3">
                            <label for="email">Email: </label>
                        </b-col>
                        <b-col sm="9">
                            <b-form-input id="email"
                                          type="email"
                                          name="email"
                                          :state="isEmpty(errors.email)"
                                          v-model="form.email"
                                          placeholder="Please enter your email!"
                                          required>
                            </b-form-input>
                            <b-form-invalid-feedback v-if="errors.email" id="email">
                                {{ errors.email[0] }}
                            </b-form-invalid-feedback>
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
    import { mapActions } from 'vuex'

    export default  {
        extends: AbstractForm,
        middleware: 'auth',
        data : function() {
            return {
                form: {
                    name: '',
                    email: ''
                }
            }
        },

        created() {
            this.form.name = this.user.name;
            this.form.email = this.user.email;
        },

        methods: {
            ...mapActions({
                setUser: 'auth/setUser'
            }),

            /**
             * submits a form to update the index information
             * @param event
             * @return void
             */
            onSubmit(event) {
                event.preventDefault();
                this.$axios.post('profile', this.form).then(() => {
                    this.setUser(this.form);
                });
            }
        }
    }
</script>