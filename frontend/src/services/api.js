import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

const apiClient = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json'
  }
})

// Add token to requests if available
apiClient.interceptors.request.use(config => {
  const token = localStorage.getItem('auth_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

export const cardService = {
  getAllCards() {
    return apiClient.get('/cards')
  },
  getCard(id) {
    return apiClient.get(`/cards/${id}`)
  },
  getUserCards() {
    return apiClient.get('/user/cards')
  }
}

export const deckService = {
  getUserDecks() {
    return apiClient.get('/decks')
  },
  getDeck(id) {
    return apiClient.get(`/decks/${id}`)
  },
  createDeck(data) {
    return apiClient.post('/decks', data)
  },
  updateDeck(id, data) {
    return apiClient.put(`/decks/${id}`, data)
  },
  deleteDeck(id) {
    return apiClient.delete(`/decks/${id}`)
  }
}

export const authService = {
  register(credentials) {
    return apiClient.post('/auth/register', credentials)
  },
  login(credentials) {
    return apiClient.post('/auth/login', credentials)
  },
  logout() {
    return apiClient.post('/auth/logout')
  },
  getCurrentUser() {
    return apiClient.get('/auth/user')
  }
}

export const battleService = {
  startBattle(opponentId) {
    return apiClient.post('/battles', { opponent_id: opponentId })
  },
  getBattle(id) {
    return apiClient.get(`/battles/${id}`)
  },
  makeMove(battleId, moveData) {
    return apiClient.post(`/battles/${battleId}/move`, moveData)
  }
}

export default apiClient
