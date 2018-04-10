<template>
  <div>
    <top-nav-bar></top-nav-bar>
    <messages></messages>
    <b-container fluid>
      <div style="margin-top: 20px">
        <nuxt/>
      </div>
    </b-container>
  </div>
</template>

<script>
  import TopNavBar from './partials/header/TopNavBar';
  import Messages from './partials/header/Messages'
    export default {
        components: {
            TopNavBar, Messages
        }
    }
</script>

<style>

</style>