<template>
  <div class="home-container">
    <!-- Hero Section -->
    <div class="hero-section">
      <v-container class="hero-wrapper">
        <v-row class="align-center">
          <v-col cols="12" md="6" class="hero-content">
            <h1 class="hero-title">Master the Cards</h1>
            <p class="hero-subtitle">
              Dive into an epic battle of strategy and skill. Collect powerful cards, build your ultimate deck, and dominate the arena.
            </p>
            <div class="button-group mt-8">
              <v-btn 
                size="large" 
                color="primary" 
                to="/cards" 
                class="cta-btn"
              >
                See Cards
              </v-btn>
              <v-btn 
                size="large" 
                variant="outlined" 
                to="/play"
                color="secondary"
                class="cta-btn"
              >
                Start Playing
              </v-btn>
            </div>
          </v-col>
          <v-col cols="12" md="6">
            <div class="hero-image-wrapper">
              <div class="glow-effect"></div>
              <v-img
                src="https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800&h=1000&fit=crop"
                alt="Card Game"
                class="hero-image"
              ></v-img>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <!-- Featured Cards Section -->
    <div class="cards-section">
      <v-container>
        <div class="text-center mb-12">
          <h2 class="cards-title">Featured Cards</h2>
          <p class="section-subtitle">Discover the most powerful cards in your arsenal</p>
        </div>
        <v-row class="cards-grid">
          <v-col cols="12" sm="6" md="4" v-for="card in featuredCards" :key="card.id">
            <div class="card-wrapper">
              <v-card class="card-item">
                <div class="card-header">
                  <span class="card-number">#{{ String(card.id).padStart(3, '0') }}</span>
                </div>
                <v-card-text class="card-content">
                  <h3 class="card-title">{{ card.name }}</h3>
                  <p class="card-description">{{ card.description }}</p>
                  <div class="card-stats">
                    <span class="power-badge">⚡ {{ card.power }}</span>
                  </div>
                </v-card-text>
              </v-card>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>
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
          name: 'Fire Dragon',
          description: 'Unleash devastating flames upon your enemies with this legendary card.',
          power: 85
        },
        {
          id: 2,
          name: 'Ice Wizard',
          description: 'Freeze your opponent\'s deck with powerful cryogenic magic.',
          power: 78
        },
        {
          id: 3,
          name: 'Shadow Assassin',
          description: 'Strike from the darkness with deadly precision and speed.',
          power: 82
        },
        {
          id: 4,
          name: 'Divine Healer',
          description: 'Restore health and grant protection to your allies in battle.',
          power: 70
        },
        {
          id: 5,
          name: 'Thunder Knight',
          description: 'Channel lightning to electrify the battlefield and stun foes.',
          power: 80
        },
        {
          id: 6,
          name: 'Nature Guardian',
          description: 'Command the forces of nature to defend and empower your team.',
          power: 75
        }
      ]
    }
  }
}
</script>

<style scoped>
.home-container {
  background: #000 !important;
  color: #fff;
  overflow-x: hidden;
}

.v-main {
  background: #000 !important;
}

.v-container {
  background: transparent !important;
}

/* ======== HERO SECTION ======== */
.hero-section {
  background: linear-gradient(135deg, #1a0033 0%, #0d0011 50%, #000 100%);
  min-height: 85vh;
  display: flex;
  align-items: center;
  padding: 4rem 0;
  position: relative;
}

.hero-wrapper {
  max-width: 1400px;
}

.hero-content {
  z-index: 2;
}

.hero-title {
  font-size: 3.75rem;
  font-weight: 800;
  line-height: 1.1;
  margin-bottom: 1.5rem;
  background: linear-gradient(to right, #c084fc, #e9d5ff, #fff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  letter-spacing: -0.02em;
}

.hero-subtitle {
  font-size: 1.25rem;
  color: #d1d5db;
  line-height: 1.8;
  margin-bottom: 2rem;
  max-width: 500px;
}

.button-group {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.cta-btn {
  padding: 0.75rem 2rem !important;
  font-weight: 600;
  font-size: 1rem;
  letter-spacing: 0.5px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.v-btn.cta-btn[color="primary"] {
  background: linear-gradient(to right, #9333ea, #7e22ce) !important;
  color: #fff !important;
}

.v-btn.cta-btn[color="primary"]:hover {
  background: linear-gradient(to right, #a855f7, #9333ea) !important;
  transform: translateY(-2px);
  box-shadow: 0 12px 24px rgba(147, 51, 234, 0.4) !important;
}

.v-btn.cta-btn[color="secondary"] {
  border-color: #9333ea !important;
  color: #9333ea !important;
}

.v-btn.cta-btn[color="secondary"]:hover {
  background-color: rgba(147, 51, 234, 0.1) !important;
  border-color: #c084fc !important;
  color: #c084fc !important;
  transform: translateY(-2px);
}

.hero-image-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  z-index: 1;
}

.glow-effect {
  position: absolute;
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, rgba(147, 51, 234, 0.3) 0%, transparent 70%);
  border-radius: 50%;
  filter: blur(60px);
  z-index: 0;
}

.hero-image {
  position: relative;
  width: 100%;
  max-width: 400px;
  border-radius: 12px;
  box-shadow: 0 25px 50px rgba(147, 51, 234, 0.35),
              0 0 100px rgba(147, 51, 234, 0.15);
  z-index: 2;
}

/* ======== CARDS SECTION ======== */
.cards-section {
  background: linear-gradient(180deg, #0a0a0a 0%, #000 100%);
  padding: 5rem 0;
}

.cards-title {
  font-size: 2.5rem;
  font-weight: 800;
  background: linear-gradient(to right, #c084fc, #e9d5ff, #fff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 0.5rem;
  letter-spacing: -0.01em;
}

.section-subtitle {
  font-size: 1.125rem;
  color: #9ca3af;
  margin-top: 0.5rem;
}

.card-wrapper {
  perspective: 1000px;
  height: 100%;
}

.card-item {
  background: linear-gradient(135deg, #1a0033 0%, #0d0011 100%) !important;
  border: 1px solid rgba(192, 132, 252, 0.3) !important;
  border-radius: 12px !important;
  padding: 0 !important;
  min-height: 380px;
  display: flex !important;
  flex-direction: column !important;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
  position: relative;
  overflow: hidden;
}

.card-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(192, 132, 252, 0.1), transparent);
  transition: left 0.5s;
}

.card-item:hover::before {
  left: 100%;
}

.card-item:hover {
  border-color: rgba(192, 132, 252, 0.8) !important;
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(147, 51, 234, 0.25),
              0 0 60px rgba(147, 51, 234, 0.15) !important;
}

.card-header {
  padding: 1.5rem 1.5rem 0 1.5rem;
  position: relative;
  flex-shrink: 0;
}

.card-number {
  font-size: 2.5rem;
  font-weight: 900;
  color: rgba(192, 132, 252, 0.4);
  text-transform: uppercase;
  letter-spacing: 2px;
}

.card-content {
  padding: 0 1.5rem 1.5rem 1.5rem;
  position: relative;
  z-index: 2;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.card-title {
  font-size: 1.4rem;
  font-weight: 700;
  color: #fff;
  margin-bottom: 0.75rem;
  letter-spacing: -0.01em;
}

.card-description {
  font-size: 0.95rem;
  color: #d1d5db;
  line-height: 1.6;
  margin-bottom: 1rem;
}

.card-stats {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.power-badge {
  display: inline-block;
  padding: 0.5rem 1rem;
  background: linear-gradient(to right, rgba(147, 51, 234, 0.2), rgba(6, 182, 212, 0.2));
  border: 1px solid rgba(147, 51, 234, 0.5);
  border-radius: 6px;
  color: #c084fc;
  font-weight: 600;
  font-size: 0.9rem;
}

/* ======== RESPONSIVE ======== */
@media (max-width: 960px) {
  .hero-title {
    font-size: 2.5rem;
  }

  .hero-subtitle {
    font-size: 1.1rem;
  }

  .cards-title {
    font-size: 2rem;
  }

  .button-group {
    flex-direction: column;
  }

  .cta-btn {
    width: 100%;
  }
}

@media (max-width: 600px) {
  .hero-section {
    min-height: auto;
    padding: 2rem 0;
  }

  .hero-title {
    font-size: 2rem;
  }

  .hero-subtitle {
    font-size: 1rem;
  }

  .cards-title {
    font-size: 1.75rem;
  }

  .card-number {
    font-size: 1.8rem;
  }

  .card-title {
    font-size: 1.15rem;
  }

  .card-description {
    font-size: 0.85rem;
  }

  .glow-effect {
    width: 300px;
    height: 300px;
  }

  .hero-image {
    max-width: 300px;
  }
}
</style>
