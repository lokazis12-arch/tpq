<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Profil Saya" showBack role="wali_santri" />
    <main class="page-content">
      <div class="profile-header">
        <div class="profile-avatar"><span class="material-icon" style="font-size:40px;color:white;">person</span></div>
        <h2 style="font-size:20px;font-weight:700;color:var(--color-on-surface);margin-top:12px;">{{ profile.name }}</h2>
        <p style="font-size:13px;color:var(--color-outline);">{{ profile.email }}</p>
      </div>

      <div class="card" style="margin-bottom:16px;">
        <h3 style="font-size:15px;font-weight:600;margin-bottom:16px;">Informasi Akun</h3>
        <form @submit.prevent="handleUpdate" class="profile-form">
          <div class="form-field"><label class="input-label">Nama</label><input v-model="profile.name" class="input" /></div>
          <div class="form-field"><label class="input-label">Email</label><input v-model="profile.email" class="input" disabled style="background:var(--color-surface-container);" /></div>
          <button type="submit" :disabled="loading" class="btn btn-primary" style="width:100%;">{{ loading ? 'Menyimpan...' : 'Simpan Perubahan' }}</button>
        </form>
      </div>

      <div class="card">
        <h3 style="font-size:15px;font-weight:600;margin-bottom:16px;">Ganti Password</h3>
        <form @submit.prevent="handleChangePassword" class="profile-form">
          <div class="form-field"><label class="input-label">Password Baru</label><input v-model="newPassword" type="password" class="input" minlength="6" placeholder="Minimal 6 karakter" /></div>
          <button type="submit" :disabled="passwordLoading" class="btn btn-ghost" style="width:100%;">{{ passwordLoading ? 'Mengganti...' : 'Ganti Password' }}</button>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAuth } from '../../composables/useAuth'
import { useToast } from '../../composables/useToast'
import AppNavbar from '../../components/AppNavbar.vue'

const { showSuccess } = useToast()
const profile = ref({ name: '', email: '' })
const newPassword = ref(''); const loading = ref(false); const passwordLoading = ref(false)
const { getUser } = useAuth()

const fetchProfile = () => { const u = getUser(); if (u) profile.value = { name: u.name, email: u.email } }
const handleUpdate = () => { const u = getUser(); if (u) { u.name = profile.value.name; localStorage.setItem('user', JSON.stringify(u)); showSuccess('Profile berhasil diupdate!') } }
const handleChangePassword = () => { showSuccess('Password tidak bisa diubah di mode demo') }
onMounted(fetchProfile)
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.profile-header { text-align:center; padding:32px 0 24px; }
.profile-avatar { width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg,#006747,#0b6c4b); display:inline-flex; align-items:center; justify-content:center; box-shadow:var(--shadow-level-2); }
.profile-form { display:flex; flex-direction:column; gap:14px; }
.form-field { display:flex; flex-direction:column; }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
