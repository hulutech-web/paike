import { defineStore } from 'pinia'

const useErrorStore = defineStore('errorId', {
    // arrow function recommended for full type inference
    state: () => {
        return {
            errors: {}
        }
    },
    getters: {
        getErrors(state, name) {
            return state.errors[name] && state.errors[name][0]
        }
    },
    actions: {

    }
})
export default useErrorStore