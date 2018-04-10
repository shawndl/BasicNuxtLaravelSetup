<template>
    <div>
        <b-row class="text-center">
            <b-col>
                <profile-side-bar></profile-side-bar>
            </b-col>
            <b-col cols="9">
                <nuxt-child/>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import ProfileSideBar from '../../components/profile/layout/ProfileSideBar';
    export default {
        middleware: 'auth',
        components: {
            ProfileSideBar
        },

        mounted() {
            this.setSuccess('Good job in that thing that you did!');
        }
    }
</script>