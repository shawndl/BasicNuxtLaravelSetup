<script>
    export default {
        methods: {
            /**
             * did validation return an error
             * @param value
             * @return {boolean}
             */
            isEmpty(value) {
                return (value === undefined) ? value : false;
            },
        }
    }
</script>