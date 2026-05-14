<template>
  <div class="play-container">
    <div class="play-bg"></div>
    
    <v-container class="play-content">
      <section class="arena-header">
        <h1 class="arena-title">CARD FLIP ARENA</h1>
        <p class="arena-subtitle">Flip cards and earn points. Duplicates count but don't unlock twice.</p>
        <div class="accent-line"></div>
      </section>

      <!-- Game Not Started -->
      <section v-if="!gameStarted" class="start-game-section">
        <div class="start-card">
          <h2>READY TO PLAY?</h2>
          <p>Flip cards to earn points and discover new cards for your collection!</p>
          <button @click="startGame" class="start-btn" :disabled="isLoading">
            <span v-if="!isLoading">PLAY GAME</span>
            <span v-else>LOADING...</span>
            <span class="arrow">→</span>
          </button>
        </div>
      </section>

      <!-- Game In Progress -->
      <section v-if="gameStarted && !gameEnded" class="game-section">
        <div class="game-header">
          <div class="score-display">
            <span class="score-label">SESSION POINTS</span>
            <span class="score-value">{{ sessionPoints }}</span>
          </div>
          <div class="cards-flipped-display">
            <span class="flipped-label">CARDS FLIPPED</span>
            <span class="flipped-value">{{ cardsFlipped }}</span>
          </div>
          <div class="new-cards-display">
            <span class="new-label">NEW CARDS</span>
            <span class="new-value">{{ newCardsCount }}</span>
          </div>
        </div>

        <!-- Card Table Grid -->
        <div class="card-table">
          <div v-for="(card, index) in tableCards" :key="index" class="card-slot">
            <div 
              :class="['table-card', { 
                flipped: card.flipped,
                'is-duplicate': card.isDuplicate 
              }]"
              @click="flipTableCard(index)"
            >
              <div class="card-inner">
                <!-- Front (unflipped) -->
                <div class="card-front">
                  <span class="card-back-emoji">🎴</span>
                </div>
                <!-- Back (flipped) -->
                <div class="card-back" :style="{ borderColor: getElementColor(card.element) }">
                  <div class="card-content">
                    <div class="card-name">{{ card.name }}</div>
                    <div class="card-rarity" :class="'rarity-' + card.rarity.toLowerCase()">
                      {{ card.rarity }}
                    </div>
                    <div class="card-points" v-if="card.flipped">+{{ card.points }}</div>
                    <div class="duplicate-badge" v-if="card.flipped && card.isDuplicate">DUPLICATE</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="game-actions">
          <button @click="drawNewCards" class="draw-btn">
            <span>DRAW 6 NEW CARDS</span>
            <span class="arrow">→</span>
          </button>
          <button @click="endGame" class="end-game-btn">
            <span>END GAME</span>
            <span class="arrow">→</span>
          </button>
        </div>
      </section>

      <!-- Game Results -->
      <section v-if="gameEnded" class="results-section">
        <div class="results-card">
          <div class="result-status">
            <span class="result-icon">✨</span>
            <h2>SESSION COMPLETE!</h2>
          </div>

          <div class="result-stats">
            <div class="stat-item">
              <span class="stat-title">FINAL SCORE</span>
              <span class="stat-value">{{ sessionPoints }}</span>
            </div>
            <div class="stat-item">
              <span class="stat-title">CARDS FLIPPED</span>
              <span class="stat-value">{{ cardsFlipped }}</span>
            </div>
            <div class="stat-item">
              <span class="stat-title">NEW CARDS DISCOVERED</span>
              <span class="stat-value">{{ newCardsCount }}</span>
            </div>
          </div>

          <div class="result-actions">
            <button @click="resetGame" class="play-again-btn">
              <span>PLAY AGAIN</span>
              <span class="arrow">→</span>
            </button>
            <router-link to="/cards" class="view-collection-btn">
              <span>VIEW COLLECTION</span>
              <span class="arrow">→</span>
            </router-link>
          </div>
        </div>
      </section>
    </v-container>
  </div>
</template>

<script>
import { gameService, cardService } from '@/services/api'
import { useAuthStore } from '@/stores/authStore'

export default {
  name: 'Play',
  data() {
    return {
      gameStarted: false,
      gameEnded: false,
      isLoading: false,
      sessionPoints: 0,
      cardsFlipped: 0,
      newCardsCount: 0,
      tableCards: [],
      seenCardIds: [],
      allGameCards: [],
      authStore: useAuthStore()
    }
  },
  methods: {
    async startGame() {
      this.isLoading = true
      this.gameStarted = true
      this.gameEnded = false
      this.sessionPoints = 0
      this.cardsFlipped = 0
      this.newCardsCount = 0
      this.seenCardIds = []
      this.tableCards = []
      
      try {
        const response = await cardService.getAllCards()
        console.log('Cards response:', response.data)
        this.allGameCards = response.data.map(card => ({
          ...card,
          points: this.generatePoints(card.rarity)
        }))
        this.drawNewCards()
      } catch (err) {
        console.error('Failed to fetch cards:', err)
        this.gameStarted = false
      }
      
      this.isLoading = false
    },
    drawNewCards() {
      const drawn = []
      for (let i = 0; i < 6; i++) {
        const randomCard = this.allGameCards[Math.floor(Math.random() * this.allGameCards.length)]
        const isDuplicate = this.seenCardIds.includes(randomCard.id)
        
        drawn.push({
          ...randomCard,
          flipped: false,
          isDuplicate: isDuplicate,
          points: this.generatePoints(randomCard.rarity),
          elementColor: this.getElementColor(randomCard.element)
        })
      }
      this.tableCards = drawn
    },
    flipTableCard(index) {
      const card = this.tableCards[index]
      if (card.flipped) return
      
      card.flipped = true
      this.sessionPoints += card.points
      this.cardsFlipped += 1
      
      if (!card.isDuplicate && !this.seenCardIds.includes(card.id)) {
        this.seenCardIds.push(card.id)
        this.newCardsCount += 1
      }
    },
    generatePoints(rarity) {
      const pointsByRarity = {
        'common': [5, 5, 5, 7, 7],
        'uncommon': [8, 8, 10, 10, 12],
        'rare': [15, 15, 18, 20, 20],
        'epic': [25, 25, 30, 30, 35],
        'legendary': [50, 50, 60, 75, 100]
      }
      const rarity_lower = rarity.toLowerCase()
      const options = pointsByRarity[rarity_lower] || pointsByRarity['common']
      return options[Math.floor(Math.random() * options.length)]
    },
    getElementColor(element) {
      const colors = {
        'fire': '#FF6B35',
        'water': '#00A8E8',
        'nature': '#06D6A0',
        'lightning': '#FFD60A',
        'dark': '#9D4EDD',
        'light': '#3A86FF'
      }
      return colors[element.toLowerCase()] || '#8B8B8B'
    },
    endGame() {
      this.gameStarted = false
      this.gameEnded = true
      this.saveGameResult()
    },
    resetGame() {
      this.gameStarted = false
      this.gameEnded = false
      this.sessionPoints = 0
      this.cardsFlipped = 0
      this.newCardsCount = 0
      this.tableCards = []
      this.seenCardIds = []
      this.allGameCards = []
    },
    saveGameResult() {
      const gameData = {
        points: this.sessionPoints,
        cards_flipped: this.cardsFlipped,
        game_mode: 'rng',
        flipped_card_ids: this.seenCardIds
      }
      console.log('Sending game data:', gameData)
      gameService.endGame(gameData).then(response => {
        console.log('Game saved:', response.data)
        // Update auth store with the returned stats
        if (response.data.stats) {
          const stats = response.data.stats
          this.authStore.user.totalGames = stats.total_games
          this.authStore.user.totalPoints = stats.total_points
          this.authStore.user.averageScore = stats.average_score
          this.authStore.user.highestScore = stats.highest_score
          this.authStore.user.experience = response.data.user.experience
          this.authStore.user.level = response.data.user.level
          this.authStore.user.cardsUnlockedCount = stats.cards_unlocked
        }
      }).catch(err => console.error('Failed to save game:', err))
    }
  }
}
</script>

<style scoped>
.play-container {
  position: relative;
  background: #000;
  color: #fff;
  overflow-x: hidden;
}

.play-bg {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.03) 0%, transparent 50%);
  pointer-events: none;
  z-index: 0;
}

.play-content {
  position: relative;
  z-index: 1;
  padding: 4rem 2rem !important;
}

.arena-header {
  text-align: center;
  margin-bottom: 3rem;
}

.arena-title {
  font-size: 3rem;
  font-weight: 900;
  text-transform: uppercase;
  background: linear-gradient(90deg, #00d4ff, #0066ff, #00d4ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  letter-spacing: 3px;
  margin-bottom: 1rem;
  filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.3));
}

.arena-subtitle {
  font-size: 1rem;
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 1rem;
}

.accent-line {
  width: 80px;
  height: 3px;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  margin: 0 auto;
}

.start-game-section {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 400px;
  margin: 2rem 0;
}

.start-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 2px solid #00d4ff;
  border-radius: 8px;
  padding: 3rem;
  text-align: center;
  max-width: 500px;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.15);
}

.start-card h2 {
  font-size: 2rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.start-card p {
  color: #88aaff;
  margin-bottom: 2rem;
  line-height: 1.6;
}

.start-btn {
  padding: 1rem 2rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  border: none;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
  cursor: pointer;
  border-radius: 4px;
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 1rem;
  transition: all 0.3s ease;
  box-shadow: 0 0 25px rgba(0, 212, 255, 0.3);
}

.start-btn:hover:not(:disabled) {
  transform: scale(1.05);
  box-shadow: 0 0 50px #00d4ff;
}

.start-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.game-section {
  margin-bottom: 3rem;
}

.game-header {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 2rem;
  margin-bottom: 3rem;
  padding: 1.5rem;
  background: rgba(0, 50, 100, 0.2);
  border: 2px solid #00d4ff;
  border-radius: 8px;
}

.score-display,
.cards-flipped-display,
.new-cards-display {
  text-align: center;
}

.score-label,
.flipped-label,
.new-label {
  display: block;
  color: #00d4ff;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 0.5rem;
  font-weight: 700;
}

.score-value,
.flipped-value,
.new-value {
  display: block;
  font-size: 2rem;
  font-weight: 900;
  color: #fff;
  text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}

.card-table {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
  padding: 1.5rem;
  background: rgba(0, 20, 50, 0.2);
  border: 1px solid rgba(0, 212, 255, 0.2);
  border-radius: 8px;
}

.card-slot {
  aspect-ratio: 3 / 4;
  cursor: pointer;
}

.table-card {
  width: 100%;
  height: 100%;
  perspective: 1000px;
  position: relative;
}

.card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  transition: transform 0.6s ease;
  transform-style: preserve-3d;
}

.table-card.flipped .card-inner {
  transform: rotateY(180deg);
}

.card-front,
.card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  border-radius: 8px;
  border: 2px solid;
  padding: 1rem;
  box-sizing: border-box;
  gap: 0.5rem;
}

.card-front {
  background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(0, 102, 255, 0.15));
  border-color: #00d4ff;
  color: #00d4ff;
  font-size: 3rem;
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.2), inset 0 0 20px rgba(0, 212, 255, 0.05);
}

.card-back {
  background: linear-gradient(135deg, rgba(0, 100, 150, 0.3), rgba(50, 80, 180, 0.3));
  border-color: var(--element-color, #0066ff);
  transform: rotateY(180deg);
  box-shadow: 0 0 20px rgba(0, 102, 255, 0.2);
}

.card-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  width: 100%;
  height: 100%;
  text-align: center;
}

.card-name {
  font-size: 0.95rem;
  font-weight: 700;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 1px;
  line-height: 1.2;
}

.card-rarity {
  font-size: 0.7rem;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 0.3rem 0.6rem;
  border-radius: 3px;
}

.rarity-common {
  background: rgba(150, 150, 150, 0.8);
  color: #fff;
}

.rarity-uncommon {
  background: rgba(0, 200, 100, 0.8);
  color: #000;
}

.rarity-rare {
  background: rgba(0, 150, 255, 0.8);
  color: #000;
}

.rarity-epic {
  background: rgba(150, 50, 200, 0.8);
  color: #fff;
}

.rarity-legendary {
  background: linear-gradient(135deg, #FFD60A, #FF8C00);
  color: #000;
  font-weight: 900;
  box-shadow: 0 0 15px #FFD60A;
}

.card-points {
  font-size: 1.2rem;
  font-weight: 900;
  color: #06D6A0;
  text-shadow: 0 0 10px #06D6A0;
  margin-top: auto;
}

.duplicate-badge {
  font-size: 0.65rem;
  font-weight: 700;
  color: #FFD60A;
  text-shadow: 0 0 5px #FFD60A;
  opacity: 0.9;
}

.game-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin: 2rem 0;
  flex-wrap: wrap;
}

.draw-btn,
.end-game-btn {
  padding: 1rem 1.5rem;
  border: none;
  border-radius: 4px;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
}

.draw-btn {
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  box-shadow: 0 0 25px rgba(0, 212, 255, 0.3);
}

.draw-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 50px rgba(0, 212, 255, 0.6);
}

.end-game-btn {
  background: linear-gradient(90deg, #ff6666, #cc3333);
  color: #fff;
  box-shadow: 0 0 25px rgba(255, 100, 100, 0.3);
}

.end-game-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 50px rgba(255, 100, 100, 0.6);
}

.results-section {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 500px;
  margin: 2rem 0;
}

.results-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 2px solid #00d4ff;
  border-radius: 8px;
  padding: 3rem;
  text-align: center;
  max-width: 600px;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.15);
}

.result-status {
  margin-bottom: 2rem;
}

.result-icon {
  font-size: 3rem;
  display: block;
  margin-bottom: 1rem;
}

.result-status h2 {
  font-size: 2.2rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.result-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: rgba(0, 0, 0, 0.3);
  border-radius: 4px;
}

.stat-item {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.stat-title {
  color: #00d4ff;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 700;
}

.stat-value {
  color: #fff;
  font-size: 1.8rem;
  font-weight: 900;
  text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}

.result-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.play-again-btn,
.view-collection-btn {
  padding: 1rem 1.5rem;
  border: none;
  border-radius: 4px;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  transition: all 0.3s ease;
}

.play-again-btn {
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  box-shadow: 0 0 25px rgba(0, 212, 255, 0.3);
}

.play-again-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 50px rgba(0, 212, 255, 0.6);
}

.view-collection-btn {
  background: linear-gradient(90deg, #06D6A0, #00A8E8);
  color: #000;
  box-shadow: 0 0 25px rgba(0, 212, 255, 0.3);
}

.view-collection-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 50px rgba(0, 212, 255, 0.6);
}

@media (max-width: 768px) {
  .play-content {
    padding: 2rem 1rem !important;
  }
  .arena-title {
    font-size: 2rem;
  }
  .card-table {
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }
  .game-header {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}
</style>
