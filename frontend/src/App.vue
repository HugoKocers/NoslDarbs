<template>
  <v-app>
    <div class="starfield-overlay" ref="starfieldLayer"></div>
    <v-app-bar elevation="0" class="navbar" role="navigation">
      <v-container class="navbar-container">
        <div class="navbar-brand">
          <router-link to="/" class="brand-link" aria-label="CardQuest Home">
            <span class="brand-icon">⚔️</span>
            <span class="brand-text">CardQuest</span>
          </router-link>
        </div>
        <v-spacer></v-spacer>
        <template v-if="!isMobile">
          <nav class="navbar-nav" role="menubar">
            <router-link to="/" class="nav-link" active-class="active" role="menuitem">{{ i18n.t.home }}</router-link>
            <router-link to="/cards" class="nav-link" active-class="active" role="menuitem">{{ i18n.t.cards }}</router-link>
            <router-link to="/leaderboard" class="nav-link" active-class="active" role="menuitem">{{ i18n.t.leaderboard }}</router-link>
            
            <!-- Public/Authenticated routes -->
            <template v-if="authStore.isAuthenticated">
              <router-link to="/play" class="nav-link" active-class="active" role="menuitem">{{ i18n.t.play }}</router-link>
              <router-link to="/profile" class="nav-link" active-class="active" role="menuitem">{{ i18n.t.profile }}</router-link>
              
              <!-- Admin link -->
              <router-link v-if="authStore.isAdmin" to="/admin" class="nav-link nav-admin" active-class="active" role="menuitem">{{ i18n.t.admin }}</router-link>
              
              <!-- User menu dropdown -->
              <div class="nav-user-menu">
                <button @click="showUserMenu = !showUserMenu" class="user-btn" :aria-expanded="showUserMenu" aria-label="User menu">
                  <span class="user-avatar">👤</span>
                  <span class="user-name">{{ authStore.user?.name }}</span>
                  <span class="menu-icon">▼</span>
                </button>
                <div v-if="showUserMenu" class="dropdown-menu" role="menu">
                  <router-link to="/profile" class="menu-item" role="menuitem">{{ i18n.t.myProfile }}</router-link>
                  <div class="menu-divider"></div>
                  <button @click="handleLogout" class="menu-item logout-item" role="menuitem">{{ i18n.t.logout }}</button>
                </div>
              </div>
            </template>
            
            <!-- Unauthenticated links -->
            <template v-else>
              <router-link to="/login" class="nav-link nav-login" active-class="active" role="menuitem">{{ i18n.t.login }}</router-link>
              <router-link to="/signup" class="nav-link nav-signup" active-class="active" role="menuitem">{{ i18n.t.signup }}</router-link>
            </template>
          </nav>
        </template>

        <template v-else>
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="mobile-menu-toggle" :aria-expanded="mobileMenuOpen" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
          </button>
        </template>
      </v-container>
    </v-app-bar>

    <div class="mobile-menu-backdrop" v-if="isMobile && mobileMenuOpen" @click="mobileMenuOpen = false"></div>
    <div class="mobile-menu-panel" v-if="isMobile" :class="{ open: mobileMenuOpen }">
      <nav class="mobile-nav" role="menubar">
        <router-link @click="handleMobileLink" to="/" class="mobile-nav-link">{{ i18n.t.home }}</router-link>
        <router-link @click="handleMobileLink" to="/cards" class="mobile-nav-link">{{ i18n.t.cards }}</router-link>
        <router-link @click="handleMobileLink" to="/leaderboard" class="mobile-nav-link">{{ i18n.t.leaderboard }}</router-link>

        <div class="mobile-section" v-if="authStore.isAuthenticated">
          <router-link @click="handleMobileLink" to="/play" class="mobile-nav-link">{{ i18n.t.play }}</router-link>
          <router-link @click="handleMobileLink" to="/profile" class="mobile-nav-link">{{ i18n.t.profile }}</router-link>
          <router-link v-if="authStore.isAdmin" @click="handleMobileLink" to="/admin" class="mobile-nav-link mobile-admin-link">{{ i18n.t.admin }}</router-link>
          <button @click="handleLogout" class="mobile-action-btn">{{ i18n.t.logout }}</button>
        </div>

        <div class="mobile-section" v-else>
          <router-link @click="handleMobileLink" to="/login" class="mobile-nav-link">{{ i18n.t.login }}</router-link>
          <router-link @click="handleMobileLink" to="/signup" class="mobile-nav-link mobile-signup-link">{{ i18n.t.signup }}</router-link>
        </div>
      </nav>
    </div>

    <v-main class="main-content" role="main">
      <div class="constellation-overlay" ref="constellationLayer"></div>
      <router-view />
    </v-main>

    <footer class="footer" role="contentinfo">
      <v-container>
        <div class="footer-content">
          <div class="footer-section">
            <h3>{{ i18n.t.cardquest }}</h3>
            <p>{{ i18n.t.dominateArena }}</p>
          </div>
          <div class="footer-section">
            <h4>{{ i18n.t.quickLinks }}</h4>
            <ul>
              <li><router-link to="/">{{ i18n.t.home }}</router-link></li>
              <li><router-link to="/cards">{{ i18n.t.cards }}</router-link></li>
              <li><router-link to="/play">{{ i18n.t.play }}</router-link></li>
            </ul>
          </div>
          <div class="footer-section">
            <h4>{{ i18n.t.gameInfo }}</h4>
            <ul>
              <li><a href="#">{{ i18n.t.rules }}</a></li>
              <li><a href="#">{{ i18n.t.strategyGuide }}</a></li>
              <li><a href="#">{{ i18n.t.faq }}</a></li>
            </ul>
          </div>
          <div class="footer-section">
            <h4>{{ i18n.t.community }}</h4>
            <ul>
              <li><a href="#">{{ i18n.t.discord }}</a></li>
              <li><a href="#">{{ i18n.t.twitter }}</a></li>
              <li><a href="#">{{ i18n.t.github }}</a></li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <div class="footer-bottom-content">
            <p>{{ i18n.t.copyright }}</p>
            <button @click="toggleLanguage" class="language-toggle" :title="`Switch to ${i18n.language === 'EN' ? 'Latvian' : 'English'}`">
              {{ i18n.language === 'EN' ? '🇬🇧 EN' : '🇱🇻 LV' }}
            </button>
          </div>
        </div>
      </v-container>
    </footer>
  </v-app>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'
import { useI18nStore } from '@/stores/i18nStore'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const i18n = useI18nStore()
const showUserMenu = ref(false)
const isMobile = ref(false)
const mobileMenuOpen = ref(false)
const constellationLayer = ref(null)
const starfieldLayer = ref(null)
let lastPointer = null
// cursor follower state
const cursorTarget = { x: 0, y: 0 }
let cursorDot = null
let rafId = null
const followSpeed = 0.12

// starfield state
let starEls = []
const STAR_COUNT = 36

const updateMobileState = () => {
  isMobile.value = window.matchMedia('(max-width: 768px)').matches
  if (!isMobile.value) {
    mobileMenuOpen.value = false
  }
}

// single lagging cursor dot implementation
const initCursorDot = () => {
  const layer = constellationLayer.value || document.body
  if (cursorDot) return
  const dot = document.createElement('div')
  dot.className = 'cursor-dot'
  dot.style.left = `0px`
  dot.style.top = `0px`
  dot.style.opacity = '0'
  layer.appendChild(dot)
  cursorDot = dot

  const tick = () => {
    if (!cursorDot) return
    const currentX = parseFloat(cursorDot.dataset.x || cursorDot.style.left || 0)
    const currentY = parseFloat(cursorDot.dataset.y || cursorDot.style.top || 0)
    const tx = cursorTarget.x
    const ty = cursorTarget.y
    const nx = currentX + (tx - currentX) * followSpeed
    const ny = currentY + (ty - currentY) * followSpeed
    cursorDot.style.left = `${nx}px`
    cursorDot.style.top = `${ny}px`
    cursorDot.dataset.x = nx
    cursorDot.dataset.y = ny
    cursorDot.style.opacity = '1'
    rafId = window.requestAnimationFrame(tick)
  }
  rafId = window.requestAnimationFrame(tick)
}

const destroyCursorDot = () => {
  if (rafId) window.cancelAnimationFrame(rafId)
  if (cursorDot && cursorDot.parentNode) cursorDot.parentNode.removeChild(cursorDot)
  cursorDot = null
  rafId = null
}

// Hide/destroy dot when navigating to gameplay or admin
watch(() => route.path, (p) => {
  if (p.startsWith('/play') || p.startsWith('/admin')) {
    destroyCursorDot()
    destroyStarfield()
  } else {
    initStarfield()
  }
})

const initStarfield = () => {
  if (!starfieldLayer.value || starEls.length) return
  const layer = starfieldLayer.value
  const count = isMobile.value ? Math.max(14, Math.floor(STAR_COUNT / 2.5)) : STAR_COUNT
  const colors = ['#00d4ff', '#66ffff', '#ff5aff', '#7af0ff', '#e7ff5a']
  for (let i = 0; i < count; i++) {
    const s = document.createElement('span')
    s.className = 'bg-star'
    const left = Math.random() * 100
    const top = Math.random() * 100
    const size = 10 + Math.random() * 12
    const color = colors[Math.floor(Math.random() * colors.length)]
    const dur = 4 + Math.random() * 6
    const delay = Math.random() * -dur
    s.style.left = `${left}%`
    s.style.top = `${top}%`
    s.style.width = `${size}px`
    s.style.height = `${size}px`
    s.style.background = `radial-gradient(circle, ${color} 0%, rgba(255,255,255,0.95) 30%, rgba(255,255,255,0) 65%)`
    s.style.boxShadow = `0 0 ${Math.round(size * 4.5)}px ${color}`
    s.style.opacity = `${0.32 + Math.random() * 0.38}`
    s.style.animationDuration = `${dur}s`
    s.style.animationDelay = `${delay}s`
    s.style.willChange = 'transform, opacity'
    layer.appendChild(s)
    starEls.push(s)
  }
}

const destroyStarfield = () => {
  while (starEls.length) {
    const el = starEls.shift()
    if (el && el.parentNode) el.parentNode.removeChild(el)
  }
}

const handlePointerMove = (event) => {
  const isTouch = event.pointerType ? event.pointerType === 'touch' : false
  if (isTouch || isMobile.value) return
  if (route.path.startsWith('/play') || route.path.startsWith('/admin')) return
  if (!constellationLayer.value) return

  const mainRect = constellationLayer.value.parentElement?.getBoundingClientRect()
  if (!mainRect) return

  const withinMain = event.clientX >= mainRect.left && event.clientX <= mainRect.right && event.clientY >= mainRect.top && event.clientY <= mainRect.bottom
  if (!withinMain) {
    destroyCursorDot()
    return
  }

  cursorTarget.x = event.clientX
  cursorTarget.y = event.clientY
  if (!cursorDot) initCursorDot()
}

const handleLogout = async () => {
  await authStore.logout()
  showUserMenu.value = false
  mobileMenuOpen.value = false
  router.push('/')
}

const toggleLanguage = () => {
  i18n.setLanguage(i18n.language === 'EN' ? 'LV' : 'EN')
}

const handleMobileLink = () => {
  mobileMenuOpen.value = false
  showUserMenu.value = false
}

onMounted(() => {
  updateMobileState()
  window.addEventListener('resize', updateMobileState)
  window.addEventListener('pointermove', handlePointerMove)
  window.addEventListener('mousemove', handlePointerMove)
  if (!route.path.startsWith('/admin') && !route.path.startsWith('/play')) initStarfield()
})

onUnmounted(() => {
  window.removeEventListener('resize', updateMobileState)
  window.removeEventListener('pointermove', handlePointerMove)
  window.removeEventListener('mousemove', handlePointerMove)
  destroyCursorDot()
  destroyStarfield()
})
</script>

<style scoped>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

:global(body),
:global(html) {
  width: 100vw !important;
  min-width: 100vw !important;
  background: #000 !important;
  margin: 0 !important;
  padding: 0 !important;
  overflow-y: auto !important;
  overflow-x: hidden !important;
  scrollbar-width: thin !important;
  scrollbar-color: #00d4ff transparent !important;
}

:global(body::-webkit-scrollbar),
:global(html::-webkit-scrollbar) {
  width: 12px;
}

:global(body::-webkit-scrollbar-track),
:global(html::-webkit-scrollbar-track) {
  background: transparent;
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
  overflow: hidden !important;
}

:global(.v-app-bar) {
  overflow: visible !important;
}

:global(.v-main),
:global(.v-main__wrap) {
  background: #000 !important;
  overflow-y: auto !important;
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
  z-index: 10000;
  overflow: visible !important;
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
  position: fixed;
  top: auto;
  right: 1rem;
  margin-top: 4.5rem;
  background: linear-gradient(135deg, rgba(0, 20, 50, 0.95), rgba(10, 8, 32, 0.95));
  border: 2px solid #00d4ff;
  border-radius: 4px;
  box-shadow: 0 4px 20px rgba(0, 212, 255, 0.2);
  min-width: 200px;
  z-index: 10002;
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
  padding-top: 2rem;
  border-top: 1px solid rgba(0, 212, 255, 0.2);
}

.footer-bottom-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 2rem;
}

.footer-bottom-content p {
  color: #666;
  font-size: 0.85rem;
  margin: 0;
}

.language-toggle {
  background: rgba(0, 212, 255, 0.1);
  border: 1px solid #00d4ff;
  border-radius: 4px;
  color: #00d4ff;
  padding: 0.5rem 1rem;
  font-weight: 700;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.language-toggle:hover {
  background: rgba(0, 212, 255, 0.2);
  box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
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

  .footer-bottom-content {
    flex-direction: column;
    gap: 1rem;
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

:global(.constellation-overlay) {
  position: fixed;
  inset: 0;
  pointer-events: none;
  z-index: 9000;
}

:global(.starfield-overlay) {
  position: fixed;
  inset: 0;
  pointer-events: none;
  z-index: 9999;
}

:global(.starfield-overlay .bg-star) {
  position: absolute;
  border-radius: 50%;
  mix-blend-mode: screen;
  transform: translateZ(0);
  filter: blur(1.25px);
  animation-name: star-float, star-twinkle;
  animation-iteration-count: infinite;
  animation-timing-function: ease-in-out;
}

@keyframes star-float {
  0% { transform: translateY(0) scale(1) }
  50% { transform: translateY(-16px) scale(1.1) }
  100% { transform: translateY(0) scale(1) }
}

@keyframes star-twinkle {
  0%, 100% { opacity: 0.08 }
  50% { opacity: 0.38 }
}

:global(.cursor-dot) {
  position: absolute;
  left: 0;
  top: 0;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background: #7af0ff;
  transform: translate(-50%, -50%);
  box-shadow: 0 0 26px #7af0ff, 0 0 56px rgba(122,255,255,0.45);
  pointer-events: none;
  z-index: 20002;
  will-change: left, top, opacity;
}


@keyframes star-float {
  0% { transform: translateY(0) }
  50% { transform: translateY(-14px) }
  100% { transform: translateY(0) }
}

@keyframes star-twinkle {
  0% { opacity: 0.05 }
  50% { opacity: 0.25 }
  100% { opacity: 0.05 }
}

:global(.constellation-star),
:global(.constellation-line) {
  position: absolute;
  pointer-events: none;
  opacity: 0;
}

:global(.constellation-star) {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: var(--star-color, #7af0ff);
  box-shadow: 0 0 22px var(--star-color, #7af0ff), 0 0 40px rgba(255,255,255,0.5);
  transform: translate(-50%, -50%) scale(0);
  animation: star-pop 0.9s ease forwards;
}

:global(.constellation-star::before) {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 50%;
  box-shadow: 0 0 16px var(--star-color, #7af0ff);
}

:global(.constellation-line) {
  height: 2px;
  background: linear-gradient(90deg, rgba(255,255,255,0.0), var(--star-color, #7af0ff), rgba(255,255,255,0.0));
  transform-origin: 0 50%;
  opacity: 1;
  filter: drop-shadow(0 0 6px var(--star-color, #7af0ff));
  transition: opacity 0.35s ease;
}

@keyframes star-pop {
  0% {
    opacity: 0;
    transform: translate(-50%, -50%) scale(0);
  }
  20% {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1.15);
  }
  100% {
    opacity: 0;
    transform: translate(-50%, -50%) scale(0.6);
  }
}

@keyframes line-fade {
  0% {
    opacity: 0.85;
    transform: scaleX(0);
  }
  50% {
    opacity: 0.6;
    transform: scaleX(1);
  }
  100% {
    opacity: 0;
  }
}

.mobile-menu-toggle {
  display: inline-flex;
  flex-direction: column;
  justify-content: space-between;
  width: 2.4rem;
  height: 1.9rem;
  padding: 0.35rem;
  background: rgba(0, 212, 255, 0.12);
  border: 1px solid rgba(0, 212, 255, 0.35);
  border-radius: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.mobile-menu-toggle:hover {
  background: rgba(0, 212, 255, 0.18);
}

.mobile-menu-toggle span {
  display: block;
  width: 100%;
  height: 0.18rem;
  border-radius: 999px;
  background: #b6e7ff;
}

.mobile-menu-panel {
  position: fixed;
  top: 72px;
  right: 0;
  width: min(320px, 100vw);
  max-height: calc(100vh - 72px);
  background: rgba(2, 6, 18, 0.98);
  border-left: 1px solid rgba(0, 212, 255, 0.18);
  box-shadow: -20px 0 60px rgba(0, 0, 0, 0.45);
  transform: translateX(100%);
  transition: transform 0.25s ease;
  z-index: 9999;
  overflow-y: auto;
  padding: 1.25rem;
  opacity: 0.98;
}

.mobile-menu-panel.open {
  transform: translateX(0);
}

.mobile-menu-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  z-index: 9998;
}

.mobile-nav {
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
}

.mobile-nav-link {
  display: block;
  padding: 0.95rem 1rem;
  border-radius: 14px;
  text-decoration: none;
  color: #d8efff;
  background: rgba(0, 212, 255, 0.08);
  border: 1px solid rgba(0, 212, 255, 0.12);
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.mobile-nav-link:hover,
.mobile-nav-link:focus {
  background: rgba(0, 212, 255, 0.16);
  color: #fff;
}

.mobile-section {
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(0, 212, 255, 0.15);
  display: grid;
  gap: 0.75rem;
}

.mobile-action-btn,
.mobile-signup-link,
.mobile-admin-link {
  display: block;
  width: 100%;
  padding: 0.95rem 1rem;
  border-radius: 14px;
  text-align: center;
  background: rgba(0, 212, 255, 0.14);
  border: 1px solid rgba(0, 212, 255, 0.22);
  color: #eaf5ff;
  font-weight: 700;
  text-transform: uppercase;
}

.mobile-action-btn:hover,
.mobile-signup-link:hover,
.mobile-admin-link:hover {
  background: rgba(0, 212, 255, 0.24);
}
</style>
