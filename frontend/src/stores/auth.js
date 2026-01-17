import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('auth_token') || null,
    isAuthenticated: !!localStorage.getItem('auth_token')
  }),
  
  mutations: {
    setUser(state, user) {
      state.user = user
    },
    setToken(state, token) {
      state.token = token
      state.isAuthenticated = true
      localStorage.setItem('auth_token', token)
    },
    logout(state) {
      state.user = null
      state.token = null
      state.isAuthenticated = false
      localStorage.removeItem('auth_token')
    }
  },
  
  actions: {
    async login(credentials) {
      try {
        // Implementation will use API service
        console.log('Logging in...')
      } catch (error) {
        console.error('Login failed:', error)
      }
    },
    
    async logout() {
      this.logout()
    }
  }
})
