<template>
    <div>
        <h1>Location Type Page</h1>
        <b-button to="/admin/locations/types/create" variant="primary">Add a Type</b-button>
        <b-table class="mt-3"
                 striped hover
                 v-if="types"
                 :items="types">
            <template slot="name" slot-scope="row">
                <a :href="'/admin/locations/types/' + row.item.id " class="link">{{ row.value }}</a>
            </template>

        </b-table>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                types: 'locations/types'
            })
        },

        mounted() {
            this.$axios.get('/location/types')
                .then(response => {
                    this.setTypes({types: response.data.data});
                });
        },

        methods: {
            ...mapActions({
                setTypes : 'locations/setTypes'
            }),
        }
    }
</script>