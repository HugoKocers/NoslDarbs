<template>
  <v-app>
    <v-app-bar elevation="0" class="navbar">
      <v-container class="navbar-container">
        <div class="navbar-brand">
          <router-link to="/" class="brand-link">
            <span class="brand-icon">⚔️</span>
            <span class="brand-text">CardQuest</span>
          </router-link>
        </div>
        <v-spacer></v-spacer>
        <nav class="navbar-nav">
          <router-link to="/" class="nav-link" active-class="active">Home</router-link>
          <router-link to="/cards" class="nav-link" active-class="active">Cards</router-link>
          <router-link to="/play" class="nav-link" active-class="active">Play</router-link>
          <router-link to="/profile" class="nav-link" active-class="active">Profile</router-link>
        </nav>
      </v-container>
    </v-app-bar>

    <v-main class="main-content">
      <router-view />
    </v-main>

    <footer class="footer">
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
          <p>&copy; 2026 CardQuest. All rights reserved.</p>
        </div>
      </v-container>
    </footer>
  </v-app>
</template>

<script>
export default {
  name: 'App',
}
</script>

<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body,
html {
  background: #000 !important;
  margin: 0 !important;
  padding: 0 !important;
}

:global(body),
:global(html) {
  background: #000 !important;
  margin: 0 !important;
  padding: 0 !important;
}

:global(.v-app),
:global(.v-app__wrap) {
  background: #000 !important;
  margin: 0 !important;
  padding: 0 !important;
}

:global(.v-main),
:global(.v-main__wrap) {
  background: #000 !important;
  margin: 0 !important;
  padding: 0 !important;
}

:global(.v-container) {
  background: transparent !important;
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
