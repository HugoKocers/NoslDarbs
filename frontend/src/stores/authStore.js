import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

const API_BASE = 'http://localhost:8000/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('auth_token') || null)
  const isLoading = ref(false)
  const error = ref(null)

  const isAuthenticated = computed(() => !!token.value && !!user.value)
  const isAdmin = computed(() => user.value?.role === 'admin')

  // Set axios default header
  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
  }

  const register = async (name, email, password, passwordConfirmation) => {
    isLoading.value = true
    error.value = null
    try {
      const response = await axios.post(`${API_BASE}/auth/register`, {
        name,
        email,
        password,
        password_confirmation: passwordConfirmation
      })
      token.value = response.data.token
      user.value = response.data.user
      localStorage.setItem('auth_token', token.value)
      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
      return response.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Registration failed'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  const login = async (email, password) => {
    isLoading.value = true
    error.value = null
    try {
      const response = await axios.post(`${API_BASE}/auth/login`, {
        email,
        password
      })
      token.value = response.data.token
      user.value = response.data.user
      localStorage.setItem('auth_token', token.value)
      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
      return response.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Login failed'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  const logout = async () => {
    try {
      if (token.value) {
        await axios.post(`${API_BASE}/auth/logout`)
      }
    } catch (err) {
      console.error('Logout error:', err)
    } finally {
      user.value = null
      token.value = null
      localStorage.removeItem('auth_token')
      delete axios.defaults.headers.common['Authorization']
    }
  }

  const fetchUser = async () => {
    if (!token.value) return
    try {
      const response = await axios.get(`${API_BASE}/auth/user`)
      user.value = response.data
    } catch (err) {
      console.error('Failed to fetch user:', err)
      logout()
    }
  }

  return {
    user,
    token,
    isLoading,
    error,
    isAuthenticated,
    isAdmin,
    register,
    login,
    logout,
    fetchUser
  }
})
