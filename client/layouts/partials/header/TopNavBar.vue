<template>
    <b-navbar toggleable="md" type="light" variant="info">

        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

        <b-navbar-brand to="/">Foraging Application</b-navbar-brand>

        <b-collapse is-nav id="nav_collapse">

            <b-navbar-nav>
                <b-nav-item to="/locations">Locations</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-item-dropdown right v-if="authenticated">
                    <!-- Using button-content slot -->
                    <template slot="button-content">
                        <em>{{ user.name }}</em>
                    </template>
                    <b-dropdown-item to="/profile">Profile</b-dropdown-item>
                    <b-dropdown-item @click.prevent="logout">Sign Out</b-dropdown-item>
                </b-nav-item-dropdown>
                <b-navbar-nav v-else>
                    <b-nav-item :to="{ name: 'Auth-login' }">Log In</b-nav-item>
                    <b-nav-item :to="{ name: 'Auth-register' }">Register</b-nav-item>
                </b-navbar-nav>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
    export default {
        methods: {
            /**
             * logs the User out
             *
             * @return void
             */
            logout() {
                this.$auth.logout();
            }
        }
    }
</script>