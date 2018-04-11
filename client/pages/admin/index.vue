<template>
    <div>
        <b-row>
            <b-col>
                <admin-side-bar></admin-side-bar>
            </b-col>
            <b-col cols="9">
                <b-container fluid>
                    <nuxt-child/>
                </b-container>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import AdminSideBar from '../../components/admin/layout/AdminSideBar.vue';
    export default {
        middleware: ['auth', 'admin'],
        components: {
            AdminSideBar
        }
    }
</script>