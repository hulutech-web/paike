import { defineStore } from 'pinia'
import userApi from '@/api/user'
const useUserStore = defineStore('userId', {
    // arrow function recommended for full type inference
    state: () => {
        return {
            info: {}
        }
    },
    getters: {
        getUser(state, name) {
            return state.errors[name] && state.errors[name][0]
        }
    },
    actions: {

    }
})
export default useUserStore