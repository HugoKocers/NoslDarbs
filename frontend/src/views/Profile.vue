<template>
  <div class="profile-container">
    <div class="profile-bg"></div>
    
    <v-container class="profile-content">
      <div class="profile-header">
        <div class="header-accent"></div>
          <h1 class="profile-title">{{ i18n.t.playerProfile }}</h1>
        <p class="profile-subtitle">{{ i18n.t.trackProgress }}</p>
      </div>

      <div class="profile-grid">
        <!-- Profile Card -->
        <section class="profile-card">
          <div class="avatar-section">
            <div class="avatar">🎴</div>
            <h2 class="username">{{ userName }}</h2>
            <p class="level-tag">LEVEL {{ userLevel }}</p>
          </div>
          
          <div class="profile-stats">
            <div class="stat-block">
              <span class="stat-value">{{ totalGames }}</span>
              <span class="stat-label">{{ i18n.t.gamesPlayed }}</span>
            </div>
            <div class="divider"></div>
            <div class="stat-block">
              <span class="stat-value">{{ highestScore }}</span>
              <span class="stat-label">{{ i18n.t.highScore }}</span>
            </div>
            <div class="divider"></div>
            <div class="stat-block">
              <span class="stat-value">{{ totalExperience }}</span>
              <span class="stat-label">{{ i18n.t.totalPoints }}</span>
            </div>
          </div>
        </section>

        <!-- Collection Section -->
        <section class="stats-section">
          <h2 class="section-title">{{ i18n.t.yourCollection }}</h2>
          
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-icon">📚</div>
              <h3>{{ i18n.t.cardsDiscovered }}</h3>
              <p class="big-number">{{ cardsUnlockedCount }}</p>
              <p class="stat-desc">{{ i18n.t.collectMore }}</p>
            </div>
            
            <div class="stat-card">
              <div class="stat-icon">🎮</div>
              <h3>{{ i18n.t.averageScore }}</h3>
              <p class="big-number">{{ averageScore }}</p>
              <p class="stat-desc">{{ i18n.t.perGame }}</p>
            </div>
          </div>
        </section>
      </div>
    </v-container>
  </div>
</template>

<script>
import { useAuthStore } from '@/stores/authStore'
import { useI18nStore } from '@/stores/i18nStore'

export default {
  name: 'Profile',
  setup() {
    const authStore = useAuthStore()
    const i18n = useI18nStore()
    return { authStore, i18n }
  },
  data() {
    return {
    }
  },
  computed: {
    userName() {
      return this.authStore.user?.name || 'PLAYER'
    },
    userLevel() {
      return this.authStore.user?.level || 1
    },
    totalGames() {
      return this.authStore.user?.totalGames || 0
    },
    highestScore() {
      return this.authStore.user?.highestScore || 0
    },
    totalExperience() {
      return this.authStore.user?.experience || 0
    },
    cardsUnlockedCount() {
      return this.authStore.user?.cardsUnlockedCount || 0
    },
    averageScore() {
      if (!this.totalGames) return 0
      return Math.round(this.totalExperience / this.totalGames)
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
    },
    async refreshStats() {
      await this.authStore.fetchGameStats()
      await this.authStore.fetchUserCards()
    }
  },
  mounted() {
    this.refreshStats()
  },
  activated() {
    // Refresh stats every time the page is activated (navigated to)
    this.refreshStats()
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
  padding: 6rem 2rem !important;
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
  text-align: center;
  gap: 0.75rem;
}

.stat-value {
  font-size: 1.8rem;
  color: #00d4ff;
  font-weight: 900;
  text-shadow: 0 0 15px #00d4ff;
  line-height: 1;
  display: block;
  width: 100%;
}

.stat-label {
  font-size: 0.75rem;
  color: #6688cc;
  text-transform: uppercase;
  letter-spacing: 1px;
  line-height: 1.4;
  display: block;
  width: 100%;
}

.divider {
  width: 1px;
  height: 40px;
  background: linear-gradient(180deg, transparent, #00d4ff, transparent);
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

  .stats-grid {
    grid-template-columns: 1fr;
  }
}
</style>
