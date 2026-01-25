<template>
  <div class="play-container">
    <div class="play-bg"></div>
    
    <v-container class="play-content">
      <section class="arena-header">
        <h1 class="arena-title">BATTLE ARENA</h1>
        <p class="arena-subtitle">Enter the neural battlegrounds and test your tactical skills</p>
        <div class="accent-line"></div>
      </section>

      <section class="modes-section">
        <h2 class="section-label">GAME MODES</h2>
        <div class="modes-grid">
          <div class="mode-card" v-for="mode in gameModes" :key="mode.id">
            <div class="mode-icon">{{ mode.icon }}</div>
            <h3 class="mode-title">{{ mode.title }}</h3>
            <p class="mode-description">{{ mode.description }}</p>
            <div class="mode-stats">
              <span class="stat">{{ mode.players }} Players</span>
              <span class="divider">•</span>
              <span class="stat">{{ mode.duration }}</span>
            </div>
            <button class="play-btn">
              <span>ENTER</span>
              <span class="arrow">→</span>
            </button>
          </div>
        </div>
      </section>

      <section class="matchmaking-section">
        <div class="matchmaking-card">
          <div class="matchmaking-header">
            <h2 class="matchmaking-title">QUICK MATCHMAKING</h2>
            <p class="matchmaking-desc">Find and battle players of your skill level instantly</p>
          </div>
          <div class="matchmaking-content">
            <div class="skill-selector">
              <label>SELECT DIFFICULTY</label>
              <div class="difficulty-buttons">
                <button v-for="(diff, idx) in difficulties" :key="idx" :class="['diff-btn', { active: selectedDifficulty === idx }]" @click="selectedDifficulty = idx">
                  {{ diff }}
                </button>
              </div>
            </div>
            <div class="deck-preview">
              <label>YOUR DECK STRENGTH</label>
              <div class="strength-bar">
                <div class="strength-fill" style="width: 75%"></div>
                <span class="strength-label">EXCELLENT</span>
              </div>
            </div>
            <button class="find-opponent-btn">
              <span class="pulse-icon">▶</span>
              FIND OPPONENT
            </button>
          </div>
        </div>
      </section>

      <section class="leaderboard-preview">
        <h2 class="section-label">RANKED LEADERBOARD</h2>
        <div class="leaderboard-table">
          <div class="leaderboard-header">
            <span class="rank">RANK</span>
            <span class="player">PLAYER</span>
            <span class="rating">RATING</span>
            <span class="wins">WINS</span>
          </div>
          <div class="leaderboard-row" v-for="(player, idx) in topPlayers" :key="idx">
            <span class="rank">{{ idx + 1 }}</span>
            <span class="player">{{ player.name }}</span>
            <span class="rating" :style="{ color: player.color }">{{ player.rating }}</span>
            <span class="wins">{{ player.wins }}W</span>
          </div>
        </div>
      </section>
    </v-container>
  </div>
</template>

<script>
export default {
  name: 'Play',
  data() {
    return {
      selectedDifficulty: 1,
      gameModes: [
        {
          id: 1,
          icon: '⚔️',
          title: 'DUEL',
          description: 'Face off against a single opponent in intense 1v1 combat',
          players: '2',
          duration: '5-10 min'
        },
        {
          id: 2,
          icon: '👥',
          title: 'SQUAD BATTLE',
          description: 'Lead your team to victory in a 3v3 team skirmish',
          players: '6',
          duration: '10-15 min'
        },
        {
          id: 3,
          icon: '🏆',
          title: 'TOURNAMENT',
          description: 'Compete in a bracket-style tournament for ultimate glory',
          players: '8',
          duration: '30-45 min'
        },
        {
          id: 4,
          icon: '⚡',
          title: 'CHAOS ARENA',
          description: 'Unpredictable chaos mode with random card modifiers',
          players: '4',
          duration: '8-12 min'
        }
      ],
      difficulties: ['EASY', 'NORMAL', 'HARD', 'LEGENDARY'],
      topPlayers: [
        { name: 'SHADOW_STRIKER', rating: 2850, wins: 156, color: '#FFD60A' },
        { name: 'QUANTUM_MASTER', rating: 2720, wins: 143, color: '#00d4ff' },
        { name: 'NEON_PHOENIX', rating: 2680, wins: 138, color: '#FF6B35' },
        { name: 'VOID_SENTINEL', rating: 2640, wins: 131, color: '#9D4EDD' },
        { name: 'CRYSTAL_ECHO', rating: 2580, wins: 125, color: '#06D6A0' }
      ]
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

.modes-section {
  margin-bottom: 4rem;
}

.modes-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 2.5rem;
  margin-bottom: 3rem;
}

.mode-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 2px solid #00d4ff;
  border-radius: 8px;
  padding: 2rem;
  text-align: center;
  transition: all 0.4s ease;
  position: relative;
  overflow: hidden;
}

.mode-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.1), transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: 0;
}

.mode-card:hover {
  border-color: #0066ff;
  box-shadow: 0 0 40px #00d4ff, inset 0 0 20px rgba(0, 212, 255, 0.05);
  transform: translateY(-10px);
}

.mode-card:hover::before {
  opacity: 1;
}

.mode-icon {
  font-size: 3.5rem;
  margin-bottom: 1rem;
  display: block;
  position: relative;
  z-index: 1;
}

.mode-title {
  font-size: 1.4rem;
  color: #fff;
  margin-bottom: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 900;
  position: relative;
  z-index: 1;
}

.mode-description {
  color: #aabbdd;
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  position: relative;
  z-index: 1;
}

.mode-stats {
  color: #88aaff;
  font-size: 0.85rem;
  margin-bottom: 1.5rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  position: relative;
  z-index: 1;
}

.divider {
  margin: 0 0.5rem;
  color: #00d4ff;
}

.play-btn {
  width: 100%;
  padding: 0.75rem 1.5rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  border: none;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
  cursor: pointer;
  transition: all 0.3s ease;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  position: relative;
  z-index: 2;
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
}

.play-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 40px #00d4ff, 0 0 60px rgba(0, 102, 255, 0.3);
}

.play-btn .arrow {
  font-weight: 900;
}

.matchmaking-section {
  margin-bottom: 4rem;
}

.matchmaking-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.15), rgba(0, 20, 50, 0.25));
  border: 2px solid #0066ff;
  border-radius: 8px;
  padding: 3rem;
  box-shadow: 0 0 30px rgba(0, 102, 255, 0.15);
}

.matchmaking-header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.matchmaking-title {
  font-size: 2rem;
  color: #0066ff;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 0.5rem;
  text-shadow: 0 0 15px rgba(0, 102, 255, 0.5);
}

.matchmaking-desc {
  color: #88aaff;
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.matchmaking-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  margin-bottom: 2rem;
}

.skill-selector,
.deck-preview {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.skill-selector label,
.deck-preview label {
  color: #00d4ff;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  font-weight: 700;
}

.difficulty-buttons {
  display: flex;
  gap: 0.75rem;
}

.diff-btn {
  flex: 1;
  padding: 0.75rem;
  background: rgba(0, 212, 255, 0.05);
  border: 1px solid #00d4ff;
  color: #88aaff;
  text-transform: uppercase;
  font-weight: 700;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.3s ease;
  border-radius: 4px;
  letter-spacing: 1px;
}

.diff-btn:hover {
  border-color: #0066ff;
  box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
}

.diff-btn.active {
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  font-weight: 900;
  box-shadow: 0 0 25px #00d4ff;
  border-color: #0066ff;
}

.strength-bar {
  position: relative;
  width: 100%;
  height: 40px;
  background: rgba(0, 0, 0, 0.3);
  border: 1px solid #00d4ff;
  border-radius: 4px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

.strength-fill {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  background: linear-gradient(90deg, #06D6A0, #00d4ff);
  transition: width 0.3s ease;
  z-index: 1;
}

.strength-label {
  position: relative;
  z-index: 2;
  color: #fff;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
  font-size: 0.9rem;
}

.find-opponent-btn {
  width: 100%;
  padding: 1.2rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  border: none;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
  cursor: pointer;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  font-size: 1.1rem;
  transition: all 0.3s ease;
  box-shadow: 0 0 25px rgba(0, 212, 255, 0.3);
}

.find-opponent-btn:hover {
  transform: scale(1.02);
  box-shadow: 0 0 50px #00d4ff, 0 0 80px rgba(0, 102, 255, 0.4);
}

.pulse-icon {
  animation: pulse-play 1s ease-in-out infinite;
}

@keyframes pulse-play {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; }
}

.leaderboard-preview {
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

.rating {
  font-weight: 900;
  text-align: center;
  font-size: 1rem;
  text-shadow: 0 0 10px currentColor;
}

.wins {
  color: #06D6A0;
  text-align: center;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
}

@media (max-width: 1024px) {
  .arena-title {
    font-size: 2.5rem;
  }

  .matchmaking-content {
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

  .modes-grid {
    grid-template-columns: 1fr;
  }

  .matchmaking-card {
    padding: 1.5rem;
  }

  .matchmaking-content {
    grid-template-columns: 1fr;
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
