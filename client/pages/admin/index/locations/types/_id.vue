<script>
    import TypesForm from '../../../../../components/maps/TypesForm.vue';

    export default {
        extends: TypesForm,

        mounted() {;
            this.$axios.get('/location/types/' + this.$route.params.id + '/show')
                .then(response => {
                    this.form = {
                        name: response.data.data.name,
                        description: response.data.data.description,
                        start: this.createDate(response.data.data.start),
                        end: this.createDate(response.data.data.end)
                    };
                    console.log(response.data.data)
                });
        },

        methods: {


            /**
             * creates a new location type
             */
            onSubmit(event) {
                event.preventDefault();
                this.$axios.put('/admin/location-types/' + this.$route.params.id, this.form)
                    .then(() => this.$router.push('/admin/locations/types'));
            },

            createDate(date) {
                let dateObj = new Date();
                return dateObj.toDateString(date);
            }
        }
    }

</script>