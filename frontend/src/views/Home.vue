<template>
  <div class="home-container">
    <div class="animated-bg"></div>
    
    <section class="hero-section">
      <div class="hero-grid">
        <div class="grid-item" v-for="i in 20" :key="i"></div>
      </div>
      
      <div class="hero-content-wrapper">
        <div class="hero-text-section">
          <div class="accent-line"></div>
          <h1 class="hero-title">CardQuest</h1>
          <h2 class="hero-subtitle">TACTICAL ARENA</h2>
          <p class="hero-description">
            Enter the neural battlegrounds. Master the quantum cards. Dominate the arena.
          </p>
          
          <div class="button-group">
            <router-link to="/cards" class="neon-btn btn-primary">
              <span class="btn-text">ACCESS CARD DATABASE</span>
              <span class="btn-icon">→</span>
            </router-link>
            <router-link to="/play" class="neon-btn btn-secondary">
              <span class="btn-text">INITIATE BATTLE</span>
              <span class="btn-icon">⚡</span>
            </router-link>
          </div>

          <div class="stats-row">
            <div class="stat-item">
              <span class="stat-number">500+</span>
              <span class="stat-label">CARDS</span>
            </div>
            <div class="divider"></div>
            <div class="stat-item">
              <span class="stat-number">∞</span>
              <span class="stat-label">STRATEGIES</span>
            </div>
            <div class="divider"></div>
            <div class="stat-item">
              <span class="stat-number">7/7</span>
              <span class="stat-label">ELEMENTS</span>
            </div>
          </div>
        </div>

        <div class="hero-visual">
          <div class="hologram-card">
            <div class="hologram-inner">
              <div class="glow-orb"></div>
              <span class="hologram-text">QUANTUM CORE</span>
            </div>
          </div>
        </div>
      </div>

      <div class="scroll-indicator">
        <span>SCROLL TO EXPLORE</span>
        <div class="arrow"></div>
      </div>
    </section>

    <section class="featured-section">
      <v-container>
        <div class="section-header">
          <div class="header-line"></div>
          <h2 class="section-title">ELITE ARSENAL</h2>
          <p class="section-desc">Featured Tactical Units</p>
        </div>

        <div class="cards-grid">
          <div class="card-item" v-for="(card, index) in featuredCards" :key="card.id" :style="{ '--element-color': getElementColor(index) }">
            <div class="card-inner">
              <div class="card-glow"></div>
              <div class="card-header">
                <span class="card-id">{{ String(card.id).padStart(3, '0') }}</span>
                <span class="card-element">{{ ['FIRE', 'WATER', 'NATURE', 'LIGHTNING', 'DARK', 'LIGHT'][index % 6] }}</span>
              </div>
              <div class="card-body">
                <h3 class="card-name">{{ card.name }}</h3>
                <p class="card-desc">{{ card.description }}</p>
                <div class="card-footer">
                  <span class="power-display">⚡ PWR: {{ card.power }}</span>
                  <span class="rarity">★★★</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </v-container>
    </section>

    <section class="features-section">
      <v-container>
        <div class="section-header">
          <div class="header-line"></div>
          <h2 class="section-title">CORE SYSTEMS</h2>
          <p class="section-desc">Advanced Gameplay Features</p>
        </div>

        <div class="features-grid">
          <div class="feature-card" v-for="feature in features" :key="feature.id">
            <div class="feature-icon">{{ feature.icon }}</div>
            <h3 class="feature-title">{{ feature.title }}</h3>
            <p class="feature-text">{{ feature.description }}</p>
          </div>
        </div>
      </v-container>
    </section>

    <section class="cta-section">
      <div class="cta-content">
        <h2 class="cta-title">READY TO DOMINATE?</h2>
        <p class="cta-subtitle">Join the neural network and become a legendary card master</p>
        <router-link to="/cards" class="cta-btn">
          <span>DEPLOY NOW</span>
          <span class="glow"></span>
        </router-link>
      </div>
    </section>

    <section class="lore-section">
      <div class="lore-container">
        <div class="lore-sidebar">
          <div class="lore-logo">LORE</div>
          <div class="lore-icons">
            <div class="lore-icon palette-icon"></div>
            <div class="lore-icon struct-icon"></div>
          </div>
        </div>

        <div class="spacecraft-viewer">
          <div class="hud-frame">
            <div class="hud-center">
              <div class="spacecraft-model">
                <svg viewBox="0 0 200 300" class="spacecraft-svg">
                  <!-- Elongated spacecraft structure -->
                  <defs>
                    <linearGradient id="spacecraftGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" style="stop-color:#ffffff;stop-opacity:0.8" />
                      <stop offset="50%" style="stop-color:#cccccc;stop-opacity:0.6" />
                      <stop offset="100%" style="stop-color:#666666;stop-opacity:0.4" />
                    </linearGradient>
                  </defs>
                  
                  <!-- Main body -->
                  <polygon points="100,30 140,80 135,200 65,200 60,80" fill="url(#spacecraftGradient)" stroke="#ffffff" stroke-width="1.5" opacity="0.9"/>
                  
                  <!-- Segment divisions -->
                  <line x1="75" y1="100" x2="125" y2="100" stroke="#ffffff" stroke-width="1" opacity="0.6"/>
                  <line x1="72" y1="140" x2="128" y2="140" stroke="#ffffff" stroke-width="1" opacity="0.6"/>
                  <line x1="70" y1="170" x2="130" y2="170" stroke="#ffffff" stroke-width="1" opacity="0.6"/>
                  
                  <!-- Engine glow -->
                  <ellipse cx="100" cy="210" rx="20" ry="15" fill="#88ddff" opacity="0.5"/>
                  <ellipse cx="100" cy="210" rx="12" ry="8" fill="#ffffff" opacity="0.8"/>
                  
                  <!-- Sharp angular accents -->
                  <polygon points="100,30 105,50 95,50" fill="#ffffff" opacity="0.7"/>
                </svg>
              </div>
            </div>
            <div class="hud-circle"></div>
            <div class="hud-ticks"></div>
          </div>
        </div>

        <div class="lore-content">
          <h3 class="lore-title">PIONEER-CLASS CRUISER</h3>
          <p class="lore-text">
            The Pioneer-Class Cruiser represents humanity's most advanced deep-space exploration vessel. 
            Engineered with cutting-edge quantum propulsion systems and adaptive hull technology, it serves 
            as the flagship of the CardQuest tactical fleet.
          </p>
          <p class="lore-tech">
            <span class="tech-label">DESIGNATION:</span> PSEC-001<br>
            <span class="tech-label">CREW CAPACITY:</span> 250+<br>
            <span class="tech-label">POWER CORE:</span> Quantum Fusion Reactor
          </p>

          <div class="nav-controls">
            <button class="nav-btn prev-btn" aria-label="Previous spacecraft">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
            </button>
            <span class="page-indicator">1 / 6</span>
            <button class="nav-btn next-btn" aria-label="Next spacecraft">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      featuredCards: [
        {
          id: 1,
          name: 'Inferno Dragon',
          description: 'Channel the ancient flames of destruction',
          power: 85
        },
        {
          id: 2,
          name: 'Tsunami',
          description: 'Command waters with precision and force',
          power: 78
        },
        {
          id: 3,
          name: 'Forest Guardian',
          description: 'Call upon nature\'s protective essence',
          power: 82
        },
        {
          id: 4,
          name: 'Electric Dragon',
          description: 'Strike with raw electrical power',
          power: 80
        },
        {
          id: 5,
          name: 'Necromancer',
          description: 'Summon dark forces from beyond',
          power: 79
        },
        {
          id: 6,
          name: 'Angel Guardian',
          description: 'Harness divine light and protection',
          power: 81
        }
      ],
      features: [
        {
          id: 1,
          icon: '🎴',
          title: 'DYNAMIC DECK BUILDING',
          description: 'Craft powerful combinations with 7 unique elemental systems'
        },
        {
          id: 2,
          icon: '⚔️',
          title: 'TACTICAL BATTLES',
          description: 'Engage in strategic card-based combat with real opponents'
        },
        {
          id: 3,
          icon: '✨',
          title: 'RARITY SYSTEM',
          description: 'Unlock rare and legendary cards to strengthen your arsenal'
        },
        {
          id: 4,
          icon: '🏆',
          title: 'RANKED LEAGUES',
          description: 'Climb the leaderboards and prove your mastery'
        }
      ]
    }
  },
  methods: {
    getElementColor(index) {
      const colors = ['#FF6B35', '#00A8E8', '#06D6A0', '#FFD60A', '#9D4EDD', '#3A86FF']
      return colors[index % colors.length]
    }
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Roboto+Mono:wght@400;700&display=swap');

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  line-height: normal;
}

* {
  font-family: 'Roboto Mono', 'Orbitron', monospace;
}

h1, h2, h3, h4, h5, h6 {
  font-family: 'Orbitron', monospace;
  font-weight: 900;
  letter-spacing: 2px;
}

.home-container {
  background: #000;
  color: #fff;
  overflow-x: hidden;
  position: relative;
  margin: 0;
  padding: 0;
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

.hero-section {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5rem 2rem;
  overflow: hidden;
  background: linear-gradient(180deg, #000 0%, rgba(0, 20, 50, 0.3) 50%, #000 100%);
}

.hero-grid {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  grid-template-rows: repeat(10, 1fr);
  gap: 0;
  opacity: 0.05;
  z-index: 0;
}

.grid-item {
  border: 1px solid #00d4ff;
}

.hero-content-wrapper {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
  max-width: 1400px;
  width: 100%;
  z-index: 2;
  position: relative;
}

.accent-line {
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  margin-bottom: 2rem;
}

.hero-title {
  font-size: 4.5rem;
  font-weight: 900;
  background: linear-gradient(90deg, #00d4ff, #0066ff, #00d4ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  text-transform: uppercase;
  margin-bottom: 0.5rem;
  filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.3));
}

.hero-subtitle {
  font-size: 1.8rem;
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 3px;
  margin-bottom: 1.5rem;
  font-weight: 700;
}

.hero-description {
  font-size: 1.1rem;
  color: #aabbdd;
  line-height: 1.8;
  max-width: 500px;
  margin-bottom: 2.5rem;
}

.button-group {
  display: flex;
  gap: 1.5rem;
  margin-bottom: 3rem;
  flex-wrap: wrap;
}

.neon-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
  padding: 1rem 2.5rem;
  border: 2px solid #00d4ff;
  background: rgba(0, 212, 255, 0.05);
  color: #00d4ff;
  text-decoration: none;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  font-size: 0.9rem;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  border-radius: 0;
}

.neon-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: #00d4ff;
  z-index: -1;
  transition: left 0.3s ease;
}

.neon-btn:hover {
  color: #000;
  text-shadow: none;
  box-shadow: 0 0 30px #00d4ff, inset 0 0 20px rgba(0, 212, 255, 0.3);
}

.neon-btn:hover::before {
  left: 0;
}

.btn-secondary::before {
  background: #0066ff;
}

.btn-secondary {
  border-color: #0066ff;
  color: #0066ff;
  background: rgba(0, 102, 255, 0.05);
}

.btn-secondary:hover {
  color: #fff;
  box-shadow: 0 0 30px #0066ff, inset 0 0 20px rgba(0, 102, 255, 0.3);
}

.stats-row {
  display: flex;
  gap: 2rem;
  align-items: center;
  padding-top: 2rem;
  border-top: 1px solid rgba(0, 212, 255, 0.2);
}

.stat-item {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.stat-number {
  font-size: 2rem;
  font-weight: 900;
  color: #00d4ff;
  text-shadow: 0 0 15px #00d4ff;
}

.stat-label {
  font-size: 0.7rem;
  color: #6688cc;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.divider {
  width: 1px;
  height: 40px;
  background: linear-gradient(180deg, transparent, #00d4ff, transparent);
}

.hero-visual {
  display: flex;
  align-items: center;
  justify-content: center;
}

.hologram-card {
  width: 320px;
  height: 400px;
  perspective: 1000px;
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-30px); }
}

.hologram-inner {
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(0, 102, 255, 0.1));
  border: 2px solid #00d4ff;
  border-radius: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 2rem;
  position: relative;
  overflow: hidden;
  box-shadow: 0 0 40px #00d4ff, inset 0 0 40px rgba(0, 212, 255, 0.1), 0 0 80px rgba(0, 212, 255, 0.2);
}

.glow-orb {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: radial-gradient(circle at 30% 30%, #00d4ff, #0066ff);
  box-shadow: 0 0 50px #00d4ff, 0 0 100px #0066ff;
  animation: pulse-orb 2s ease-in-out infinite;
}

@keyframes pulse-orb {
  0%, 100% {
    transform: scale(1);
    box-shadow: 0 0 50px #00d4ff, 0 0 100px #0066ff;
  }
  50% {
    transform: scale(1.1);
    box-shadow: 0 0 80px #00d4ff, 0 0 150px #0066ff;
  }
}

.hologram-text {
  position: relative;
  z-index: 2;
  font-size: 0.9rem;
  color: #00d4ff;
  text-transform: uppercase;
  letter-spacing: 3px;
  font-weight: 700;
  text-shadow: 0 0 20px #00d4ff;
}

.scroll-indicator {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  color: #00d4ff;
  animation: bounce 2s infinite;
  z-index: 2;
}

@keyframes bounce {
  0%, 100% { transform: translateX(-50%) translateY(0); }
  50% { transform: translateX(-50%) translateY(10px); }
}

.scroll-indicator span {
  font-size: 0.8rem;
  letter-spacing: 2px;
  text-transform: uppercase;
}

.arrow {
  width: 20px;
  height: 20px;
  border-right: 2px solid #00d4ff;
  border-bottom: 2px solid #00d4ff;
  transform: rotate(-45deg);
  animation: scroll-arrow 1.5s infinite;
}

@keyframes scroll-arrow {
  0%, 100% { opacity: 0; transform: rotate(-45deg) translateY(-5px); }
  50% { opacity: 1; transform: rotate(-45deg) translateY(5px); }
}

.featured-section {
  position: relative;
  padding: 6rem 2rem;
  margin: 0;
  background: linear-gradient(180deg, transparent 0%, rgba(0, 50, 100, 0.1) 50%, transparent 100%);
  z-index: 1;
}

.section-header {
  text-align: center;
  margin-bottom: 4rem;
  position: relative;
}

.header-line {
  width: 80px;
  height: 2px;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  margin: 0 auto 1.5rem;
}

.section-title {
  font-size: 3rem;
  text-transform: uppercase;
  background: linear-gradient(90deg, #00d4ff, #0066ff, #00d4ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 0.5rem;
}

.section-desc {
  font-size: 1.1rem;
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2.5rem;
  max-width: 1400px;
  margin: 0 auto;
}

.card-item {
  position: relative;
  aspect-ratio: 3/4;
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 1px solid var(--element-color);
  border-radius: 0;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
}

.card-glow {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, var(--element-color), transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: 0;
}

.card-item:hover .card-glow {
  opacity: 0.1;
}

.card-inner {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(0, 212, 255, 0.2);
}

.card-id {
  font-size: 2rem;
  font-weight: 900;
  color: var(--element-color);
  text-shadow: 0 0 10px var(--element-color);
}

.card-element {
  font-size: 0.75rem;
  color: #888;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.card-body {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.card-name {
  font-size: 1.4rem;
  color: #fff;
  margin-bottom: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.card-desc {
  font-size: 0.9rem;
  color: #aabbdd;
  line-height: 1.5;
  margin-bottom: 1.5rem;
  flex: 1;
}

.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 1rem;
  border-top: 1px solid rgba(0, 212, 255, 0.2);
}

.power-display {
  font-size: 1.1rem;
  color: var(--element-color);
  font-weight: 700;
  text-shadow: 0 0 10px var(--element-color);
}

.rarity {
  color: #FFD60A;
  font-size: 1rem;
}

.card-item:hover {
  border-color: var(--element-color);
  box-shadow: 0 0 40px var(--element-color), inset 0 0 40px rgba(0, 212, 255, 0.05);
  transform: translateY(-15px) scale(1.03);
}

.features-section {
  padding: 6rem 2rem;
  margin: 0;
  background: linear-gradient(180deg, transparent 0%, rgba(0, 50, 100, 0.1) 50%, transparent 100%);
  position: relative;
  z-index: 1;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2.5rem;
  max-width: 1400px;
  margin: 0 auto;
}

.feature-card {
  padding: 2rem;
  background: linear-gradient(135deg, rgba(0, 50, 100, 0.2), rgba(0, 20, 50, 0.3));
  border: 1px solid #00d4ff;
  border-radius: 0;
  text-align: center;
  transition: all 0.4s ease;
}

.feature-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  display: block;
}

.feature-title {
  font-size: 1.4rem;
  color: #00d4ff;
  margin-bottom: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.feature-text {
  color: #aabbdd;
  line-height: 1.6;
}

.feature-card:hover {
  border-color: #00d4ff;
  box-shadow: 0 0 30px #00d4ff, inset 0 0 30px rgba(0, 212, 255, 0.05);
  transform: translateY(-10px);
}

.cta-section {
  padding: 6rem 2rem;
  margin: 0;
  background: linear-gradient(135deg, #000033 0%, #000 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  z-index: 1;
}

.cta-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.1), transparent);
  pointer-events: none;
}

.cta-content {
  text-align: center;
  position: relative;
  z-index: 2;
}

.cta-title {
  font-size: 3rem;
  text-transform: uppercase;
  background: linear-gradient(90deg, #00d4ff, #0066ff, #00d4ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 1rem;
}

.cta-subtitle {
  font-size: 1.2rem;
  color: #88aaff;
  margin-bottom: 2rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.cta-btn {
  display: inline-flex;
  padding: 1.2rem 3rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  border: none;
  border-radius: 0;
  font-weight: 900;
  font-size: 1rem;
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 2px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  box-shadow: 0 0 30px #00d4ff;
}

.cta-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 50px #00d4ff, 0 0 80px #0066ff;
}

.glow {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.3);
  transition: width 0.5s, height 0.5s;
}

.cta-btn:active .glow {
  width: 300px;
  height: 300px;
}

@media (max-width: 1024px) {
  .hero-content-wrapper {
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .hero-title {
    font-size: 3rem;
  }

  .hero-subtitle {
    font-size: 1.4rem;
  }

  .hologram-card {
    width: 250px;
    height: 320px;
  }

  .section-title {
    font-size: 2.2rem;
  }

  .cta-title {
    font-size: 2rem;
  }
}

@media (max-width: 768px) {
  .hero-section {
    min-height: auto;
    padding: 3rem 1rem;
  }

  .hero-title {
    font-size: 2.2rem;
  }

  .hero-subtitle {
    font-size: 1.1rem;
  }

  .button-group {
    flex-direction: column;
  }

  .neon-btn {
    width: 100%;
    justify-content: center;
  }

  .stats-row {
    gap: 1rem;
    justify-content: space-around;
  }

  .stat-number {
    font-size: 1.5rem;
  }

  .divider {
    display: none;
  }

  .hologram-card {
    width: 200px;
    height: 280px;
  }

  .cards-grid {
    grid-template-columns: 1fr;
  }

  .section-title {
    font-size: 1.8rem;
  }

  .features-grid {
    grid-template-columns: 1fr;
  }

  .cta-title {
    font-size: 1.5rem;
  }

  .cta-subtitle {
    font-size: 1rem;
  }
}

@media (max-width: 480px) {
  .hero-title {
    font-size: 1.8rem;
  }

  .hero-subtitle {
    font-size: 1rem;
  }

  .neon-btn {
    padding: 0.75rem 1.5rem;
    font-size: 0.85rem;
  }
}

.lore-section {
  position: relative;
  padding: 6rem 2rem 10rem 2rem;
  margin: 0;
  background: linear-gradient(180deg, #0a0820 0%, #000000 50%, #000000 100%);
  min-height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  z-index: 1;
}

.lore-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 100, 150, 0.05), transparent);
  pointer-events: none;
}

.lore-container {
  display: grid;
  grid-template-columns: 120px 1fr 400px;
  gap: 3rem;
  max-width: 1400px;
  width: 100%;
  align-items: center;
  position: relative;
  z-index: 2;
}

.lore-sidebar {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  align-items: center;
  padding-top: 2rem;
}

.lore-logo {
  font-size: 1.2rem;
  font-weight: 900;
  color: #ffffff;
  letter-spacing: 3px;
  writing-mode: vertical-rl;
  text-orientation: mixed;
  transform: rotate(180deg);
  text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
}

.lore-icons {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.lore-icon {
  width: 50px;
  height: 50px;
  border: 2px solid #ffffff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  background: rgba(0, 0, 0, 0.5);
  transition: all 0.3s ease;
}

.lore-icon:hover {
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
  border-color: #88ccff;
}

.palette-icon::before,
.palette-icon::after {
  content: '';
  position: absolute;
}

.palette-icon::before {
  width: 20px;
  height: 20px;
  border: 1px solid #ffffff;
  border-radius: 50%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2px;
  background: 
    linear-gradient(135deg, #FF6B35 0%, #FF6B35 25%, #00A8E8 25%, #00A8E8 50%, #06D6A0 50%, #06D6A0 75%, #FFD60A 75%);
  border-radius: 0;
  width: 16px;
  height: 16px;
}

.struct-icon::before {
  content: '';
  width: 24px;
  height: 24px;
  border: 1.5px solid #ffffff;
  position: absolute;
}

.struct-icon::after {
  content: '';
  width: 12px;
  height: 12px;
  border: 1px solid #ffffff;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.spacecraft-viewer {
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  height: 450px;
}

.hud-frame {
  position: relative;
  width: 350px;
  height: 350px;
}

.hud-center {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  z-index: 2;
}

.spacecraft-model {
  width: 180px;
  height: 270px;
  filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.2));
}

.spacecraft-svg {
  filter: drop-shadow(0 0 10px rgba(136, 221, 255, 0.3));
  animation: float 6s ease-in-out infinite;
}

.hud-circle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 320px;
  height: 320px;
  border: 2px solid #ffffff;
  border-radius: 50%;
  opacity: 0.6;
  z-index: 1;
}

.hud-ticks {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 320px;
  height: 320px;
}

.hud-ticks::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: conic-gradient(
    from 0deg,
    #ffffff 0deg 2deg,
    transparent 2deg 44deg,
    #ffffff 44deg 46deg,
    transparent 46deg 88deg,
    #ffffff 88deg 90deg,
    transparent 90deg 134deg,
    #ffffff 134deg 136deg,
    transparent 136deg 178deg,
    #ffffff 178deg 180deg,
    transparent 180deg 224deg,
    #ffffff 224deg 226deg,
    transparent 226deg 268deg,
    #ffffff 268deg 270deg,
    transparent 270deg 314deg,
    #ffffff 314deg 316deg,
    transparent 316deg 360deg
  );
  opacity: 0.7;
  z-index: 1;
}

.lore-content {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  padding: 2rem;
  background: linear-gradient(135deg, rgba(0, 20, 50, 0.4), rgba(10, 8, 32, 0.4));
  border-left: 2px solid rgba(255, 255, 255, 0.2);
  position: relative;
  z-index: 2;
}

.lore-title {
  font-size: 1.8rem;
  color: #ffffff;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 0;
  text-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
}

.lore-text {
  font-size: 1rem;
  color: #cccccc;
  line-height: 1.7;
  margin: 0;
}

.lore-tech {
  font-size: 0.9rem;
  color: #888888;
  line-height: 1.8;
  font-family: 'Roboto Mono', monospace;
  margin: 0;
  padding: 1rem;
  background: rgba(0, 0, 0, 0.3);
  border-left: 2px solid #88ccff;
}

.tech-label {
  color: #88ccff;
  font-weight: 700;
  text-transform: uppercase;
}

.nav-controls {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  margin-top: 1rem;
  justify-content: flex-end;
}

.nav-btn {
  width: 48px;
  height: 48px;
  border: 2px solid #ffffff;
  background: transparent;
  border-radius: 50%;
  color: #ffffff;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.nav-btn::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(circle, #ffffff, transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.nav-btn:hover {
  border-color: #88ccff;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
}

.nav-btn:hover::before {
  opacity: 0.1;
}

.nav-btn svg {
  width: 20px;
  height: 20px;
  position: relative;
  z-index: 1;
}

.page-indicator {
  color: #FFD60A;
  font-size: 1.1rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 10px rgba(255, 214, 10, 0.5);
  min-width: 60px;
  text-align: center;
}

@media (max-width: 1024px) {
  .lore-container {
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .lore-sidebar {
    flex-direction: row;
    justify-content: center;
    padding: 0;
  }

  .lore-logo {
    writing-mode: horizontal-tb;
    transform: none;
  }

  .spacecraft-viewer {
    height: 350px;
  }

  .hud-frame {
    width: 280px;
    height: 280px;
  }

  .hud-circle {
    width: 250px;
    height: 250px;
  }

  .lore-content {
    padding: 1.5rem;
  }

  .lore-title {
    font-size: 1.4rem;
  }

  .lore-text {
    font-size: 0.95rem;
  }
}

@media (max-width: 768px) {
  .lore-section {
    padding: 3rem 1rem;
    min-height: auto;
  }

  .lore-container {
    grid-template-columns: 1fr;
  }

  .spacecraft-viewer {
    height: 280px;
  }

  .hud-frame {
    width: 240px;
    height: 240px;
  }

  .hud-circle {
    width: 200px;
    height: 200px;
  }

  .lore-content {
    padding: 1.5rem;
    border-left: none;
    border-top: 2px solid rgba(255, 255, 255, 0.2);
  }

  .lore-title {
    font-size: 1.2rem;
  }

  .lore-text {
    font-size: 0.9rem;
  }

  .nav-controls {
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .lore-section {
    padding: 2rem 1rem;
  }

  .lore-sidebar {
    flex-direction: column;
    gap: 1rem;
  }

  .lore-logo {
    font-size: 1rem;
  }

  .lore-icon {
    width: 40px;
    height: 40px;
  }

  .spacecraft-viewer {
    height: 220px;
  }

  .hud-frame {
    width: 180px;
    height: 180px;
  }

  .hud-circle {
    width: 150px;
    height: 150px;
  }

  .lore-title {
    font-size: 1rem;
  }

  .lore-text,
  .lore-tech {
    font-size: 0.85rem;
  }

  .nav-btn {
    width: 40px;
    height: 40px;
  }

  .nav-btn svg {
    width: 16px;
    height: 16px;
  }

  .page-indicator {
    font-size: 0.9rem;
  }
}
</style>
