export const state = () => ({
    messages: {
        success: '',
        error: '',
        warning: '',
        info: ''
    }
});

export const getters = {
    success (state) {
        return state.messages.success;
    },
    error (state) {
        return state.messages.error;
    },
    warning (state) {
        return state.messages.warning;
    },
    info (state) {
        return state.messages.info;
    }
};

export const mutations = {
    SET_SUCCESS (state, message) {
        state.messages.success = message;
    },
    SET_ERROR (state, message) {
        state.messages.error = message;
    },
    SET_INFO (state, message) {
        state.messages.info = message;
    },
    SET_WARNING (state, message) {
        state.messages.warning = message;
    },
    CLEAR_MESSAGE (state) {
        state.messages = {
            success: '',
            error: '',
            warning: '',
            info: ''
        };
    }
};

export const actions = {
    setSuccess ({ commit }, message) {
        commit('SET_SUCCESS', message);
    },
    setError ({ commit }, message) {
        commit('SET_ERROR', message);
    },
    setWarning ({ commit }, message) {
        commit('SET_WARNING', message);
    },
    setInfo ({ commit }, message) {
        commit('SET_INFO', message);
    },
    clearMessages ({ commit }) {
        commit('CLEAR_MESSAGE');
    }
};