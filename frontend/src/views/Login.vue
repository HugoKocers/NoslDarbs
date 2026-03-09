<template>
  <div class="auth-container">
    <div class="animated-bg"></div>

    <div class="auth-card">
      <div class="auth-header">
        <h1 class="auth-title">CARDQUEST</h1>
        <p class="auth-subtitle">Neural Battlegrounds</p>
      </div>

      <form @submit.prevent="handleLogin" class="auth-form">
        <div class="form-group">
          <label for="email" class="form-label">Email Address</label>
          <input
            id="email"
            v-model="email"
            type="email"
            class="form-input"
            placeholder="Enter your email"
            required
            aria-label="Email address"
            aria-disabled="isLoading"
          />
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input
            id="password"
            v-model="password"
            type="password"
            class="form-input"
            placeholder="Enter your password"
            required
            aria-label="Password"
            aria-disabled="isLoading"
          />
        </div>

        <div v-if="authStore.error" class="error-message" role="alert">
          {{ authStore.error }}
        </div>

        <button
          type="submit"
          class="auth-btn"
          :disabled="authStore.isLoading"
          aria-busy="authStore.isLoading"
        >
          <span v-if="!authStore.isLoading">LOGIN</span>
          <span v-else>SIGNING IN...</span>
        </button>
      </form>

      <div class="auth-footer">
        <p>Don't have an account?
          <router-link to="/signup" class="auth-link">Sign up here</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

const router = useRouter()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')

const handleLogin = async () => {
  try {
    await authStore.login(email.value, password.value)
    router.push('/profile')
  } catch (error) {
    console.error('Login error:', error)
  }
}
</script>

<style scoped>
.auth-container {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  background: #000;
  color: #fff;
  overflow: hidden;
}

.animated-bg {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.05) 0%, transparent 50%);
  pointer-events: none;
  z-index: 0;
}

.auth-card {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 450px;
  padding: 3rem 2rem;
  background: linear-gradient(135deg, rgba(0, 20, 50, 0.4), rgba(10, 8, 32, 0.6));
  border: 2px solid #00d4ff;
  border-radius: 0;
  box-shadow: 0 0 50px rgba(0, 212, 255, 0.2), inset 0 0 50px rgba(0, 212, 255, 0.05);
}

.auth-header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.auth-title {
  font-size: 2.5rem;
  font-weight: 900;
  background: linear-gradient(90deg, #00d4ff, #0066ff, #00d4ff);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  margin: 0;
  letter-spacing: 2px;
  text-transform: uppercase;
}

.auth-subtitle {
  font-size: 1rem;
  color: #88aaff;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 0.5rem 0 0 0;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-label {
  font-size: 0.9rem;
  font-weight: 700;
  color: #00d4ff;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.form-input {
  padding: 0.75rem 1rem;
  background: rgba(0, 0, 0, 0.5);
  border: 1px solid #00d4ff;
  border-radius: 0;
  color: #fff;
  font-size: 1rem;
  font-family: 'Roboto Mono', monospace;
  transition: all 0.2s ease;
}

.form-input:focus {
  outline: none;
  background: rgba(0, 20, 40, 0.7);
  border-color: #88ddff;
  box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
}

.form-input::placeholder {
  color: #666;
}

.error-message {
  padding: 0.75rem;
  background: rgba(255, 50, 50, 0.1);
  border-left: 3px solid #ff3232;
  color: #ff8888;
  font-size: 0.9rem;
  border-radius: 0;
}

.auth-btn {
  padding: 0.9rem 1.5rem;
  background: linear-gradient(90deg, #00d4ff, #0066ff);
  color: #000;
  border: none;
  border-radius: 0;
  font-weight: 900;
  font-size: 0.95rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 0 30px #00d4ff;
}

.auth-btn:hover:not(:disabled) {
  transform: scale(1.02);
  box-shadow: 0 0 50px #00d4ff, 0 0 80px #0066ff;
}

.auth-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.auth-footer {
  text-align: center;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(0, 212, 255, 0.2);
}

.auth-footer p {
  font-size: 0.9rem;
  color: #aabbdd;
  margin: 0;
}

.auth-link {
  color: #00d4ff;
  text-decoration: none;
  font-weight: 700;
  transition: all 0.2s ease;
}

.auth-link:hover {
  text-shadow: 0 0 10px #00d4ff;
}

@media (max-width: 768px) {
  .auth-card {
    padding: 2rem 1.5rem;
  }

  .auth-title {
    font-size: 2rem;
  }

  .auth-subtitle {
    font-size: 0.9rem;
  }
}
</style>
