<template>
  <div class="login-page">
    <div class="login-card animate-fade-in">
      <div class="login-header">
        <div class="logo-wrap">
          <span class="material-icon">mosque</span>
        </div>
        <h1 class="app-name">TPQ Darul Ikhlas</h1>
        <h2 class="welcome-text">Selamat Datang</h2>
        <p class="subtitle">Silakan masuk untuk melanjutkan</p>
      </div>

      <div class="role-selector">
        <p class="label">Masuk sebagai</p>
        <div class="role-tabs">
          <button 
            @click="role = 'wali_santri'" 
            :class="['role-tab', { active: role === 'wali_santri' }]"
          >
            Wali Santri
          </button>
          <button 
            @click="role = 'guru'" 
            :class="['role-tab', { active: role === 'guru' }]"
          >
            Guru
          </button>
        </div>
      </div>

      <form @submit.prevent="handleSubmit" class="login-form">
        <div class="form-group">
          <label for="identifier">Email atau Username</label>
          <div class="input-wrap">
            <span class="material-icon">person</span>
            <input 
              id="identifier"
              v-model="email" 
              type="text" 
              placeholder="Masukkan ID Anda"
              required
            >
          </div>
        </div>

        <div class="form-group">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <label for="password">Password</label>
            <a href="#" class="forgot-link">Lupa Password?</a>
          </div>
          <div class="input-wrap">
            <span class="material-icon">lock</span>
            <input 
              id="password"
              v-model="password" 
              :type="showPassword ? 'text' : 'password'" 
              placeholder="••••••••"
              required
            >
            <button type="button" class="toggle-password" @click="showPassword = !showPassword">
              <span class="material-icon">{{ showPassword ? 'visibility_off' : 'visibility' }}</span>
            </button>
          </div>
        </div>

        <div v-if="error" class="error-message">
          <span class="material-icon">error_outline</span>
          {{ error }}
        </div>

        <button type="submit" class="btn-submit" :disabled="loading">
          <span v-if="!loading">Masuk</span>
          <span v-else>Memproses...</span>
          <span v-if="!loading" class="material-icon">arrow_forward</span>
        </button>
      </form>

      <div class="login-footer">
        <p>Belum memiliki akun?</p>
        <p>Hubungi pihak administrasi TPQ.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuth } from '../composables/useAuth'

const router = useRouter()
const { login } = useAuth()

const role = ref('wali_santri')
const email = ref('')
const password = ref('')
const showPassword = ref(false)
const loading = ref(false)
const error = ref('')

const handleSubmit = async () => {
  loading.value = true
  error.value = ''
  
  // Basic validation for username if needed
  let loginEmail = email.value
  if (!loginEmail.includes('@')) {
    loginEmail = `${loginEmail.toLowerCase().replace(/\s+/g, '')}@tpq.com`
  }

  const { data, error: loginError } = await login(loginEmail, password.value)
  
  if (loginError) {
    error.value = loginError.message
    loading.value = false
    return
  }

  // Check if role matches
  if (data.profile.role !== role.value) {
    error.value = `Akun ini tidak terdaftar sebagai ${role.value === 'guru' ? 'Guru' : 'Wali Santri'}.`
    loading.value = false
    return
  }

  if (role.value === 'guru') {
    router.push('/guru')
  } else {
    router.push('/wali')
  }
}
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f8fafc;
  background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
  background-size: 20px 20px;
  padding: 20px;
}

.login-card {
  width: 100%;
  max-width: 440px;
  background: white;
  border-radius: 24px;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
  padding: 40px;
}

.login-header {
  text-align: center;
  margin-bottom: 32px;
}

.logo-wrap {
  width: 64px;
  height: 64px;
  background: #004d34;
  color: white;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
}

.logo-wrap .material-icon {
  font-size: 32px;
}

.app-name {
  font-size: 20px;
  font-weight: 700;
  color: #004d34;
  margin-bottom: 24px;
}

.welcome-text {
  font-size: 32px;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 8px;
}

.subtitle {
  color: #64748b;
  font-size: 15px;
}

.role-selector {
  margin-bottom: 32px;
}

.role-selector .label {
  font-size: 13px;
  font-weight: 600;
  color: #64748b;
  margin-bottom: 12px;
}

.role-tabs {
  display: flex;
  background: #f1f5f9;
  padding: 4px;
  border-radius: 12px;
}

.role-tab {
  flex: 1;
  padding: 10px;
  border: none;
  background: transparent;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  color: #64748b;
  cursor: pointer;
  transition: all 0.2s;
}

.role-tab.active {
  background: white;
  color: #004d34;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.form-group {
  margin-bottom: 24px;
}

.form-group label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #334155;
  margin-bottom: 8px;
}

.input-wrap {
  position: relative;
  display: flex;
  align-items: center;
}

.input-wrap .material-icon {
  position: absolute;
  left: 16px;
  color: #94a3b8;
  font-size: 20px;
}

.input-wrap input {
  width: 100%;
  padding: 12px 16px 12px 48px;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  font-size: 15px;
  transition: all 0.2s;
}

.input-wrap input:focus {
  outline: none;
  border-color: #004d34;
  box-shadow: 0 0 0 4px rgba(0, 77, 52, 0.1);
}

.forgot-link {
  font-size: 12px;
  color: #004d34;
  text-decoration: none;
  font-weight: 600;
}

.toggle-password {
  position: absolute;
  right: 12px;
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
}

.btn-submit {
  width: 100%;
  padding: 14px;
  background: #004d34;
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-submit:hover {
  background: #003a27;
  transform: translateY(-1px);
}

.btn-submit:disabled {
  background: #94a3b8;
  cursor: not-allowed;
  transform: none;
}

.error-message {
  background: #fef2f2;
  color: #b91c1c;
  padding: 12px;
  border-radius: 8px;
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 20px;
}

.login-footer {
  margin-top: 32px;
  text-align: center;
  color: #64748b;
  font-size: 14px;
}

.login-footer p {
  margin: 2px 0;
}

@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fade-in 0.5s ease-out;
}
</style>
