<template>
  <v-app>
    <v-app-bar elevation="0" class="navbar" role="navigation">
      <v-container class="navbar-container">
        <div class="navbar-brand">
          <router-link to="/" class="brand-link" aria-label="CardQuest Home">
            <span class="brand-icon">⚔️</span>
            <span class="brand-text">CardQuest</span>
          </router-link>
        </div>
        <v-spacer></v-spacer>
        <nav class="navbar-nav" role="menubar">
          <router-link to="/" class="nav-link" active-class="active" role="menuitem">Home</router-link>
          <router-link to="/cards" class="nav-link" active-class="active" role="menuitem">Cards</router-link>
          
          <!-- Public/Authenticated routes -->
          <template v-if="authStore.isAuthenticated">
            <router-link to="/play" class="nav-link" active-class="active" role="menuitem">Play</router-link>
            <router-link to="/profile" class="nav-link" active-class="active" role="menuitem">Profile</router-link>
            <router-link to="/statistics" class="nav-link" active-class="active" role="menuitem">Stats</router-link>
            
            <!-- Admin link -->
            <router-link v-if="authStore.isAdmin" to="/admin" class="nav-link nav-admin" active-class="active" role="menuitem">Admin</router-link>
            
            <!-- User menu dropdown -->
            <div class="nav-user-menu">
              <button @click="showUserMenu = !showUserMenu" class="user-btn" :aria-expanded="showUserMenu" aria-label="User menu">
                <span class="user-avatar">👤</span>
                <span class="user-name">{{ authStore.user?.name }}</span>
                <span class="menu-icon">▼</span>
              </button>
              <div v-if="showUserMenu" class="dropdown-menu" role="menu">
                <router-link to="/profile" class="menu-item" role="menuitem">My Profile</router-link>
                <router-link to="/statistics" class="menu-item" role="menuitem">Statistics</router-link>
                <div class="menu-divider"></div>
                <button @click="handleLogout" class="menu-item logout-item" role="menuitem">Logout</button>
              </div>
            </div>
          </template>
          
          <!-- Unauthenticated links -->
          <template v-else>
            <router-link to="/login" class="nav-link nav-login" active-class="active" role="menuitem">Login</router-link>
            <router-link to="/signup" class="nav-link nav-signup" active-class="active" role="menuitem">Sign Up</router-link>
          </template>
        </nav>
      </v-container>
    </v-app-bar>

    <v-main class="main-content" role="main">
      <router-view />
    </v-main>

    <footer class="footer" role="contentinfo">
      <v-container>
        <div class="footer-content">
          <div class="footer-section">
            <h3>CardQuest</h3>
            <p>Master the cards, dominate the arena</p>
          </div>
          <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
              <li><router-link to="/">Home</router-link></li>
              <li><router-link to="/cards">Cards</router-link></li>
              <li><router-link to="/play">Play</router-link></li>
            </ul>
          </div>
          <div class="footer-section">
            <h4>Game Info</h4>
            <ul>
              <li><a href="#">Rules</a></li>
              <li><a href="#">Strategy Guide</a></li>
              <li><a href="#">FAQ</a></li>
            </ul>
          </div>
          <div class="footer-section">
            <h4>Community</h4>
            <ul>
              <li><a href="#">Discord</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">GitHub</a></li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2026 CardQuest. Made by Hugo.</p>
        </div>
      </v-container>
    </footer>
  </v-app>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

const router = useRouter()
const authStore = useAuthStore()
const showUserMenu = ref(false)

const handleLogout = async () => {
  await authStore.logout()
  showUserMenu.value = false
  router.push('/')
}
</script>

<style scoped>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

:global(body),
:global(html) {
  background: #000 !important;
  margin: 0 !important;
  padding: 0 !important;
  overflow-y: scroll !important;
  overflow-x: hidden !important;
  scrollbar-width: thin !important;
  scrollbar-color: #00d4ff #1a1a1a !important;
}

:global(body::-webkit-scrollbar),
:global(html::-webkit-scrollbar) {
  width: 12px;
}

:global(body::-webkit-scrollbar-track),
:global(html::-webkit-scrollbar-track) {
  background: #1a1a1a;
}

:global(body::-webkit-scrollbar-thumb),
:global(html::-webkit-scrollbar-thumb) {
  background: #00d4ff;
  border-radius: 6px;
}

:global(body::-webkit-scrollbar-thumb:hover),
:global(html::-webkit-scrollbar-thumb:hover) {
  background: #0099cc;
}

:global(.v-app) {
  overflow-y: scroll !important;
}

:global(.v-app-bar) {
  overflow: visible !important;
}

:global(.v-main),
:global(.v-main__wrap) {
  background: #000 !important;
  overflow-y: scroll !important;
  overflow-x: hidden !important;
}

.navbar {
  background: linear-gradient(
    90deg,
    rgba(0, 0, 0, 0.95) 0%,
    rgba(0, 20, 50, 0.5) 50%,
    rgba(0, 0, 0, 0.95) 100%
  ) !important;
  border-bottom: 2px solid rgba(0, 212, 255, 0.2) !important;
  backdrop-filter: blur(10px);
  position: relative !important;
  z-index: 10000 !important;
  overflow: visible !important;
}

.navbar-container {
  display: flex;
  align-items: center;
  gap: 2rem;
  padding: 0.75rem 1rem !important;
  max-width: 100% !important;
  width: 100% !important;
  overflow: visible !important;
}

.navbar-brand {
  flex-shrink: 0;
}

.brand-link {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  color: #00d4ff;
  font-weight: 900;
  font-size: 1.3rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  transition: all 0.2s ease;
}

.brand-link:hover,
.brand-link:focus {
  text-shadow: 0 0 20px #00d4ff;
  outline: none;
}

.brand-icon {
  font-size: 1.5rem;
}

.brand-text {
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.navbar-nav {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 0.5rem;
  flex-wrap: nowrap;
  min-width: 0;
  overflow: visible;
}

.nav-link {
  padding: 0.6rem 0.8rem;
  text-decoration: none;
  color: #aabbdd;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 0.8rem;
  transition: all 0.2s ease;
  border-bottom: 2px solid transparent;
  cursor: pointer;
  white-space: nowrap;
  flex-shrink: 0;
}

.nav-link:hover,
.nav-link:focus {
  color: #00d4ff;
  text-shadow: 0 0 10px #00d4ff;
  outline: none;
}

.nav-link.active {
  color: #00d4ff;
  border-bottom-color: #00d4ff;
  box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
}

.nav-admin {
  background: rgba(255, 107, 53, 0.1);
  border: 1px solid #FF6B35;
  border-radius: 4px;
  color: #FF6B35;
}

.nav-login {
  background: rgba(0, 212, 255, 0.1);
  border: 1px solid #00d4ff;
  border-radius: 4px;
}

.nav-signup {
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  border-radius: 4px;
}

.nav-signup:hover {
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);
}

.nav-user-menu {
  position: relative;
  z-index: 2;
  overflow: visible;
}

.user-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.6rem 0.8rem;
  background: rgba(0, 212, 255, 0.1);
  border: 1px solid #00d4ff;
  border-radius: 4px;
  color: #00d4ff;
  font-weight: 700;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.user-btn:hover {
  background: rgba(0, 212, 255, 0.2);
}

.user-avatar {
  font-size: 1.2rem;
}

.menu-icon {
  font-size: 0.7rem;
  transition: transform 0.2s ease;
}

.user-btn[aria-expanded='true'] .menu-icon {
  transform: rotate(180deg);
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  right: 0;
  margin-top: 0.5rem;
  background: linear-gradient(135deg, rgba(0, 20, 50, 0.95), rgba(10, 8, 32, 0.95));
  border: 2px solid #00d4ff;
  border-radius: 4px;
  box-shadow: 0 4px 20px rgba(0, 212, 255, 0.2);
  min-width: 200px;
  z-index: 10001;
  animation: slideDown 0.2s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.menu-item {
  display: block;
  width: 100%;
  padding: 0.75rem 1.25rem;
  background: transparent;
  border: none;
  color: #aabbdd;
  text-align: left;
  text-decoration: none;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 0.85rem;
}

.menu-item:hover,
.menu-item:focus {
  background: rgba(0, 212, 255, 0.1);
  color: #00d4ff;
  outline: none;
}

.logout-item:hover {
  background: rgba(255, 50, 50, 0.15);
  color: #ff8888;
}

.menu-divider {
  height: 1px;
  background: rgba(0, 212, 255, 0.2);
  margin: 0.5rem 0;
}

.main-content {
  background: transparent !important;
  min-height: calc(100vh - 120px);
  position: relative;
  z-index: 1;
  padding-top: 0;
}

.footer {
  background: linear-gradient(180deg, #0a0820 0%, #000000 100%);
  border-top: 1px solid rgba(0, 212, 255, 0.2);
  margin-top: 4rem;
  padding: 4rem 0;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 3rem;
  margin-bottom: 2rem;
}

.footer-section h3,
.footer-section h4 {
  color: #00d4ff;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 1rem;
  font-size: 1rem;
}

.footer-section p {
  color: #aabbdd;
  font-size: 0.9rem;
}

.footer-section ul {
  list-style: none;
}

.footer-section li {
  margin-bottom: 0.5rem;
}

.footer-section a {
  color: #aabbdd;
  text-decoration: none;
  transition: all 0.2s ease;
  font-size: 0.9rem;
}

.footer-section a:hover {
  color: #00d4ff;
  text-shadow: 0 0 10px #00d4ff;
}

.footer-bottom {
  text-align: center;
  padding-top: 2rem;
  border-top: 1px solid rgba(0, 212, 255, 0.2);
  color: #666;
  font-size: 0.85rem;
}

@media (max-width: 768px) {
  .navbar-container {
    gap: 1rem;
  }

  .navbar-nav {
    width: auto;
    justify-content: flex-end;
    gap: 0.25rem;
    flex-wrap: nowrap;
    flex-shrink: 1;
    min-width: 0;
  }

  .nav-link {
    padding: 0.5rem 0.5rem;
    font-size: 0.75rem;
  }

  .brand-text {
    display: none;
  }

  .user-name {
    display: none;
  }

  .dropdown-menu {
    position: fixed;
    right: 1rem;
    width: 200px;
  }

  .footer-content {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
}
</style>

<style scoped>
.navbar {
  background: linear-gradient(90deg, rgba(0,0,0,0.95) 0%, rgba(10,0,50,0.95) 50%, rgba(0,0,0,0.95) 100%) !important;
  border-bottom: 2px solid #00d4ff;
  backdrop-filter: blur(20px);
  position: sticky;
  top: 0;
  z-index: 100;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.3), inset 0 1px 0 rgba(255,255,255,0.1);
}

.navbar-container {
  display: flex;
  align-items: center;
  gap: 2rem;
  max-width: 1400px;
}

.navbar-brand {
  display: flex;
  align-items: center;
}

.brand-link {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  text-decoration: none;
  color: #fff;
  font-weight: 900;
  font-size: 1.35rem;
  transition: all 0.3s ease;
  letter-spacing: 2px;
  text-transform: uppercase;
}

.brand-link:hover {
  color: #00d4ff;
  text-shadow: 0 0 20px #00d4ff, 0 0 40px rgba(0, 102, 255, 0.8);
  transform: scale(1.05);
}

.brand-icon {
  font-size: 1.5rem;
  animation: pulse-glow 2s ease-in-out infinite;
}

@keyframes pulse-glow {
  0%, 100% {
    text-shadow: 0 0 10px #00d4ff;
    filter: drop-shadow(0 0 5px #0066ff);
  }
  50% {
    text-shadow: 0 0 25px #00d4ff, 0 0 35px #0066ff;
    filter: drop-shadow(0 0 15px #0066ff);
  }
}

.brand-text {
  background: linear-gradient(90deg, #00d4ff 0%, #0066ff 50%, #00d4ff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  filter: drop-shadow(0 0 10px rgba(0, 212, 255, 0.6));
}

.navbar-nav {
  display: flex;
  gap: 2.5rem;
  align-items: center;
}

.nav-link {
  color: #88aaff;
  text-decoration: none;
  font-weight: 700;
  font-size: 0.85rem;
  transition: all 0.3s ease;
  position: relative;
  padding-bottom: 0.5rem;
  text-transform: uppercase;
  letter-spacing: 1.5px;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  transition: width 0.3s ease;
  box-shadow: 0 0 10px #00d4ff;
}

.nav-link:hover {
  color: #00d4ff;
  text-shadow: 0 0 12px rgba(0, 212, 255, 0.8);
}

.nav-link:hover::after {
  width: 100%;
  box-shadow: 0 0 15px #00d4ff, 0 0 25px #0066ff;
}

.nav-link.active {
  color: #00d4ff;
  text-shadow: 0 0 15px #00d4ff, 0 0 30px rgba(0, 102, 255, 0.6);
}

.nav-link.active::after {
  width: 100%;
  box-shadow: 0 0 15px #00d4ff, 0 0 25px #0066ff;
}

.main-content {
  background: #000 !important;
  min-height: auto !important;
  position: relative;
  z-index: 1;
}

.footer {
  background: linear-gradient(180deg, #000 0%, #0a0033 50%, #000 100%);
  border-top: 2px solid #00d4ff;
  padding: 3rem 0 2rem;
  margin: 0 !important;
  color: #88aaff;
  box-shadow: 0 -10px 40px rgba(0, 212, 255, 0.15);
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  margin-bottom: 2rem;
}

.footer-section h3 {
  font-size: 1.5rem;
  color: #fff;
  margin-bottom: 0.5rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff, #00d4ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  text-transform: uppercase;
  letter-spacing: 2px;
  filter: drop-shadow(0 0 8px rgba(0, 212, 255, 0.4));
}

.footer-section h4 {
  font-size: 1rem;
  color: #00d4ff;
  margin-bottom: 1rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(0, 212, 255, 0.5);
}

.footer-section p {
  color: #6688cc;
  line-height: 1.6;
}

.footer-section ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-section li {
  margin-bottom: 0.75rem;
}

.footer-section a {
  color: #88aaff;
  text-decoration: none;
  transition: all 0.3s ease;
}

.footer-section a:hover {
  color: #00d4ff;
  transform: translateX(4px);
  text-shadow: 0 0 10px #00d4ff;
}

.footer-bottom {
  text-align: center;
  padding-top: 2rem;
  border-top: 1px solid rgba(0, 212, 255, 0.15);
  color: #6688cc;
  font-size: 0.9rem;
}

@media (max-width: 960px) {
  .navbar-container {
    flex-wrap: wrap;
    gap: 1rem;
  }

  .navbar-nav {
    gap: 1.5rem;
  }

  .nav-link {
    font-size: 0.85rem;
  }
}

@media (max-width: 600px) {
  .navbar-nav {
    gap: 1rem;
  }

  .nav-link {
    font-size: 0.75rem;
  }

  .brand-text {
    display: none;
  }
}
</style>
