<template>
    <fade-out-animation>
        <div class="message-container" v-if="showMessage">
            <div :class="classes">
                <button type="button"
                        class="close pull-right"
                        @click="close()">&times;</button>
                <strong>{{ title }}:</strong> {{ message }}
            </div>
        </div>
    </fade-out-animation>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {

        data : function() {
            return {
                showMessage : false,
                message: null,
                type: null,
                title: null
            }
        },

        computed: {
            classes() {
                return ['alert', 'alert-' + this.type]
            },

            ...mapGetters({
                success :  'messages/success',
                error :  'messages/error',
                info : 'messages/info',
                warning : 'messages/warning',
            })
        },

        watch: {
            success: function(message) {
                this.successMessage(message);
            },

            error: function(error) {
                this.errorMessage(error);
            },

            info: function(error) {
                this.errorMessage(error);
            },

            warning: function(error) {
                this.errorMessage(error);
            }
        },

        methods: {

            /**
             * opens the message
             * @return void
             */
            open() {
                this.showMessage = true;
                setTimeout(() => this.showMessage = false, 5000);
            },

            /**
             * closes the message
             * @return void
             */
            close() {
                this.showMessage = false;
            },

            /**
             * displays a success message
             * @param message
             */
            successMessage(message) {
                this.message = message;
                this.type = 'success';
                this.title = 'Success';
                this.open();
            },

            /**
             * displays an error message
             * @param message
             */
            errorMessage(message) {
                this.message = message;
                this.type = 'danger';
                this.title = 'Error';
                this.open();
            }
        }
    }
</script>