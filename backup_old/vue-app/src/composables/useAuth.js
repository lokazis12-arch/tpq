import { ref } from 'vue'
import api from '../lib/api'

const currentUser = ref(null)

export function useAuth() {
  const login = async (email, password) => {
    try {
      const response = await api.post('/login', {
        email,
        password
      })

      const { user, token } = response.data
      
      const userData = {
        ...user,
        token
      }

      currentUser.value = userData
      localStorage.setItem('user', JSON.stringify(userData))
      return { data: userData }
    } catch (error) {
      console.error('[Auth] Login error:', error.response?.data?.message || error.message)
      return { error: error.response?.data || { message: error.message } }
    }
  }

  const logout = async () => {
    try {
      await api.post('/logout')
    } catch (error) {
      console.error('[Auth] Logout error:', error.message)
    } finally {
      currentUser.value = null
      localStorage.removeItem('user')
    }
  }

  const getUser = () => {
    if (!currentUser.value) {
      const stored = localStorage.getItem('user')
      if (stored) {
        currentUser.value = JSON.parse(stored)
      }
    }
    return currentUser.value
  }

  const isLoggedIn = () => {
    return !!getUser()
  }

  return {
    currentUser,
    login,
    logout,
    getUser,
    isLoggedIn
  }
}
