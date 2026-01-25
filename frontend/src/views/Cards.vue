<template>
  <v-container class="cards-container py-12">
    <div class="header-section">
      <h1 class="text-h3 mb-2 section-title">Card Collection</h1>
      <p class="section-subtitle">Browse and manage your arsenal</p>
    </div>
    
    <div class="search-wrapper">
      <div class="search-box">
        <span class="search-icon">🔍</span>
        <input 
          v-model="search" 
          type="text" 
          placeholder="Search cards by name or element..."
          class="search-input"
        >
        <button v-if="search" @click="search = ''" class="clear-btn">✕</button>
      </div>
    </div>
    
    <v-alert v-if="error" type="error" class="mb-6 error-alert">
      {{ error }}
    </v-alert>
    
    <div v-if="loading" class="loading-container">
      <v-progress-circular indeterminate size="64" color="#00d4ff"></v-progress-circular>
      <p class="loading-text">Initializing card library...</p>
    </div>
    
    <div v-else class="cards-grid">
      <div v-for="card in filteredCards" :key="card.id" class="card-col">
        <div class="card-wrapper" :style="{ '--element-color': getElementColor(card.element) }">
          <v-card class="game-card" :class="'element-' + card.element">
            <v-img
              :src="card.image_url || 'https://images.unsplash.com/photo-1559056199-641a0ac8b3f2?w=400&h=500&fit=crop'"
              aspect-ratio="2/3"
              class="card-image"
            ></v-img>
            <v-card-title class="card-title">{{ card.name }}</v-card-title>
            <v-card-text class="card-text">
              <p class="card-description">{{ card.description }}</p>
              <div class="card-stats">
                <div class="stat-chip element-badge" :style="{ 'background-color': getElementColor(card.element), 'box-shadow': `0 0 15px ${getElementColor(card.element)}` }">
                  <span class="stat-icon">⚡</span>
                  {{ card.element }}
                </div>
                <div class="stat-chip rarity-badge" :style="{ 'background-color': getRarityColor(card.rarity), 'box-shadow': `0 0 15px ${getRarityColor(card.rarity)}` }">
                  <span class="stat-icon">✨</span>
                  {{ card.rarity }}
                </div>
              </div>
              <div class="power-cost">
                <div class="stat-box power">
                  <span class="stat-label">POWER</span>
                  <span class="stat-value">{{ card.power }}</span>
                </div>
                <div class="stat-box cost">
                  <span class="stat-label">COST</span>
                  <span class="stat-value">{{ card.cost }}</span>
                </div>
              </div>
            </v-card-text>
            <v-card-actions>
              <v-btn size="small" class="action-btn" :style="{ '--element-color': getElementColor(card.element) }">
                <span class="btn-icon">➕</span> Add to Deck
              </v-btn>
            </v-card-actions>
          </v-card>
        </div>
      </div>
    </div>
  </v-container>
</template>

<script>
import { cardService } from '@/services/api'

export default {
  name: 'Cards',
  data() {
    return {
      cards: [],
      search: '',
      loading: true,
      error: null
    }
  },
  computed: {
    filteredCards() {
      return this.cards.filter(card =>
        card.name.toLowerCase().includes(this.search.toLowerCase()) ||
        card.element.toLowerCase().includes(this.search.toLowerCase())
      )
    }
  },
  methods: {
    getElementColor(element) {
      const colors = {
        fire: '#FF6B35',
        water: '#00A8E8',
        nature: '#06D6A0',
        lightning: '#FFD60A',
        dark: '#9D4EDD',
        light: '#3A86FF',
        neutral: '#8B8B8B'
      }
      return colors[element] || '#8B8B8B'
    },
    getRarityColor(rarity) {
      const colors = {
        common: '#A0A0A0',
        uncommon: '#06D6A0',
        rare: '#00A8E8',
        legendary: '#FFD60A'
      }
      return colors[rarity] || '#A0A0A0'
    },
    async fetchCards() {
      try {
        this.loading = true
        this.error = null
        const response = await cardService.getAllCards()
        this.cards = response.data.data || response.data
      } catch (err) {
        this.error = 'Failed to load cards: ' + (err.response?.data?.message || err.message)
        console.error(err)
      } finally {
        this.loading = false
      }
    }
  },
  mounted() {
    this.fetchCards()
  }
}
</script>

<style scoped>
* {
  box-sizing: border-box;
}

.cards-container {
  background: #000 !important;
  min-height: calc(100vh - 100px);
  padding-top: 3rem !important;
  padding-bottom: 3rem !important;
  margin: 0 !important;
}

.header-section {
  text-align: center;
  margin-bottom: 3rem;
}

.section-title {
  background: linear-gradient(90deg, #00d4ff, #0066ff, #00d4ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  text-transform: uppercase;
  letter-spacing: 3px;
  font-weight: 900;
  filter: drop-shadow(0 0 15px rgba(0, 212, 255, 0.3));
}

.section-subtitle {
  color: #88aaff;
  font-size: 1.1rem;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.search-wrapper {
  display: flex;
  justify-content: center;
  margin-bottom: 3rem;
  width: 100%;
}

.search-box {
  position: relative;
  width: 100%;
  max-width: 500px;
  display: flex;
  align-items: center;
  background: rgba(0, 212, 255, 0.05);
  border: 2px solid #00d4ff;
  border-radius: 8px;
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.1);
}

.search-box:focus-within {
  border-color: #0066ff;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.3), inset 0 0 20px rgba(0, 102, 255, 0.1);
}

.search-icon {
  font-size: 1.2rem;
  margin-right: 0.75rem;
  color: #00d4ff;
}

.search-input {
  flex: 1;
  background: transparent;
  border: none;
  color: #88aaff;
  font-size: 1rem;
  font-family: 'Roboto Mono', monospace;
  outline: none;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.search-input::placeholder {
  color: #6688cc;
  opacity: 0.7;
  text-transform: uppercase;
}

.clear-btn {
  background: none;
  border: none;
  color: #00d4ff;
  font-size: 1.2rem;
  cursor: pointer;
  padding: 0.25rem 0.5rem;
  transition: all 0.3s ease;
  text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}

.clear-btn:hover {
  color: #ff6b6b;
  text-shadow: 0 0 10px rgba(255, 107, 107, 0.5);
  transform: rotate(90deg);
}

.error-alert {
  background: rgba(255, 107, 53, 0.1) !important;
  border: 1px solid #FF6B35 !important;
  color: #FF6B35;
}

.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 400px;
  gap: 2rem;
}

.loading-text {
  color: #00d4ff;
  font-size: 1.1rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  animation: pulse-text 1.5s ease-in-out infinite;
}

@keyframes pulse-text {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

.card-wrapper {
  height: 100%;
  perspective: 1200px;
  width: 100%;
}

.cards-grid {
  display: grid !important;
  grid-template-columns: repeat(auto-fit, minmax(280px, 320px)) !important;
  gap: 2rem !important;
  max-width: 1400px !important;
  margin: 0 auto !important;
  justify-content: center !important;
}

.card-col {
  width: auto !important;
  flex: none !important;
}

.game-card {
  background: linear-gradient(135deg, rgba(15, 10, 30, 0.8) 0%, rgba(20, 15, 40, 0.8)) !important;
  border: 2px solid;
  border-color: var(--element-color);
  border-radius: 8px;
  overflow: hidden;
  height: 100%;
  transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.1);
  position: relative;
}

.game-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
  transition: left 0.5s;
  z-index: 1;
  pointer-events: none;
}

.game-card:hover {
  border-color: var(--element-color);
  box-shadow: 0 0 40px var(--element-color), 0 0 60px rgba(0, 212, 255, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.2);
  transform: translateY(-10px) scale(1.02);
}

.game-card:hover::before {
  left: 100%;
}

.element-fire {
  --element-color: #FF6B35;
}

.element-fire .card-image {
  animation: glow-fire 2s ease-in-out infinite;
}

@keyframes glow-fire {
  0%, 100% {
    filter: brightness(1) drop-shadow(0 0 10px #FF6B35);
  }
  50% {
    filter: brightness(1.1) drop-shadow(0 0 20px #FF6B35);
  }
}

.element-water {
  --element-color: #00A8E8;
}

.element-water .card-image {
  animation: glow-water 2s ease-in-out infinite;
}

@keyframes glow-water {
  0%, 100% {
    filter: brightness(1) drop-shadow(0 0 10px #00A8E8);
  }
  50% {
    filter: brightness(1.1) drop-shadow(0 0 20px #00A8E8);
  }
}

.element-nature {
  --element-color: #06D6A0;
}

.element-nature .card-image {
  animation: glow-nature 2s ease-in-out infinite;
}

@keyframes glow-nature {
  0%, 100% {
    filter: brightness(1) drop-shadow(0 0 10px #06D6A0);
  }
  50% {
    filter: brightness(1.1) drop-shadow(0 0 20px #06D6A0);
  }
}

.element-lightning {
  --element-color: #FFD60A;
}

.element-lightning .card-image {
  animation: glow-lightning 1.5s ease-in-out infinite;
}

@keyframes glow-lightning {
  0%, 100% {
    filter: brightness(1) drop-shadow(0 0 10px #FFD60A);
  }
  50% {
    filter: brightness(1.15) drop-shadow(0 0 25px #FFD60A);
  }
}

.element-dark {
  --element-color: #9D4EDD;
}

.element-dark .card-image {
  animation: glow-dark 2.5s ease-in-out infinite;
}

@keyframes glow-dark {
  0%, 100% {
    filter: brightness(0.9) drop-shadow(0 0 10px #9D4EDD);
  }
  50% {
    filter: brightness(1) drop-shadow(0 0 20px #9D4EDD);
  }
}

.element-light {
  --element-color: #3A86FF;
}

.element-light .card-image {
  animation: glow-light 2s ease-in-out infinite;
}

@keyframes glow-light {
  0%, 100% {
    filter: brightness(1.05) drop-shadow(0 0 10px #3A86FF);
  }
  50% {
    filter: brightness(1.15) drop-shadow(0 0 20px #3A86FF);
  }
}

.element-neutral {
  --element-color: #8B8B8B;
}

.element-neutral .card-image {
  animation: glow-neutral 2s ease-in-out infinite;
}

@keyframes glow-neutral {
  0%, 100% {
    filter: brightness(1) drop-shadow(0 0 5px #8B8B8B);
  }
  50% {
    filter: brightness(1.05) drop-shadow(0 0 10px #8B8B8B);
  }
}

.card-image {
  filter: saturate(1.2);
  transition: filter 0.3s ease;
}

.card-title {
  color: #fff !important;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  font-size: 0.95rem !important;
  padding: 1rem 1rem 0.5rem !important;
}

.card-text {
  padding: 0.5rem 1rem !important;
}

.card-description {
  color: #88aaff;
  font-size: 0.85rem;
  margin: 0.5rem 0;
  line-height: 1.4;
}

.card-stats {
  display: flex;
  gap: 0.5rem;
  margin: 1rem 0;
  flex-wrap: wrap;
}

.stat-chip {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.4rem 0.8rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #000;
  background-color: var(--element-color);
  transition: all 0.3s ease;
}

.stat-chip:hover {
  transform: scale(1.1);
}

.stat-icon {
  font-size: 0.9rem;
}

.power-cost {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem;
  margin-top: 1rem;
}

.stat-box {
  background: linear-gradient(135deg, rgba(0, 212, 255, 0.05), rgba(0, 102, 255, 0.05));
  border: 1px solid rgba(0, 212, 255, 0.2);
  border-radius: 4px;
  padding: 0.75rem;
  text-align: center;
  transition: all 0.3s ease;
}

.stat-box:hover {
  border-color: rgba(0, 212, 255, 0.5);
  box-shadow: 0 0 10px rgba(0, 212, 255, 0.15);
}

.stat-label {
  display: block;
  color: #6688cc;
  font-size: 0.65rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 0.25rem;
}

.stat-value {
  display: block;
  color: #00d4ff;
  font-size: 1.5rem;
  font-weight: 900;
  text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}

.action-btn {
  width: 100%;
  background: linear-gradient(90deg, var(--element-color) 0%, var(--element-color) 100%) !important;
  color: #000 !important;
  font-weight: 700 !important;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 4px;
  transition: all 0.3s ease;
  box-shadow: 0 0 15px var(--element-color) !important;
}

.action-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 25px var(--element-color), 0 0 35px var(--element-color) !important;
}

.btn-icon {
  margin-right: 0.5rem;
}

@media (max-width: 960px) {
  .section-title {
    font-size: 1.75rem !important;
  }

  .card-wrapper {
    margin-bottom: 1rem;
  }
}

@media (max-width: 600px) {
  .cards-container {
    padding-top: 1rem !important;
  }

  .section-title {
    font-size: 1.5rem !important;
  }

  .section-subtitle {
    font-size: 0.9rem;
  }
}
</style>
