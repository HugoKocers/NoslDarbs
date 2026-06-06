<template>
  <v-container class="leaderboard-container py-12">
    <div class="leaderboard-shell">
      <div class="leaderboard-header">
        <div class="title-block">
          <span class="eyebrow">HIGHSCORE GRID</span>
          <h1 class="page-title">{{ i18n.t.leaderboard }}</h1>
          <p class="page-copy">
            {{ i18n.language === 'LV'
              ? 'Top spēlētāji pēc pieredzes punktiem'
              : 'Top players ranked by experience score' }}
          </p>
        </div>

        <div class="stat-row">
          <div class="stat-card">
            <span class="stat-label">{{ i18n.language === 'LV' ? 'Līderi' : 'Leaders' }}</span>
            <span class="stat-value">{{ leaderboard.length }}</span>
          </div>
          <div class="stat-card">
            <span class="stat-label">{{ i18n.language === 'LV' ? 'Augstākais rezultāts' : 'Top score' }}</span>
            <span class="stat-value">{{ leaderboard[0]?.experience ?? '—' }}</span>
          </div>
        </div>
      </div>

      <v-alert v-if="error" type="error" class="error-alert">
        {{ error }}
      </v-alert>

      <div v-if="loading" class="loading-container">
        <v-progress-circular indeterminate size="64" color="#00d4ff"></v-progress-circular>
        <p class="loading-text">{{ i18n.language === 'LV' ? 'Lejupielādē līderu sarakstu...' : 'Loading leaderboard...' }}</p>
      </div>

      <div v-else>
        <table class="leaderboard-table">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ i18n.language === 'LV' ? 'Spēlētājs' : 'Player' }}</th>
              <th>{{ i18n.language === 'LV' ? 'Līmenis' : 'Level' }}</th>
              <th>{{ i18n.language === 'LV' ? 'Rezultāts' : 'Score' }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(player, index) in leaderboard" :key="player.id" :class="{ 'top-rank': index < 3 }">
              <td>
                <span class="rank-badge" :class="`rank-${index + 1}`">{{ index + 1 }}</span>
              </td>
              <td>{{ player.name }}</td>
              <td>{{ player.level }}</td>
              <td>{{ player.experience }}</td>
            </tr>
          </tbody>
        </table>

        <div v-if="leaderboard.length === 0" class="no-results">
          <p>{{ i18n.language === 'LV' ? 'Līderu saraksts vēl nav pieejams.' : 'No leaderboard data available yet.' }}</p>
        </div>
      </div>
    </div>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useI18nStore } from '@/stores/i18nStore'
import { gameService } from '@/services/api'

const i18n = useI18nStore()
const leaderboard = ref([])
const loading = ref(false)
const error = ref(null)

const fetchLeaderboard = async () => {
  loading.value = true
  error.value = null

  try {
    const response = await gameService.getLeaderboard(10)
    leaderboard.value = response.data.leaderboard || []
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to load leaderboard'
    console.error(err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchLeaderboard)
</script>

<style scoped>
.leaderboard-container {
  max-width: 1160px;
  margin: 0 auto;
  padding: 0 1rem;
}

.leaderboard-shell {
  position: relative;
  padding: 2.5rem;
  border-radius: 32px;
  background: radial-gradient(circle at top left, rgba(0, 212, 255, 0.14), transparent 28%),
    radial-gradient(circle at bottom right, rgba(103, 165, 255, 0.1), transparent 26%),
    linear-gradient(180deg, rgba(2, 8, 22, 1) 0%, rgba(6, 12, 38, 0.94) 100%);
  border: 1px solid rgba(0, 212, 255, 0.24);
  box-shadow: 0 0 80px rgba(0, 212, 255, 0.12), inset 0 0 120px rgba(0, 84, 170, 0.04);
  overflow: hidden;
}

.leaderboard-shell::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: linear-gradient(90deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0.06) 50%, rgba(255,255,255,0.02) 100%);
  opacity: 0.08;
  pointer-events: none;
  mix-blend-mode: screen;
}

.leaderboard-shell > * {
  position: relative;
  z-index: 1;
}

.leaderboard-header {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 1.5rem;
  align-items: flex-start;
  margin-bottom: 2rem;
}

.title-block {
  max-width: 720px;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.eyebrow {
  color: #5de9ff;
  font-size: 0.75rem;
  letter-spacing: 0.25em;
  text-transform: uppercase;
}

.page-title {
  font-size: clamp(2.2rem, 4vw, 3.75rem);
  color: #eaf5ff;
  line-height: 1.05;
  letter-spacing: 0.05em;
  margin: 0;
  text-shadow: 0 0 20px rgba(0, 212, 255, 0.18);
}

.page-copy {
  color: #a4c6dc;
  max-width: 640px;
  line-height: 1.8;
}

.stat-row {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1rem;
  width: min(100%, 320px);
}

.stat-card {
  padding: 1.6rem 1.4rem;
  border-radius: 22px;
  background: rgba(4, 12, 30, 0.92);
  border: 1px solid rgba(0, 212, 255, 0.18);
  box-shadow: inset 0 0 18px rgba(0, 212, 255, 0.1);
}

.stat-label {
  display: block;
  color: #7fd9ff;
  font-size: 0.78rem;
  text-transform: uppercase;
  letter-spacing: 0.18em;
  margin-bottom: 0.65rem;
}

.stat-value {
  font-size: 2rem;
  font-weight: 800;
  color: #f4fbff;
}

.leaderboard-table {
  width: 100%;
  border-collapse: collapse;
  min-width: 320px;
  background: rgba(5, 10, 20, 0.96);
  border: 1px solid rgba(0, 170, 255, 0.2);
  border-radius: 18px;
  overflow: hidden;
  box-shadow: inset 0 0 32px rgba(0, 162, 255, 0.08);
}

.leaderboard-table thead tr {
  background: rgba(0, 212, 255, 0.06);
}

.leaderboard-table th,
.leaderboard-table td {
  padding: 1rem 1.35rem;
  color: #cbe6ff;
  text-align: left;
  font-size: 0.95rem;
}

.leaderboard-table th {
  color: #8cd3ff;
  font-weight: 700;
  letter-spacing: 0.14em;
  text-transform: uppercase;
}

.leaderboard-table tbody tr {
  transition: background 0.24s ease, transform 0.24s ease;
}

.leaderboard-table tbody tr:hover {
  background: rgba(0, 212, 255, 0.08);
  transform: translateX(2px);
}

.leaderboard-table tbody tr:nth-child(even) {
  background: rgba(255, 255, 255, 0.015);
}

.rank-badge {
  display: inline-flex;
  min-width: 2.6rem;
  justify-content: center;
  align-items: center;
  border-radius: 999px;
  padding: 0.55rem 0.75rem;
  color: #fff;
  font-weight: 800;
  background: rgba(0, 212, 255, 0.16);
  border: 1px solid rgba(0, 212, 255, 0.22);
}

.rank-1 {
  background: linear-gradient(135deg, rgba(0, 212, 255, 0.32), rgba(26, 194, 255, 0.2));
}

.rank-2 {
  background: linear-gradient(135deg, rgba(72, 206, 255, 0.28), rgba(0, 152, 255, 0.18));
}

.rank-3 {
  background: linear-gradient(135deg, rgba(67, 134, 255, 0.28), rgba(0, 116, 255, 0.16));
}

.no-results,
.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  padding: 2rem;
  color: #a3c4ff;
}

.loading-text {
  color: #a3c4ff;
}

.error-alert {
  max-width: 100%;
}

@media (max-width: 980px) {
  .leaderboard-header {
    flex-direction: column;
    align-items: stretch;
  }

  .stat-row {
    width: 100%;
  }
}

@media (max-width: 640px) {
  .leaderboard-shell {
    padding: 1.5rem;
  }

  .leaderboard-table th,
  .leaderboard-table td {
    padding: 0.85rem 0.95rem;
  }

  .page-title {
    font-size: 2.2rem;
  }
}
</style>
