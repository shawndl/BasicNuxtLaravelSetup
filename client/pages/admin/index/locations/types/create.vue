<script>
    import TypesForm from '../../../../../components/maps/TypesForm.vue';

    export default {
        extends: TypesForm,

        methods: {
            /**
             * creates a new location type
             */
            onSubmit(event) {
                event.preventDefault();
                this.$axios.post('/admin/location-types', this.form)
                    .then(() => this.$router.push('/admin/locations/types'));
            }
        }
    }

</script>

