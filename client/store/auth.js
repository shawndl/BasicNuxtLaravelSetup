/**
 * globally defined getters
 * @type {{authenticated: ((state)), user: ((state))}}
 */
export const getters = {
    authenticated (state) {
        return state.loggedIn
    },
    user (state) {
        return state.user
    }
};

export const mutations = {
    SET_USER (state, user) {
        state.user = user;
    }
};

export const actions = {
    setUser ({ commit }, user) {
        commit('SET_USER', user);
    }
};