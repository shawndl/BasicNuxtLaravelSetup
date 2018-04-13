export const state = () => ({
    types: [],

    locations: []
});

export const getters = {
    locations (state) {
        return state.locations;
    },
    types (state) {
        return state.types.types;
    }
};

export const mutations = {
    SET_LOCATIONS (state, locations) {
        state.locations = locations;
    },

    SET_TYPES (state, types) {
        state.types = types;
    },

    ADD_LOCATION (state, location){
        state.locations.push(location)
    },

    ADD_TYPE (state, type){
        state.types.push(type)
    }
};


export const actions = {
    setLocations ({ commit }, locations) {
        commit('SET_LOCATIONS', locations);
    },

    setTypes ({ commit }, location) {
        commit('SET_TYPES', location);
    },

    addLocations({ commit }, location) {
        commit('ADD_LOCATION', locations);
    },

    addType({ commit }, type) {
        commit('ADD_TYPE', locations);
    }
};