<template>
    <div>
        <h1>Foraging Locations</h1>
        <b-button-group>
            <b-button>All Locations</b-button>
            <b-button to="/locations/create">Create</b-button>
            <b-button>Your Locations</b-button>
        </b-button-group>
        <nuxt-child/>
    </div>
</template>

<script>
    export default {
        data : function() {
            return {

            }
        },

        mounted() {

        },

        methods: {

        }
    }
</script>