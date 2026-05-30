<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Laporan Sholat" showBack role="wali_santri" />
    <main class="page-content">
      <div v-if="loading" class="loading-state">
        <div class="spinner"></div>
      </div>

      <div v-else-if="assessment" class="assessment-container">
        <!-- Header Info -->
        <div class="student-header card mb-4">
          <div class="avatar-container">
            <div class="avatar">
              <span class="material-icon">person</span>
            </div>
          </div>
          <div class="info">
            <h2 class="name">{{ profile?.name }}</h2>
            <p class="meta">Penilaian Sholat • {{ currentMonth }}</p>
            <span class="status-chip">TERUPDATE</span>
          </div>
        </div>

        <!-- Groups -->
        <div v-for="group in groups" :key="group.title" class="assessment-group card mb-4 p-0 overflow-hidden">
          <div class="group-header">
            <span class="material-icon group-icon">{{ group.icon }}</span>
            <span class="group-title">{{ group.title }}</span>
          </div>
          
          <div class="group-body">
            <div v-for="item in group.items" :key="item.id" class="assessment-item">
              <div class="item-info">
                <span class="item-label">{{ item.label }}</span>
                <span class="chip" :class="ratingChipClass(assessment[item.id])">
                  {{ formatRating(assessment[item.id]) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Teacher Notes -->
        <div v-if="assessment.catatan" class="notes-section card p-4 mb-4">
          <h3 class="notes-title">
            <span class="material-icon">message</span>
            Catatan Guru
          </h3>
          <p class="notes-content">{{ assessment.catatan }}</p>
        </div>

        <div class="footer-info">
          Terakhir diperbarui pada {{ formatDate(assessment.updated_at) }}
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="empty-state py-12">
        <span class="material-icon" style="font-size: 64px; opacity: 0.2;">history_edu</span>
        <p>Belum ada laporan penilaian sholat terbaru</p>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase, safeQuery } from '../../lib/supabase'
import { useAuth } from '../../composables/useAuth'
import AppNavbar from '../../components/AppNavbar.vue'

const { getUser } = useAuth()
const profile = getUser()
const assessment = ref(null)
const loading = ref(true)

const currentMonth = new Date().toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })

const groups = [
  {
    title: 'Azan & Persiapan',
    icon: 'record_voice_over',
    items: [
      { id: 'doa_sebelum_azan', label: 'Doa Sebelum Azan' },
      { id: 'azan', label: 'Azan' },
      { id: 'doa_setelah_azan', label: 'Doa Setelah Azan' }
    ]
  },
  {
    title: 'Gerakan & Bacaan',
    icon: 'accessibility_new',
    items: [
      { id: 'niat', label: 'Niat' },
      { id: 'takbir', label: 'Takbiratul Ihram' },
      { id: 'iftitah', label: 'Doa Iftitah' },
      { id: 'alfatihah_ayat', label: 'Al-Fatihah & Ayat' },
      { id: 'rukuk', label: 'Rukuk' },
      { id: 'itidal', label: "I'tidal" },
      { id: 'sujud', label: 'Sujud' },
      { id: 'duduk_antara_sujud', label: 'Duduk di Antara 2 Sujud' },
      { id: 'tahiyat_awal', label: 'Tahiyat Awal' },
      { id: 'qunut', label: 'Qunut' },
      { id: 'tahiyat_akhir', label: 'Tahiyat Akhir' },
      { id: 'salam', label: 'Salam' }
    ]
  },
  {
    title: 'Zikir & Doa',
    icon: 'menu_book',
    items: [
      { id: 'zikir', label: 'Zikir' },
      { id: 'doa_setelah_sholat', label: 'Doa Setelah Sholat' }
    ]
  }
]

const fetchAssessment = async () => {
  loading.value = true
  try {
    // In demo mode, we might not have a real santri_id linked to user
    // We'll try to find any assessment or match by wali name if possible
    // For now, let's just get the latest assessment to show something
    const { data } = await safeQuery(() => 
      supabase.from('penilaian_sholat').select('*').order('updated_at', { ascending: false }).limit(1).maybeSingle()
    )
    assessment.value = data
  } catch (e) {
    console.error(e)
  }
  loading.value = false
}

const ratingChipClass = (r) => {
  if (r === 'sempurna') return 'chip-success'
  if (r === 'lancar') return 'chip-emerald'
  return 'chip-neutral'
}

const formatRating = (r) => {
  if (r === 'sempurna') return 'Sempurna'
  if (r === 'lancar') return 'Lancar'
  return 'Belum Lancar'
}

const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { 
  day: 'numeric', 
  month: 'long', 
  year: 'numeric',
  hour: '2-digit',
  minute: '2-digit'
})

onMounted(fetchAssessment)
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }

.student-header {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 16px;
}

.avatar {
  width: 56px;
  height: 56px;
  background: #E1F5FE;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #0277BD;
}

.info .name { font-size: 18px; font-weight: 700; color: var(--color-on-surface); margin: 0; }
.info .meta { font-size: 13px; color: var(--color-outline); margin: 2px 0 6px; }
.status-chip {
  background: #E1F5FE;
  color: #0277BD;
  font-size: 10px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 4px;
}

.assessment-group .group-header {
  background: #F5F5F5;
  padding: 10px 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.group-icon { font-size: 18px; color: #424242; }
.group-title { font-size: 14px; font-weight: 600; color: #424242; }

.assessment-item {
  padding: 14px 16px;
  border-bottom: 1px solid var(--color-surface-container);
}

.assessment-item:last-child { border-bottom: none; }

.item-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.item-label { font-size: 14px; font-weight: 500; color: var(--color-on-surface); }

.notes-section {
  background: #FFFDE7;
  border: 1px solid #FFF59D;
}

.notes-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  font-weight: 700;
  color: #F57F17;
  margin-bottom: 8px;
}

.notes-title .material-icon { font-size: 18px; }
.notes-content { font-size: 14px; line-height: 1.5; color: #5D4037; }

.footer-info {
  text-align: center;
  font-size: 11px;
  color: var(--color-outline);
  margin-top: 24px;
}

.loading-state {
  display: flex;
  justify-content: center;
  padding: 48px;
}

.spinner {
  width: 32px;
  height: 32px;
  border: 3px solid #E0E0E0;
  border-top-color: #006747;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

@media(min-width: 768px) {
  .page-content { padding-left: 96px; }
}
</style>
