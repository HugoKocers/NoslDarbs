<template>
  <div class="profile-container">
    <div class="profile-bg"></div>
    
    <v-container class="profile-content">
      <div class="profile-header">
        <div class="header-accent"></div>
        <h1 class="profile-title">COMMANDER PROFILE</h1>
        <p class="profile-subtitle">View your tactical achievements and collection</p>
      </div>

      <div class="profile-grid">
        <!-- Profile Card -->
        <section class="profile-card">
          <div class="avatar-section">
            <div class="avatar">🎴</div>
            <h2 class="username">COMMANDER_ALPHA</h2>
            <p class="level-tag">LEVEL 28</p>
          </div>
          
          <div class="profile-stats">
            <div class="stat-block">
              <span class="stat-value">68%</span>
              <span class="stat-label">WIN RATE</span>
            </div>
            <div class="divider"></div>
            <div class="stat-block">
              <span class="stat-value">156</span>
              <span class="stat-label">BATTLES</span>
            </div>
            <div class="divider"></div>
            <div class="stat-block">
              <span class="stat-value">LEGEND</span>
              <span class="stat-label">RANK</span>
            </div>
          </div>

          <div class="achievement-badges">
            <h3 class="badges-title">ACHIEVEMENTS</h3>
            <div class="badges-grid">
              <div class="badge" v-for="badge in achievements" :key="badge.id">
                <span class="badge-icon">{{ badge.icon }}</span>
                <span class="badge-tooltip">{{ badge.name }}</span>
              </div>
            </div>
          </div>
        </section>

        <!-- Statistics Section -->
        <section class="stats-section">
          <h2 class="section-title">COLLECTION & DECKS</h2>
          
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-icon">📚</div>
              <h3>CARDS COLLECTED</h3>
              <p class="big-number">342</p>
              <p class="stat-desc">Out of 500 total</p>
            </div>
            
            <div class="stat-card">
              <div class="stat-icon">🎯</div>
              <h3>DECKS CREATED</h3>
              <p class="big-number">12</p>
              <p class="stat-desc">3 Active Decks</p>
            </div>
            
            <div class="stat-card">
              <div class="stat-icon">⭐</div>
              <h3>RAREST CARD</h3>
              <p class="big-number">MYTHIC</p>
              <p class="stat-desc">Quantum Overlord</p>
            </div>
          </div>

          <h2 class="section-title mt-5">BATTLE STATISTICS</h2>
          <div class="battle-stats">
            <div class="battle-stat-item">
              <span class="battle-stat-label">Total Wins</span>
              <div class="stat-bar">
                <div class="stat-bar-fill" style="width: 68%"></div>
                <span class="stat-bar-value">106W</span>
              </div>
            </div>
            <div class="battle-stat-item">
              <span class="battle-stat-label">Win Rate by Element</span>
              <div class="element-stats">
                <div class="element-stat" v-for="elem in elementStats" :key="elem.name">
                  <span class="element-name">{{ elem.name }}</span>
                  <div class="element-bar" :style="{ backgroundColor: elem.color }">
                    <span class="element-percent">{{ elem.wins }}%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <section class="decks-section">
        <h2 class="section-title">YOUR ACTIVE DECKS</h2>
        <div class="decks-grid">
          <div class="deck-card" v-for="deck in activeDecks" :key="deck.id">
            <div class="deck-header">
              <span class="deck-name">{{ deck.name }}</span>
              <span class="deck-wins">{{ deck.wins }}W {{ deck.losses }}L</span>
            </div>
            <div class="deck-elements">
              <span v-for="elem in deck.elements" :key="elem" class="element-chip" :style="{ backgroundColor: getElementColor(elem) }">
                {{ elem }}
              </span>
            </div>
            <div class="deck-cards">
              <span>{{ deck.cardCount }} Cards</span>
            </div>
            <button class="deck-btn">
              <span>EDIT DECK</span>
              <span class="icon">✎</span>
            </button>
          </div>
        </div>
      </section>
    </v-container>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  data() {
    return {
      achievements: [
        { id: 1, icon: '🎯', name: 'First Victory' },
        { id: 2, icon: '⚡', name: 'Lightning Strike' },
        { id: 3, icon: '🔥', name: 'Pyromancer' },
        { id: 4, icon: '🏆', name: 'Champion' },
        { id: 5, icon: '👑', name: 'Legend' },
        { id: 6, icon: '💎', name: 'Collector' },
      ],
      elementStats: [
        { name: 'FIRE', wins: 75, color: '#FF6B35' },
        { name: 'WATER', wins: 70, color: '#00A8E8' },
        { name: 'NATURE', wins: 68, color: '#06D6A0' },
        { name: 'LIGHTNING', wins: 72, color: '#FFD60A' },
        { name: 'DARK', wins: 65, color: '#9D4EDD' },
        { name: 'LIGHT', wins: 74, color: '#3A86FF' },
      ],
      activeDecks: [
        { id: 1, name: 'INFERNO ASSAULT', wins: 28, losses: 9, elements: ['FIRE', 'LIGHTNING'], cardCount: 30 },
        { id: 2, name: 'CRYSTAL TIDE', wins: 24, losses: 12, elements: ['WATER', 'LIGHT'], cardCount: 30 },
        { id: 3, name: 'VOID WHISPER', wins: 22, losses: 15, elements: ['DARK', 'NATURE'], cardCount: 30 },
      ]
    }
  },
  methods: {
    getElementColor(element) {
      const colors = {
        'FIRE': '#FF6B35',
        'WATER': '#00A8E8',
        'NATURE': '#06D6A0',
        'LIGHTNING': '#FFD60A',
        'DARK': '#9D4EDD',
        'LIGHT': '#3A86FF'
      };
      return colors[element] || '#8B8B8B';
    }
  }
}
</script>

<style scoped>
.profile-container {
  position: relative;
  background: #000;
  color: #fff;
  overflow-x: hidden;
  min-height: 100vh;
}

.profile-bg {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.03) 0%, transparent 50%);
  pointer-events: none;
  z-index: 0;
}

.profile-content {
  position: relative;
  z-index: 1;
  padding: 4rem 2rem !important;
}

.profile-header {
  text-align: center;
  margin-bottom: 4rem;
  position: relative;
}

.header-accent {
  width: 80px;
  height: 3px;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  margin: 0 auto 1.5rem;
}

.profile-title {
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

.profile-subtitle {
  font-size: 1.1rem;
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.profile-grid {
  display: grid;
  grid-template-columns: 350px 1fr;
  gap: 3rem;
  margin-bottom: 4rem;
  width: 100%;
}

.profile-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 2px solid #00d4ff;
  border-radius: 8px;
  padding: 2.5rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.15);
  position: relative;
  overflow: hidden;
}

.profile-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.05), transparent);
  z-index: 0;
}

.avatar-section {
  position: relative;
  z-index: 1;
  text-align: center;
}

.avatar {
  font-size: 5rem;
  margin-bottom: 1rem;
  display: block;
  filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.4));
}

.username {
  font-size: 1.8rem;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 0.5rem;
  font-weight: 900;
  max-width: 280px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.level-tag {
  display: inline-block;
  padding: 0.5rem 1rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  text-transform: uppercase;
  font-weight: 900;
  border-radius: 4px;
  font-size: 0.85rem;
  letter-spacing: 1px;
  box-shadow: 0 0 15px #00d4ff;
  margin: 0;
}

.profile-stats {
  width: 100%;
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 1.5rem;
  background: rgba(0, 0, 0, 0.3);
  border-radius: 4px;
  position: relative;
  z-index: 1;
}

.stat-block {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
}

.stat-value {
  font-size: 1.8rem;
  color: #00d4ff;
  font-weight: 900;
  text-shadow: 0 0 15px #00d4ff;
}

.stat-label {
  font-size: 0.75rem;
  color: #6688cc;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.divider {
  width: 1px;
  height: 40px;
  background: linear-gradient(180deg, transparent, #00d4ff, transparent);
}

.achievement-badges {
  width: 100%;
  position: relative;
  z-index: 1;
  border-top: 1px solid rgba(0, 212, 255, 0.2);
  padding-top: 1.5rem;
}

.badges-title {
  font-size: 0.9rem;
  text-transform: uppercase;
  color: #00d4ff;
  letter-spacing: 1px;
  margin-bottom: 1rem;
  font-weight: 700;
}

.badges-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
}

.badge {
  position: relative;
  cursor: pointer;
}

.badge-icon {
  font-size: 2.5rem;
  display: block;
  text-align: center;
  filter: drop-shadow(0 0 10px rgba(255, 214, 10, 0.3));
  transition: all 0.3s ease;
}

.badge:hover .badge-icon {
  filter: drop-shadow(0 0 20px rgba(255, 214, 10, 0.8));
  transform: scale(1.2);
}

.badge-tooltip {
  position: absolute;
  bottom: -30px;
  left: 50%;
  transform: translateX(-50%);
  background: #000;
  border: 1px solid #00d4ff;
  padding: 0.5rem 0.75rem;
  border-radius: 4px;
  font-size: 0.75rem;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #00d4ff;
}

.badge:hover .badge-tooltip {
  opacity: 1;
}

.stats-section {
  position: relative;
  z-index: 1;
}

.section-title {
  font-size: 1.5rem;
  text-transform: uppercase;
  color: #00d4ff;
  letter-spacing: 2px;
  margin-bottom: 2rem;
  text-shadow: 0 0 15px rgba(0, 212, 255, 0.5);
}

.mt-5 {
  margin-top: 3rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
}

.stat-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.15), rgba(0, 20, 50, 0.25));
  border: 1px solid #00d4ff;
  border-radius: 8px;
  padding: 2rem;
  text-align: center;
  transition: all 0.3s ease;
}

.stat-card:hover {
  border-color: #0066ff;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.2);
  transform: translateY(-5px);
}

.stat-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  display: block;
}

.stat-card h3 {
  font-size: 1rem;
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 0.75rem;
  font-weight: 700;
}

.big-number {
  font-size: 2.5rem;
  color: #00d4ff;
  font-weight: 900;
  margin-bottom: 0.5rem;
  text-shadow: 0 0 15px #00d4ff;
}

.stat-desc {
  font-size: 0.85rem;
  color: #6688cc;
}

.battle-stats {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.15), rgba(0, 20, 50, 0.25));
  border: 1px solid #00d4ff;
  border-radius: 8px;
  padding: 2rem;
  gap: 2rem;
}

.battle-stat-item {
  margin-bottom: 2rem;
}

.battle-stat-item:last-child {
  margin-bottom: 0;
}

.battle-stat-label {
  display: block;
  color: #00d4ff;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 1rem;
  font-weight: 700;
}

.stat-bar {
  position: relative;
  height: 40px;
  background: rgba(0, 0, 0, 0.3);
  border: 1px solid #00d4ff;
  border-radius: 4px;
  overflow: hidden;
  display: flex;
  align-items: center;
}

.stat-bar-fill {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  z-index: 1;
}

.stat-bar-value {
  position: relative;
  z-index: 2;
  margin-left: 1rem;
  color: #fff;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.element-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 1.5rem;
  width: 100%;
}

.element-stat {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.element-name {
  color: #88aaff;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 700;
}

.element-bar {
  position: relative;
  height: 30px;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0.8;
  transition: all 0.3s ease;
}

.element-bar:hover {
  opacity: 1;
  box-shadow: 0 0 20px currentColor;
}

.element-percent {
  color: #fff;
  font-weight: 900;
  font-size: 0.85rem;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
}

.decks-section {
  position: relative;
  z-index: 1;
  margin-top: 4rem;
}

.decks-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2.5rem;
}

.deck-card {
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 2px solid #00d4ff;
  border-radius: 8px;
  padding: 2rem;
  transition: all 0.4s ease;
  position: relative;
  overflow: hidden;
}

.deck-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.1), transparent);
  transition: left 0.5s ease;
  z-index: 0;
}

.deck-card:hover {
  border-color: #0066ff;
  box-shadow: 0 0 40px #00d4ff;
  transform: translateY(-10px);
}

.deck-card:hover::before {
  left: 100%;
}

.deck-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  border-bottom: 1px solid rgba(0, 212, 255, 0.2);
  padding-bottom: 1rem;
  position: relative;
  z-index: 1;
}

.deck-name {
  font-size: 1.3rem;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 900;
}

.deck-wins {
  color: #00d4ff;
  font-size: 0.95rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 700;
}

.deck-elements {
  display: flex;
  gap: 0.75rem;
  margin-bottom: 1rem;
  position: relative;
  z-index: 1;
  flex-wrap: wrap;
}

.element-chip {
  padding: 0.4rem 0.8rem;
  border-radius: 4px;
  color: #000;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 0 10px currentColor;
}

.deck-cards {
  color: #88aaff;
  font-size: 0.9rem;
  margin-bottom: 1.5rem;
  position: relative;
  z-index: 1;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.deck-btn {
  width: 100%;
  padding: 0.75rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  border: none;
  border-radius: 4px;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  position: relative;
  z-index: 2;
  box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
}

.deck-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 30px #00d4ff;
}

.icon {
  font-size: 1.1rem;
}

@media (max-width: 1024px) {
  .profile-grid {
    grid-template-columns: 1fr;
  }

  .profile-title {
    font-size: 2.5rem;
  }
}

@media (max-width: 768px) {
  .profile-content {
    padding: 2rem 1rem !important;
  }

  .profile-title {
    font-size: 2rem;
  }

  .profile-grid {
    grid-template-columns: 1fr;
  }

  .profile-stats {
    flex-direction: row;
    gap: 1rem;
    justify-content: space-around;
  }

  .divider {
    width: 1px;
    height: 40px;
  }

  .decks-grid {
    grid-template-columns: 1fr;
  }

  .stats-grid {
    grid-template-columns: 1fr;
  }

  .element-stats {
    grid-template-columns: 1fr;
  }
}
</style>
