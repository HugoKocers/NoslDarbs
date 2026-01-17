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
:global(.v-app),
:global(.v-app__wrap) {
  background: #000 !important;
}

:global(.v-container) {
  background: transparent !important;
}
</style>

<style scoped>
.navbar {
  background: linear-gradient(90deg, #000 0%, #1a0033 50%, #000 100%) !important;
  border-bottom: 1px solid rgba(192, 132, 252, 0.2);
  backdrop-filter: blur(10px);
  position: sticky;
  top: 0;
  z-index: 100;
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
  font-weight: 800;
  font-size: 1.25rem;
  transition: all 0.3s ease;
}

.brand-link:hover {
  color: #c084fc;
}

.brand-icon {
  font-size: 1.5rem;
}

.brand-text {
  background: linear-gradient(to right, #c084fc, #e9d5ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.navbar-nav {
  display: flex;
  gap: 2rem;
  align-items: center;
}

.nav-link {
  color: #d1d5db;
  text-decoration: none;
  font-weight: 500;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  position: relative;
  padding-bottom: 0.5rem;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(to right, #c084fc, #06b6d4);
  transition: width 0.3s ease;
}

.nav-link:hover {
  color: #fff;
}

.nav-link:hover::after {
  width: 100%;
}

.nav-link.active {
  color: #c084fc;
}

.nav-link.active::after {
  width: 100%;
}

.main-content {
  background: #000 !important;
  min-height: calc(100vh - 64px - 400px);
}

.footer {
  background: linear-gradient(180deg, #000 0%, #1a0033 100%);
  border-top: 1px solid rgba(192, 132, 252, 0.2);
  padding: 3rem 0 2rem;
  margin-top: 4rem;
  color: #d1d5db;
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
  background: linear-gradient(to right, #c084fc, #fff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.footer-section h4 {
  font-size: 1rem;
  color: #fff;
  margin-bottom: 1rem;
  font-weight: 600;
}

.footer-section p {
  color: #9ca3af;
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
  color: #d1d5db;
  text-decoration: none;
  transition: all 0.3s ease;
}

.footer-section a:hover {
  color: #c084fc;
  transform: translateX(4px);
}

.footer-bottom {
  text-align: center;
  padding-top: 2rem;
  border-top: 1px solid rgba(192, 132, 252, 0.1);
  color: #9ca3af;
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
