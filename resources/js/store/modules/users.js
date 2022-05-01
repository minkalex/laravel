import axios from "axios"

export default {
    state: {
        users1: []
    },
    mutations: {
        setUsers (state, objUser) {
            state.users = objUser
        }
    },
    getters: {
        getUsers(state) {
            return state.users;
        },
    },
    actions: {
        getActualUsers () {
            return new Promise((resolve, reject) => {
                axios.get('./users', {headers: {'X-Requested-With': 'Axios'}})
                    .then(function (response) {
                        resolve(response.data)
                    })
                    .catch(function (error) {
                        reject(error);
                    })
                    .then(function () {
                        //NOP
                    });
            })
        },

        setActualUsers ({ dispatch, commit }) {
            return dispatch('getActualUsers').then((val) => {
                commit('setUsers', val);
            })
        }

        /*setActualUsers(context) {
            axios.get('./users', {headers: {'X-Requested-With': 'Axios'}})
                .then(function (response) {
                    context.commit('setUsers', response.data);
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    //NOP
                });
        }*/
    }
}
