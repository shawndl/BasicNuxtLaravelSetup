<template>
    <b-form @submit="onSubmit">
        <b-card header="Location Types"
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
                                      placeholder="Please select a username!">
                        </b-form-input>
                        <b-form-invalid-feedback v-if="errors.name" id="name">
                            {{ errors.name[0] }}
                        </b-form-invalid-feedback>
                    </b-col>
                </b-row>
                <b-row class="mt-3">
                    <b-col sm="3">
                        <label for="description">Description: </label>
                    </b-col>
                    <b-col>
                        <textarea class="form-control"
                                  id="description"
                                  name="description"
                                  v-model.trim="form.description"
                                  rows="3"
                                  placeholder="Enter a description of the type of location">

                        </textarea>


                        <p class="text-danger" v-if="errors.description">
                            {{ errors.description[0] }}
                        </p>
                    </b-col>
                </b-row>
                <b-row class="mt-3">
                    <b-col cols="3">
                        <label for="start">Season Start: </label>
                    </b-col>
                    <b-col cols="9">
                        <datepicker v-model="form.start" name="start" format="dsu MMM"></datepicker>
                        <p class="text-danger" v-if="errors.start">
                            {{ errors.start[0] }}
                        </p>
                    </b-col>
                </b-row>
                <b-row class="mt-3">
                    <b-col cols="3">
                        <label for="end">Season Ends: </label>
                    </b-col>
                    <b-col cols="9">
                        <datepicker v-model="form.end" name="end" format="dsu MMM"></datepicker>
                        <p class="text-danger" v-if="errors.end">
                            {{ errors.end[0] }}
                        </p>
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
</template>

<script>
    import AbstractForm from '../abstract/AbstractForm.vue';
    import Datepicker from 'vuejs-datepicker';

    export default {
        extends: AbstractForm,

        components: {
            Datepicker
        },

        data : function() {
            return {
                form: {
                    name: null,
                    description: null,
                    start: null,
                    end: null
                }
            }
        }
    }
</script>