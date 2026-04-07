<template>
  <div class="play-container">
    <div class="play-bg"></div>
    
    <v-container class="play-content">
      <section class="arena-header">
        <h1 class="arena-title">CARD FLIP ARENA</h1>
        <p class="arena-subtitle">Flip cards and earn points based on fortune and chance</p>
        <div class="accent-line"></div>
      </section>

      <!-- Game Not Started -->
      <section v-if="!gameStarted" class="start-game-section">
        <div class="start-card">
          <h2>READY TO PLAY?</h2>
          <p>Flip cards to earn random points. The more you flip, the more you earn!</p>
          <button @click="startGame" class="start-btn" :disabled="isLoading">
            <span v-if="!isLoading">START GAME</span>
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
          <div class="cards-left">
            <span class="left-label">CARDS FLIPPED</span>
            <span class="left-value">{{ cardsFlipped }}/{{ totalCards }}</span>
          </div>
          <div class="multiplier" v-if="pointMultiplier > 1">
            <span class="mult-label">MULTIPLIER</span>
            <span class="mult-value">{{ pointMultiplier }}x</span>
          </div>
        </div>

        <div class="cards-grid">
          <div 
            v-for="(card, idx) in gameCards" 
            :key="idx"
            :class="['card-item', { flipped: card.flipped, revealed: card.revealed }]"
            @click="flipCard(idx)"
            :style="{ '--card-delay': idx * 0.05 + 's' }"
          >
            <div class="card-inner">
              <div class="card-front">
                <span class="card-emoji">🎴</span>
                <span class="card-number">{{ idx + 1 }}</span>
              </div>
              <div class="card-back">
                <span class="card-result" :class="'result-' + card.result">
                  {{ card.result >= 0 ? '+' : '' }}{{ card.result }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="game-actions">
          <button @click="endGame" class="end-game-btn">
            <span>END GAME</span>
            <span class="arrow">→</span>
          </button>
        </div>
      </section>

      <!-- Game Results -->
      <section v-if="gameEnded" class="results-section">
        <div class="results-card">
          <div class="result-status" :class="gameWon ? 'won' : 'completed'">
            <span class="result-icon">{{ gameWon ? '🏆' : '✨' }}</span>
            <h2>{{ gameWon ? 'EXCELLENT!' : 'GAME OVER!' }}</h2>
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
              <span class="stat-title">AVERAGE</span>
              <span class="stat-value">{{ (sessionPoints / cardsFlipped).toFixed(1) }}</span>
            </div>
          </div>

          <div v-if="unlockedCards.length > 0" class="unlocked-cards-section">
            <h3>NEW CARDS UNLOCKED!</h3>
            <div class="unlocked-cards-list">
              <div v-for="card in unlockedCards" :key="card.card_id" class="unlocked-card-item">
                <span class="card-name">{{ card.name }}</span>
                <span class="card-rarity" :class="'rarity-' + card.rarity">{{ card.rarity }}</span>
                <span class="card-bonus">+{{ card.bonus }} pts</span>
              </div>
            </div>
          </div>

          <div class="result-actions">
            <button @click="resetGame" class="play-again-btn">
              <span>PLAY AGAIN</span>
              <span class="arrow">→</span>
            </button>
            <router-link to="/profile" class="view-profile-btn">
              <span>VIEW PROFILE</span>
              <span class="arrow">→</span>
            </router-link>
          </div>
        </div>
      </section>

      <!-- Leaderboard -->
      <section class="leaderboard-section">
        <h2 class="section-label">TOP PLAYERS</h2>
        <div class="leaderboard-table">
          <div class="leaderboard-header">
            <span class="rank">RANK</span>
            <span class="player">PLAYER</span>
            <span class="points">TOTAL POINTS</span>
            <span class="games">GAMES</span>
          </div>
          <div class="leaderboard-row" v-for="(player, idx) in topPlayers" :key="idx">
            <span class="rank">{{ idx + 1 }}</span>
            <span class="player">{{ player.name }}</span>
            <span class="points">{{ player.points }}</span>
            <span class="games">{{ player.games }}</span>
          </div>
        </div>
      </section>
    </v-container>
  </div>
</template>

<script>
import { gameService, cardService } from '@/services/api'

export default {
  name: 'Play',
  data() {
    return {
      gameStarted: false,
      gameEnded: false,
      gameWon: false,
      isLoading: false,
      sessionPoints: 0,
      cardsFlipped: 0,
      totalCards: 12,
      pointMultiplier: 1,
      gameCards: [],
      flippedCardIds: [],
      unlockedCards: [],
      topPlayers: [
        { name: 'SHADOW_STRIKER', points: 28500, games: 156, color: '#FFD60A' },
        { name: 'QUANTUM_MASTER', points: 27200, games: 143, color: '#00d4ff' },
        { name: 'NEON_PHOENIX', points: 26800, games: 138, color: '#FF6B35' },
        { name: 'VOID_SENTINEL', points: 26400, games: 131, color: '#9D4EDD' },
        { name: 'CRYSTAL_ECHO', points: 25800, games: 125, color: '#06D6A0' }
      ]
    }
  },
  methods: {
    async startGame() {
      this.isLoading = true
      this.gameStarted = true
      this.gameEnded = false
      this.sessionPoints = 0
      this.cardsFlipped = 0
      this.pointMultiplier = 1
      this.flippedCardIds = []
      this.unlockedCards = []
      
      try {
        // Fetch random cards from backend
        const response = await cardService.getRandomCards(this.totalCards)
        const randomCards = response.data.cards

        // Initialize cards with actual data
        this.gameCards = randomCards.map((card, i) => ({
          id: card.id,
          name: card.name,
          rarity: card.rarity,
          flipped: false,
          revealed: false,
          result: this.generateRandomPoints()
        }))
      } catch (err) {
        console.error('Failed to fetch random cards:', err)
        // Fallback to local generation
        this.gameCards = Array.from({ length: this.totalCards }, (_, i) => ({
          id: i + 1,
          name: `Card ${i + 1}`,
          rarity: 'common',
          flipped: false,
          revealed: false,
          result: this.generateRandomPoints()
        }))
      }
      
      setTimeout(() => {
        this.isLoading = false
      }, 500)
    },
    
    flipCard(index) {
      if (this.gameCards[index].flipped || !this.gameStarted || this.gameEnded) return
      
      const card = this.gameCards[index]
      card.flipped = true
      
      // Delay reveal for animation
      setTimeout(() => {
        card.revealed = true
        this.sessionPoints += card.result
        this.cardsFlipped += 1
        
        // Track flipped card ID for backend
        if (!this.flippedCardIds.includes(card.id)) {
          this.flippedCardIds.push(card.id)
        }
        
        // Increase multiplier every 3 cards
        if (this.cardsFlipped % 3 === 0) {
          this.pointMultiplier = 1 + (this.cardsFlipped / 3) * 0.25
        }
        
        // Auto-end if all cards flipped
        if (this.cardsFlipped === this.totalCards) {
          setTimeout(() => this.endGame(), 1000)
        }
      }, 300)
    },
    
    generateRandomPoints() {
      const outcomes = [-2, -1, 0, 5, 5, 5, 10, 10, 15, 20]
      return outcomes[Math.floor(Math.random() * outcomes.length)]
    },
    
    endGame() {
      this.gameStarted = false
      this.gameEnded = true
      this.gameWon = this.sessionPoints > 50
      this.saveGameResult()
    },
    
    resetGame() {
      this.gameStarted = false
      this.gameEnded = false
      this.gameWon = false
      this.sessionPoints = 0
      this.cardsFlipped = 0
      this.pointMultiplier = 1
      this.gameCards = []
      this.flippedCardIds = []
      this.unlockedCards = []
    },
    
    saveGameResult() {
      // Send game data with card IDs to backend
      gameService.endGame({
        points: this.sessionPoints,
        cards_flipped: this.cardsFlipped,
        game_mode: 'rng',
        flipped_card_ids: this.flippedCardIds
      }).then(response => {
        console.log('Game saved:', response.data)
        // Store unlocked cards for display
        if (response.data.game_result.unlocked_cards) {
          this.unlockedCards = response.data.game_result.unlocked_cards
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
  z-index: 0;
  padding: 6rem 2rem !important;
}

.arena-header {
  text-align: center;
  margin-bottom: 4rem;
}

.arena-title {
  font-size: 3.5rem;
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
  font-size: 1.2rem;
  color: #88aaff;
  margin-bottom: 1.5rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.accent-line {
  width: 80px;
  height: 3px;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  margin: 0 auto;
}

.section-label {
  font-size: 1.5rem;
  text-transform: uppercase;
  color: #00d4ff;
  letter-spacing: 2px;
  margin-bottom: 2rem;
  text-shadow: 0 0 15px rgba(0, 212, 255, 0.5);
}

/* START GAME SECTION */
.start-game-section {
  margin: 4rem 0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 300px;
}

.start-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 2px solid #00d4ff;
  border-radius: 8px;
  padding: 3rem;
  text-align: center;
  max-width: 600px;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.15);
  animation: slideIn 0.8s ease-out;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.start-card h2 {
  font-size: 2.5rem;
  text-transform: uppercase;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 1rem;
  letter-spacing: 2px;
}

.start-card p {
  color: #88aaff;
  font-size: 1.1rem;
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
  font-size: 1.1rem;
  transition: all 0.3s ease;
  box-shadow: 0 0 25px rgba(0, 212, 255, 0.3);
}

.start-btn:hover:not(:disabled) {
  transform: scale(1.05);
  box-shadow: 0 0 50px #00d4ff, 0 0 80px rgba(0, 102, 255, 0.4);
}

.start-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* GAME SECTION */
.game-section {
  margin-bottom: 4rem;
}

.game-header {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 2rem;
  margin-bottom: 3rem;
  padding: 2rem;
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 2px solid #00d4ff;
  border-radius: 8px;
}

.score-display,
.cards-left,
.multiplier {
  text-align: center;
}

.score-label,
.left-label,
.mult-label {
  display: block;
  color: #00d4ff;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 0.5rem;
  font-weight: 700;
}

.score-value,
.left-value,
.mult-value {
  display: block;
  font-size: 2rem;
  font-weight: 900;
  color: #fff;
  text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}

.cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
}

.card-item {
  perspective: 1000px;
  cursor: pointer;
  animation: cardAppear 0.6s ease-out forwards;
  animation-delay: var(--card-delay, 0s);
  opacity: 0;
}

@keyframes cardAppear {
  from {
    opacity: 0;
    transform: scale(0.5);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.card-item:hover:not(.flipped) {
  transform: scale(1.05);
}

.card-inner {
  position: relative;
  width: 100%;
  aspect-ratio: 2/3;
  transition: transform 0.6s;
  transform-style: preserve-3d;
}

.card-item.flipped .card-inner {
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
  font-weight: 900;
  border: 2px solid;
}

.card-front {
  background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(0, 102, 255, 0.2));
  border-color: #00d4ff;
  color: #00d4ff;
  text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}

.card-back {
  background: linear-gradient(135deg, rgba(100, 50, 200, 0.3), rgba(0, 150, 255, 0.3));
  border-color: #0066ff;
  transform: rotateY(180deg);
}

.card-emoji {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
}

.card-number {
  font-size: 1.2rem;
  color: #88aaff;
}

.card-result {
  font-size: 1.8rem;
  font-weight: 900;
}

.result-20,
.result-15,
.result-10,
.result-5 {
  color: #06D6A0;
  text-shadow: 0 0 15px #06D6A0;
}

.result-0 {
  color: #FFD60A;
  text-shadow: 0 0 15px #FFD60A;
}

.result--1,
.result--2 {
  color: #FF6B35;
  text-shadow: 0 0 15px #FF6B35;
}

.game-actions {
  text-align: center;
  margin-top: 2rem;
}

.end-game-btn {
  padding: 1rem 2rem;
  background: linear-gradient(90deg, #FF6B35, #FF4500);
  color: #fff;
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
  box-shadow: 0 0 25px rgba(255, 107, 53, 0.3);
}

.end-game-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 50px #FF6B35, 0 0 80px rgba(255, 107, 53, 0.4);
}

/* RESULTS SECTION */
.results-section {
  margin-bottom: 4rem;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 400px;
}

.results-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 2px solid #00d4ff;
  border-radius: 8px;
  padding: 3rem;
  text-align: center;
  max-width: 700px;
  animation: slideIn 0.8s ease-out;
}

.result-status {
  margin-bottom: 2rem;
}

.result-status.won {
  color: #FFD60A;
}

.result-status.completed {
  color: #06D6A0;
}

.result-icon {
  font-size: 4rem;
  display: block;
  margin-bottom: 1rem;
  animation: bounce 1s ease-in-out infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-15px); }
}

.result-status h2 {
  font-size: 2.5rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 20px currentColor;
}

.result-stats {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 2rem;
  margin-bottom: 2rem;
  padding: 2rem;
  background: rgba(0, 0, 0, 0.3);
  border-radius: 8px;
  border: 1px solid #00d4ff;
}

.stat-item {
  display: flex;
  flex-direction: column;
}

.stat-title {
  color: #00d4ff;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 0.5rem;
  font-weight: 700;
}

.stat-value {
  font-size: 2rem;
  font-weight: 900;
  color: #fff;
  text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}

.unlocked-cards-section {
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: linear-gradient(135deg, rgba(0, 212, 255, 0.05), rgba(0, 102, 255, 0.05));
  border: 2px solid #06D6A0;
  border-radius: 8px;
}

.unlocked-cards-section h3 {
  color: #06D6A0;
  text-transform: uppercase;
  letter-spacing: 2px;
  font-size: 1.2rem;
  margin-bottom: 1rem;
  text-shadow: 0 0 15px #06D6A0;
}

.unlocked-cards-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
}

.unlocked-card-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem;
  background: rgba(0, 0, 0, 0.4);
  border: 1px solid #06D6A0;
  border-radius: 4px;
  animation: slide-in 0.5s ease-out;
}

.card-name {
  color: #fff;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.card-rarity {
  padding: 0.3rem 0.6rem;
  border-radius: 3px;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.rarity-common {
  background: #A0A0A0;
  color: #000;
}

.rarity-uncommon {
  background: #06D6A0;
  color: #000;
}

.rarity-rare {
  background: #00A8E8;
  color: #000;
}

.rarity-epic {
  background: #9D4EDD;
  color: #fff;
}

.rarity-legendary {
  background: #FFD60A;
  color: #000;
}

.card-bonus {
  color: #06D6A0;
  font-weight: 900;
  font-size: 1.1rem;
  text-shadow: 0 0 10px #06D6A0;
}

@keyframes slide-in {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.result-actions {
  display: flex;
  gap: 1.5rem;
  justify-content: center;
  flex-wrap: wrap;
}

.play-again-btn,
.view-profile-btn {
  padding: 0.75rem 1.5rem;
  border: 2px solid;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
  cursor: pointer;
  border-radius: 4px;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
  transition: all 0.3s ease;
  text-decoration: none;
}

.play-again-btn {
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  border-color: #00d4ff;
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
}

.play-again-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 40px #00d4ff, 0 0 60px rgba(0, 102, 255, 0.3);
}

.view-profile-btn {
  background: transparent;
  color: #00d4ff;
  border-color: #00d4ff;
  box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
}

.view-profile-btn:hover {
  background: rgba(0, 212, 255, 0.1);
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.4);
}

.leaderboard-section {
  margin-bottom: 2rem;
}

.leaderboard-section {
  margin-bottom: 2rem;
}

.leaderboard-table {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.1), rgba(0, 20, 50, 0.2));
  border: 1px solid #00d4ff;
  border-radius: 8px;
  overflow: hidden;
}

.leaderboard-header {
  display: grid;
  grid-template-columns: 50px 2fr 1fr 1fr;
  gap: 1.5rem;
  padding: 1.5rem;
  background: rgba(0, 212, 255, 0.1);
  border-bottom: 2px solid #00d4ff;
  font-weight: 900;
  text-transform: uppercase;
  color: #00d4ff;
  letter-spacing: 1px;
  font-size: 0.9rem;
  width: 100%;
}

.leaderboard-row {
  display: grid;
  grid-template-columns: 50px 2fr 1fr 1fr;
  gap: 1.5rem;
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid rgba(0, 212, 255, 0.1);
  align-items: center;
  transition: all 0.3s ease;
  width: 100%;
}

.leaderboard-row:hover {
  background: rgba(0, 212, 255, 0.05);
}

.leaderboard-row:last-child {
  border-bottom: none;
}

.rank {
  color: #FFD60A;
  font-weight: 900;
  text-align: center;
  font-size: 1.1rem;
}

.player {
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 0.95rem;
}

.points {
  font-weight: 900;
  text-align: center;
  font-size: 1rem;
  color: #06D6A0;
  text-shadow: 0 0 10px #06D6A0;
}

.games {
  color: #FFD60A;
  text-align: center;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
}

@media (max-width: 1024px) {
  .arena-title {
    font-size: 2.5rem;
  }

  .game-header {
    grid-template-columns: 1fr;
  }

  .result-stats {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .play-content {
    padding: 2rem 1rem !important;
  }

  .arena-title {
    font-size: 2rem;
  }

  .cards-grid {
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 1rem;
  }

  .game-header {
    grid-template-columns: 1fr;
    gap: 1rem;
    padding: 1.5rem;
  }

  .start-card {
    padding: 2rem 1.5rem;
  }

  .start-card h2 {
    font-size: 1.8rem;
  }

  .start-card p {
    font-size: 1rem;
  }

  .results-card {
    padding: 2rem 1.5rem;
  }

  .result-actions {
    gap: 1rem;
  }

  .play-again-btn,
  .view-profile-btn {
    flex: 1;
    min-width: 140px;
  }

  .leaderboard-header,
  .leaderboard-row {
    grid-template-columns: 40px 1fr 70px 70px;
    gap: 0.75rem;
    font-size: 0.85rem;
  }

  .leaderboard-header {
    padding: 1rem;
  }

  .leaderboard-row {
    padding: 1rem;
  }
}
</style>
