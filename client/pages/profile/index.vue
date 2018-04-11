<template>
    <div>
        <b-row>
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
        }
    }
</script>