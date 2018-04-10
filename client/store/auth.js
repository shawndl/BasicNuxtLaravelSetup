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
