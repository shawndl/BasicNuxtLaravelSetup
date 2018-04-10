import Vue from 'vue'
import { mapActions } from 'vuex'

const Messages = {
    install (Vue, options) {
        Vue.mixin({
            methods: {
                ...mapActions({
                    setSuccess: 'messages/setSuccess',
                    setError: 'messages/setError',
                })
            }
        })
    }
};

Vue.use(Messages);