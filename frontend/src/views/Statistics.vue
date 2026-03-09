<template>
  <div class="stats-container">
    <div class="animated-bg"></div>

    <v-container class="stats-content">
      <!-- Header -->
      <div class="stats-header">
        <h1 class="stats-title">PLAYER STATISTICS</h1>
        <p class="stats-subtitle">Career Overview & Achievements</p>
      </div>

      <!-- Stats Grid -->
      <div class="stats-grid">
        <!-- Primary Stats -->
        <div class="stat-card primary">
          <div class="stat-icon">⚔️</div>
          <div class="stat-info">
            <h3 class="stat-label">Total Battles</h3>
            <p class="stat-value">{{ playerStats.totalBattles }}</p>
          </div>
        </div>

        <div class="stat-card primary">
          <div class="stat-icon">🏆</div>
          <div class="stat-info">
            <h3 class="stat-label">Wins</h3>
            <p class="stat-value">{{ playerStats.wins }}</p>
          </div>
        </div>

        <div class="stat-card primary">
          <div class="stat-icon">❌</div>
          <div class="stat-info">
            <h3 class="stat-label">Losses</h3>
            <p class="stat-value">{{ playerStats.losses }}</p>
          </div>
        </div>

        <div class="stat-card primary">
          <div class="stat-icon">📊</div>
          <div class="stat-info">
            <h3 class="stat-label">Win Rate</h3>
            <p class="stat-value">{{ winRate }}%</p>
          </div>
        </div>
      </div>

      <!-- Secondary Stats -->
      <div class="secondary-stats">
        <div class="stats-section">
          <h2 class="section-title">Card Collection</h2>
          <div class="section-grid">
            <div class="mini-stat">
              <span class="mini-label">Total Cards</span>
              <span class="mini-value">{{ playerStats.totalCards }}</span>
            </div>
            <div class="mini-stat">
              <span class="mini-label">Unique Cards</span>
              <span class="mini-value">{{ playerStats.uniqueCards }}</span>
            </div>
            <div class="mini-stat">
              <span class="mini-label">Legendary Cards</span>
              <span class="mini-value">{{ playerStats.legendaryCards }}</span>
            </div>
          </div>
        </div>

        <div class="stats-section">
          <h2 class="section-title">Element Mastery</h2>
          <div class="element-stats">
            <div v-for="element in elements" :key="element.name" class="element-card">
              <div class="element-name">{{ element.name }}</div>
              <div class="element-bar">
                <div class="element-fill" :style="{ width: element.percentage + '%', backgroundImage: `linear-gradient(90deg, ${element.color}, ${element.color}dd)` }"></div>
              </div>
              <div class="element-count">{{ element.count }} cards</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Achievements -->
      <div class="achievements-section">
        <h2 class="section-title">Achievements</h2>
        <div class="achievements-grid">
          <div v-for="achievement in achievements" :key="achievement.id" class="achievement-badge" :title="achievement.description">
            <div class="achievement-icon">{{ achievement.icon }}</div>
            <div class="achievement-name">{{ achievement.name }}</div>
          </div>
        </div>
      </div>
    </v-container>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useAuthStore } from '@/stores/authStore'

const authStore = useAuthStore()

const playerStats = ref({
  totalBattles: 42,
  wins: 28,
  losses: 14,
  totalCards: 187,
  uniqueCards: 45,
  legendaryCards: 3
})

const winRate = computed(() => {
  if (playerStats.value.totalBattles === 0) return 0
  return Math.round((playerStats.value.wins / playerStats.value.totalBattles) * 100)
})

const elements = ref([
  { name: 'Fire', count: 32, percentage: 100, color: '#FF6B35' },
  { name: 'Water', count: 28, percentage: 87.5, color: '#00A8E8' },
  { name: 'Nature', count: 25, percentage: 78.1, color: '#06D6A0' },
  { name: 'Lightning', count: 30, percentage: 93.75, color: '#FFD60A' },
  { name: 'Dark', count: 22, percentage: 68.75, color: '#9D4EDD' },
  { name: 'Light', count: 20, percentage: 62.5, color: '#3A86FF' }
])

const achievements = ref([
  { id: 1, name: 'First Blood', icon: '⚔️', description: 'Win your first battle' },
  { id: 2, name: 'Collector', icon: '🎴', description: 'Collect 50 unique cards' },
  { id: 3, name: 'Master', icon: '👑', description: 'Reach 30 wins' },
  { id: 4, name: 'Element Master', icon: '🔥', description: 'Max out one element' },
  { id: 5, name: 'Lucky Strike', icon: '⭐', description: 'Win 5 battles in a row' },
  { id: 6, name: 'Legendary', icon: '💎', description: 'Obtain a legendary card' }
])
</script>

<style scoped>
.stats-container {
  position: relative;
  z-index: 0;
  min-height: 100vh;
  background: #000;
  color: #fff;
  padding: 6rem 0 2rem 0;
  overflow-y: visible;
}

.animated-bg {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.03) 0%, transparent 50%);
  pointer-events: none;
  z-index: 0;
}

.stats-content {
  position: relative;
  z-index: 1;
}

.stats-header {
  text-align: center;
  margin-bottom: 3rem;
}

.stats-title {
  font-size: 2.5rem;
  font-weight: 900;
  background: linear-gradient(90deg, #00d4ff, #0066ff, #00d4ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.stats-subtitle {
  font-size: 1.1rem;
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.stat-card {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding: 2rem;
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.3), rgba(0, 20, 50, 0.5));
  border: 2px solid #00d4ff;
  border-radius: 0;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.2);
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 50px rgba(0, 212, 255, 0.3);
}

.stat-icon {
  font-size: 3rem;
  min-width: 80px;
}

.stat-info {
  flex: 1;
}

.stat-label {
  font-size: 0.9rem;
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin: 0 0 0.5rem 0;
}

.stat-value {
  font-size: 2.5rem;
  font-weight: 900;
  color: #00d4ff;
  text-shadow: 0 0 15px rgba(0, 212, 255, 0.5);
  margin: 0;
}

.secondary-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
}

.stats-section {
  padding: 2rem;
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.4));
  border: 1px solid #00d4ff;
  border-radius: 0;
}

.section-title {
  font-size: 1.3rem;
  text-transform: uppercase;
  color: #00d4ff;
  letter-spacing: 1px;
  margin: 0 0 1.5rem 0;
}

.section-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
}

.mini-stat {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1rem;
  background: rgba(0, 0, 0, 0.3);
  border: 1px solid rgba(0, 212, 255, 0.2);
}

.mini-label {
  font-size: 0.8rem;
  color: #666;
  text-transform: uppercase;
}

.mini-value {
  font-size: 1.8rem;
  font-weight: 900;
  color: #00d4ff;
}

.element-stats {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.element-card {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.element-name {
  font-size: 0.9rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.element-bar {
  height: 24px;
  background: rgba(0, 0, 0, 0.4);
  border: 1px solid rgba(0, 212, 255, 0.2);
  overflow: hidden;
}

.element-fill {
  height: 100%;
  transition: width 0.3s ease;
}

.element-count {
  font-size: 0.8rem;
  color: #888;
}

.achievements-section {
  padding: 2rem;
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.4));
  border: 1px solid #00d4ff;
  border-radius: 0;
}

.achievements-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
  gap: 1.5rem;
}

.achievement-badge {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  padding: 1.5rem;
  background: linear-gradient(135deg, rgba(255, 214, 10, 0.1), rgba(157, 78, 221, 0.1));
  border: 2px solid #FFD60A;
  border-radius: 0;
  text-align: center;
  transition: all 0.3s ease;
  cursor: pointer;
}

.achievement-badge:hover {
  transform: scale(1.05);
  box-shadow: 0 0 20px rgba(255, 214, 10, 0.3);
}

.achievement-icon {
  font-size: 2.5rem;
}

.achievement-name {
  font-size: 0.85rem;
  font-weight: 700;
  color: #FFD60A;
  text-transform: uppercase;
  letter-spacing: 1px;
}

@media (max-width: 768px) {
  .stats-title {
    font-size: 1.8rem;
  }

  .stats-grid {
    grid-template-columns: 1fr 1fr;
  }

  .stat-card {
    flex-direction: column;
    text-align: center;
  }

  .section-grid {
    grid-template-columns: 1fr;
  }

  .achievements-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}
</style>
