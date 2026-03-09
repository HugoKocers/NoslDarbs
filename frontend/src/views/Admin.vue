<template>
  <div class="admin-container">
    <div class="animated-bg"></div>

    <v-container class="admin-content">
      <!-- Header -->
      <div class="admin-header">
        <h1 class="admin-title">ADMIN PANEL</h1>
        <p class="admin-subtitle">System Management & Control</p>
      </div>

      <!-- Tab Navigation -->
      <div class="admin-tabs">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="['tab-btn', { active: activeTab === tab.id }]"
          :aria-label="`${tab.name} management`"
          :aria-selected="activeTab === tab.id"
        >
          <span class="tab-icon">{{ tab.icon }}</span>
          <span>{{ tab.name }}</span>
        </button>
      </div>

      <!-- Cards Management -->
      <div v-show="activeTab === 'cards'" class="tab-content">
        <div class="section-header">
          <h2>Card Management</h2>
          <button @click="showCardForm = !showCardForm" class="action-btn">
            <span v-if="!showCardForm">+ ADD CARD</span>
            <span v-else>CLOSE FORM</span>
          </button>
        </div>

        <!-- Add/Edit Card Form -->
        <div v-if="showCardForm" class="form-section">
          <h3>{{ editingCard ? 'Edit Card' : 'Create New Card' }}</h3>
          <form @submit.prevent="saveCard" class="admin-form">
            <div class="form-row">
              <input v-model="cardForm.name" type="text" placeholder="Card Name" required class="form-input" />
              <input v-model="cardForm.power" type="number" placeholder="Power Level" required class="form-input" />
            </div>
            <div class="form-row">
              <select v-model="cardForm.element" required class="form-input">
                <option value="">Select Element</option>
                <option value="Fire">Fire</option>
                <option value="Water">Water</option>
                <option value="Nature">Nature</option>
                <option value="Lightning">Lightning</option>
                <option value="Dark">Dark</option>
                <option value="Light">Light</option>
              </select>
              <input v-model="cardForm.rarity" type="text" placeholder="Rarity (Common, Rare, Legendary)" required class="form-input" />
            </div>
            <textarea v-model="cardForm.description" placeholder="Card Description" class="form-input" style="resize: vertical;"></textarea>
            <div class="form-actions">
              <button type="submit" class="btn-primary">{{ editingCard ? 'UPDATE CARD' : 'CREATE CARD' }}</button>
              <button type="button" @click="resetCardForm" class="btn-secondary">CANCEL</button>
            </div>
          </form>
        </div>

        <!-- Cards List -->
        <div class="table-section">
          <table class="admin-table" role="table">
            <thead>
              <tr role="row">
                <th role="columnheader">ID</th>
                <th role="columnheader">Name</th>
                <th role="columnheader">Element</th>
                <th role="columnheader">Power</th>
                <th role="columnheader">Rarity</th>
                <th role="columnheader">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="card in mockCards" :key="card.id" role="row">
                <td>{{ card.id }}</td>
                <td>{{ card.name }}</td>
                <td>{{ card.element }}</td>
                <td>{{ card.power }}</td>
                <td>{{ card.rarity }}</td>
                <td class="action-cell">
                  <button @click="editCard(card)" class="btn-edit" aria-label="Edit card">✎</button>
                  <button @click="deleteCard(card.id)" class="btn-delete" aria-label="Delete card">✕</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Users Management -->
      <div v-show="activeTab === 'users'" class="tab-content">
        <div class="section-header">
          <h2>User Management</h2>
          <span class="user-count">Total Users: {{ mockUsers.length }}</span>
        </div>

        <div class="table-section">
          <table class="admin-table" role="table">
            <thead>
              <tr role="row">
                <th role="columnheader">ID</th>
                <th role="columnheader">Name</th>
                <th role="columnheader">Email</th>
                <th role="columnheader">Role</th>
                <th role="columnheader">Joined</th>
                <th role="columnheader">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in mockUsers" :key="user.id" role="row">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                  <span :class="['role-badge', user.role]">{{ user.role }}</span>
                </td>
                <td>{{ user.joined }}</td>
                <td class="action-cell">
                  <button @click="changeUserRole(user)" class="btn-edit" aria-label="Change user role">⚙️</button>
                  <button @click="deleteUser(user.id)" class="btn-delete" aria-label="Delete user">✕</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Battles Management -->
      <div v-show="activeTab === 'battles'" class="tab-content">
        <div class="section-header">
          <h2>Battle Management</h2>
          <span class="user-count">Total Battles: {{ mockBattles.length }}</span>
        </div>

        <div class="table-section">
          <table class="admin-table" role="table">
            <thead>
              <tr role="row">
                <th role="columnheader">ID</th>
                <th role="columnheader">Player 1</th>
                <th role="columnheader">Player 2</th>
                <th role="columnheader">Winner</th>
                <th role="columnheader">Status</th>
                <th role="columnheader">Date</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="battle in mockBattles" :key="battle.id" role="row">
                <td>{{ battle.id }}</td>
                <td>{{ battle.player1 }}</td>
                <td>{{ battle.player2 }}</td>
                <td>{{ battle.winner }}</td>
                <td>
                  <span :class="['status-badge', battle.status]">{{ battle.status }}</span>
                </td>
                <td>{{ battle.date }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- System Statistics -->
      <div v-show="activeTab === 'stats'" class="tab-content">
        <div class="section-header">
          <h2>System Statistics</h2>
        </div>

        <div class="stats-grid">
          <div class="stat-box">
            <div class="stat-number">{{ mockUsers.length }}</div>
            <div class="stat-desc">Total Users</div>
          </div>
          <div class="stat-box">
            <div class="stat-number">{{ mockCards.length }}</div>
            <div class="stat-desc">Total Cards</div>
          </div>
          <div class="stat-box">
            <div class="stat-number">{{ mockBattles.length }}</div>
            <div class="stat-desc">Total Battles</div>
          </div>
          <div class="stat-box">
            <div class="stat-number">{{ avgPower }}</div>
            <div class="stat-desc">Avg Card Power</div>
          </div>
        </div>

        <div class="log-section">
          <h3>Recent Activity Log</h3>
          <div class="activity-log">
            <div v-for="(log, index) in activityLogs" :key="index" class="log-entry">
              <span class="log-time">{{ log.time }}</span>
              <span class="log-action">{{ log.action }}</span>
              <span class="log-user">by {{ log.user }}</span>
            </div>
          </div>
        </div>
      </div>
    </v-container>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeTab = ref('cards')
const showCardForm = ref(false)
const editingCard = ref(null)

const tabs = [
  { id: 'cards', name: 'Cards', icon: '🎴' },
  { id: 'users', name: 'Users', icon: '👥' },
  { id: 'battles', name: 'Battles', icon: '⚔️' },
  { id: 'stats', name: 'Statistics', icon: '📊' }
]

const cardForm = ref({
  name: '',
  power: '',
  element: '',
  rarity: '',
  description: ''
})

const mockCards = ref([
  { id: 1, name: 'Inferno Dragon', power: 85, element: 'Fire', rarity: 'Legendary', description: 'Ancient fire dragon' },
  { id: 2, name: 'Tsunami', power: 78, element: 'Water', rarity: 'Rare', description: 'Powerful water wave' },
  { id: 3, name: 'Forest Guardian', power: 82, element: 'Nature', rarity: 'Rare', description: 'Nature protector' }
])

const mockUsers = ref([
  { id: 1, name: 'Admin', email: 'admin@cardquest.com', role: 'admin', joined: '2025-01-01' },
  { id: 2, name: 'Player One', email: 'player1@cardquest.com', role: 'user', joined: '2025-01-15' },
  { id: 3, name: 'Player Two', email: 'player2@cardquest.com', role: 'user', joined: '2025-02-01' }
])

const mockBattles = ref([
  { id: 1, player1: 'Player One', player2: 'Player Two', winner: 'Player One', status: 'Completed', date: '2025-03-01' },
  { id: 2, player1: 'Player One', player2: 'Admin', winner: 'Admin', status: 'Completed', date: '2025-03-02' }
])

const activityLogs = ref([
  { time: '14:32', action: 'Card Created', user: 'Admin' },
  { time: '14:15', action: 'User Registered', user: 'System' },
  { time: '13:48', action: 'Battle Started', user: 'Player One' },
  { time: '13:20', action: 'Card Edited', user: 'Admin' }
])

const avgPower = computed(() => {
  if (mockCards.value.length === 0) return 0
  const total = mockCards.value.reduce((sum, card) => sum + card.power, 0)
  return (total / mockCards.value.length).toFixed(1)
})

const saveCard = () => {
  if (editingCard.value) {
    const index = mockCards.value.findIndex(c => c.id === editingCard.value.id)
    if (index > -1) {
      mockCards.value[index] = { ...mockCards.value[index], ...cardForm.value }
    }
  } else {
    mockCards.value.push({
      id: Math.max(...mockCards.value.map(c => c.id)) + 1,
      ...cardForm.value
    })
  }
  resetCardForm()
}

const editCard = (card) => {
  editingCard.value = card
  cardForm.value = { ...card }
  showCardForm.value = true
}

const deleteCard = (id) => {
  mockCards.value = mockCards.value.filter(c => c.id !== id)
}

const resetCardForm = () => {
  cardForm.value = { name: '', power: '', element: '', rarity: '', description: '' }
  editingCard.value = null
  showCardForm.value = false
}

const changeUserRole = (user) => {
  user.role = user.role === 'user' ? 'admin' : 'user'
}

const deleteUser = (id) => {
  mockUsers.value = mockUsers.value.filter(u => u.id !== id)
}
</script>

<style scoped>
.admin-container {
  position: relative;
  min-height: 100vh;
  background: #000;
  color: #fff;
  padding: 6rem 0 2rem 0;
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

.admin-content {
  position: relative;
  z-index: 0;
}

.admin-header {
  text-align: center;
  margin-bottom: 3rem;
}

.admin-title {
  font-size: 2.5rem;
  font-weight: 900;
  background: linear-gradient(90deg, #FF6B35, #FFD60A, #FF6B35);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.admin-subtitle {
  font-size: 1.1rem;
  color: #FF6B35;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.admin-tabs {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  border-bottom: 2px solid rgba(255, 107, 53, 0.3);
  overflow-x: auto;
}

.tab-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem 1.5rem;
  background: transparent;
  border: none;
  color: #888;
  cursor: pointer;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-bottom: 3px solid transparent;
  transition: all 0.2s ease;
  font-size: 0.9rem;
}

.tab-btn:hover {
  color: #FF6B35;
}

.tab-btn.active {
  color: #FFD60A;
  border-bottom-color: #FFD60A;
}

.tab-icon {
  font-size: 1.2rem;
}

.tab-content {
  animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid rgba(255, 107, 53, 0.3);
}

.section-header h2 {
  font-size: 1.8rem;
  color: #FF6B35;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin: 0;
}

.user-count {
  color: #666;
  font-size: 0.95rem;
}

.action-btn {
  padding: 0.6rem 1.2rem;
  background: linear-gradient(90deg, #FF6B35, #FFD60A);
  color: #000;
  border: none;
  border-radius: 0;
  font-weight: 700;
  cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 0.85rem;
  transition: all 0.2s ease;
}

.action-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 20px rgba(255, 107, 53, 0.5);
}

.form-section {
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: rgba(0, 0, 0, 0.5);
  border: 1px solid #FF6B35;
  border-radius: 0;
}

.form-section h3 {
  color: #FF6B35;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 1.5rem;
}

.admin-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.form-input {
  padding: 0.75rem;
  background: rgba(0, 0, 0, 0.7);
  border: 1px solid #FF6B35;
  border-radius: 0;
  color: #fff;
  font-family: 'Roboto Mono', monospace;
  font-size: 0.9rem;
}

.form-input:focus {
  outline: none;
  border-color: #FFD60A;
  box-shadow: 0 0 10px rgba(255, 107, 53, 0.3);
}

textarea.form-input {
  min-height: 100px;
  grid-column: 1 / -1;
}

.form-actions {
  display: flex;
  gap: 1rem;
  grid-column: 1 / -1;
}

.btn-primary, .btn-secondary {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 0;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.2s ease;
  flex: 1;
}

.btn-primary {
  background: linear-gradient(90deg, #FF6B35, #FFD60A);
  color: #000;
}

.btn-primary:hover {
  box-shadow: 0 0 20px rgba(255, 107, 53, 0.5);
}

.btn-secondary {
  background: transparent;
  border: 2px solid #FF6B35;
  color: #FF6B35;
}

.btn-secondary:hover {
  background: rgba(255, 107, 53, 0.1);
}

.table-section {
  overflow-x: auto;
  margin-bottom: 2rem;
}

.admin-table {
  width: 100%;
  border-collapse: collapse;
  background: rgba(0, 0, 0, 0.5);
}

.admin-table th {
  padding: 1rem;
  background: rgba(255, 107, 53, 0.1);
  border: 1px solid #FF6B35;
  color: #FF6B35;
  text-align: left;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 0.85rem;
}

.admin-table td {
  padding: 0.75rem 1rem;
  border: 1px solid rgba(255, 107, 53, 0.2);
  color: #aaa;
}

.admin-table tr:hover {
  background: rgba(255, 107, 53, 0.05);
}

.action-cell {
  display: flex;
  gap: 0.5rem;
  justify-content: center;
}

.btn-edit, .btn-delete {
  padding: 0.4rem 0.7rem;
  border: none;
  border-radius: 0;
  cursor: pointer;
  font-weight: 700;
  transition: all 0.2s ease;
  background: transparent;
  color: inherit;
}

.btn-edit {
  background: rgba(0, 150, 255, 0.2);
  color: #00d4ff;
  border: 1px solid #00d4ff;
}

.btn-edit:hover {
  background: rgba(0, 150, 255, 0.4);
}

.btn-delete {
  background: rgba(255, 50, 50, 0.2);
  color: #ff6666;
  border: 1px solid #ff6666;
}

.btn-delete:hover {
  background: rgba(255, 50, 50, 0.4);
}

.role-badge, .status-badge {
  display: inline-block;
  padding: 0.3rem 0.8rem;
  border-radius: 0;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.role-badge.admin {
  background: rgba(255, 107, 53, 0.3);
  color: #FF6B35;
  border: 1px solid #FF6B35;
}

.role-badge.user {
  background: rgba(0, 212, 255, 0.2);
  color: #00d4ff;
  border: 1px solid #00d4ff;
}

.status-badge.Completed {
  background: rgba(16, 185, 129, 0.2);
  color: #10b981;
  border: 1px solid #10b981;
}

.status-badge.Pending {
  background: rgba(255, 193, 7, 0.2);
  color: #FFD60A;
  border: 1px solid #FFD60A;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-box {
  padding: 2rem;
  background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 214, 10, 0.05));
  border: 2px solid #FF6B35;
  border-radius: 0;
  text-align: center;
}

.stat-number {
  font-size: 2.5rem;
  font-weight: 900;
  color: #FFD60A;
}

.stat-desc {
  font-size: 0.9rem;
  color: #888;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-top: 0.5rem;
}

.log-section {
  padding: 1.5rem;
  background: rgba(0, 0, 0, 0.5);
  border: 1px solid #FF6B35;
  border-radius: 0;
}

.log-section h3 {
  color: #FF6B35;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 1rem;
}

.activity-log {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  max-height: 300px;
  overflow-y: auto;
}

.log-entry {
  display: flex;
  gap: 1rem;
  padding: 0.75rem;
  background: rgba(255, 107, 53, 0.05);
  border-left: 3px solid #FF6B35;
  font-size: 0.9rem;
}

.log-time {
  color: #FFD60A;
  font-weight: 700;
  min-width: 60px;
}

.log-action {
  color: #fff;
  flex: 1;
}

.log-user {
  color: #666;
}

@media (max-width: 768px) {
  .admin-title {
    font-size: 1.8rem;
  }

  .section-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .tab-btn {
    padding: 0.75rem 1rem;
    font-size: 0.8rem;
  }

  .form-row {
    grid-template-columns: 1fr;
  }

  .admin-table {
    font-size: 0.85rem;
  }

  .admin-table th, .admin-table td {
    padding: 0.5rem;
  }

  .stats-grid {
    grid-template-columns: 1fr 1fr;
  }
}
</style>
