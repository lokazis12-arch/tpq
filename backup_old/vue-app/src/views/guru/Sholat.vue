<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Penilaian Sholat" showBack role="guru" />
    <main class="page-content">
      <!-- Student Selector -->
      <div class="card card-accent mb-4">
        <div class="form-field">
          <label class="input-label">Pilih Santri untuk Dinilai</label>
          <select v-model="selectedSantriId" @change="loadAssessment" class="input">
            <option value="">-- Pilih Santri --</option>
            <option v-for="s in santriList" :key="s.id" :value="s.id">{{ s.nama }}</option>
          </select>
        </div>
      </div>

      <div v-if="selectedSantriId" class="assessment-container">
        <!-- Student Info Header (Matching Design) -->
        <div class="student-header card mb-4">
          <div class="avatar-container">
            <div class="avatar">
              <span class="material-icon">person</span>
            </div>
          </div>
          <div class="info">
            <h2 class="name">{{ selectedSantri?.nama }}</h2>
            <p class="meta">Tahfidz Sore • ID: {{ selectedSantriId.slice(0, 8) }}</p>
            <span class="status-chip">AKTIF</span>
          </div>
        </div>

        <div class="section-label">PENILAIAN SHOLAT <span class="date">{{ currentMonth }}</span></div>

        <!-- Assessment Groups -->
        <div v-for="group in groups" :key="group.title" class="assessment-group card mb-4 p-0 overflow-hidden">
          <div class="group-header">
            <span class="material-icon group-icon">{{ group.icon }}</span>
            <span class="group-title">{{ group.title }}</span>
          </div>
          
          <div class="group-body">
            <div v-for="item in group.items" :key="item.id" class="assessment-item">
              <div class="item-info">
                <span class="item-label">{{ item.label }}</span>
                <span class="item-status">{{ getUpdateStatus(item.id) }}</span>
              </div>
              <div class="rating-toggle">
                <button 
                  type="button" 
                  class="rating-btn" 
                  :class="{ active: form[item.id] === 'belum' }"
                  @click="form[item.id] = 'belum'"
                >BELUM LANCAR</button>
                <button 
                  type="button" 
                  class="rating-btn btn-lancar" 
                  :class="{ active: form[item.id] === 'lancar' }"
                  @click="form[item.id] = 'lancar'"
                >LANCAR</button>
                <button 
                  type="button" 
                  class="rating-btn btn-sempurna" 
                  :class="{ active: form[item.id] === 'sempurna' }"
                  @click="form[item.id] = 'sempurna'"
                >SEMPURNA</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Notes Section -->
        <div class="notes-group card mb-4 p-0 overflow-hidden">
          <div class="group-header">
            <span class="material-icon group-icon">notes</span>
            <span class="group-title">Catatan & Doa</span>
          </div>
          <div class="p-4">
            <textarea 
              v-model="form.catatan" 
              class="input notes-area" 
              placeholder="Tambah catatan guru..."
              rows="4"
            ></textarea>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="submit-container">
          <button @click="handleSave" :disabled="saving" class="btn btn-save">
            <span class="material-icon">save</span>
            {{ saving ? 'Menyimpan...' : 'Simpan Pengetahuan' }}
          </button>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="empty-state py-12">
        <span class="material-icon" style="font-size: 64px; opacity: 0.2;">mosque</span>
        <p>Silakan pilih santri untuk memulai penilaian</p>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { supabase, safeQuery } from '../../lib/supabase'
import { useToast } from '../../composables/useToast'
import AppNavbar from '../../components/AppNavbar.vue'

const { showSuccess, showError } = useToast()
const santriList = ref([])
const selectedSantriId = ref('')
const saving = ref(false)
const existingData = ref(null)

const currentMonth = new Date().toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })

const form = ref({
  doa_sebelum_azan: 'belum',
  azan: 'belum',
  doa_setelah_azan: 'belum',
  niat: 'belum',
  takbir: 'belum',
  iftitah: 'belum',
  alfatihah_ayat: 'belum',
  rukuk: 'belum',
  itidal: 'belum',
  sujud: 'belum',
  duduk_antara_sujud: 'belum',
  tahiyat_awal: 'belum',
  qunut: 'belum',
  tahiyat_akhir: 'belum',
  salam: 'belum',
  zikir: 'belum',
  doa_setelah_sholat: 'belum',
  catatan: ''
})

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

const selectedSantri = computed(() => santriList.value.find(s => s.id === selectedSantriId.value))

const fetchSantri = async () => {
  const { data } = await safeQuery(() => supabase.from('santri').select('*').order('nama'))
  santriList.value = data || []
}

const loadAssessment = async () => {
  if (!selectedSantriId.value) return
  
  const { data, error } = await safeQuery(() => 
    supabase.from('penilaian_sholat').select('*').eq('santri_id', selectedSantriId.value).maybeSingle()
  )
  
  if (data) {
    existingData.value = data
    // Update form with existing data
    Object.keys(form.value).forEach(key => {
      if (data[key] !== undefined) form.value[key] = data[key]
    })
  } else {
    existingData.value = null
    // Reset form
    Object.keys(form.value).forEach(key => {
      form.value[key] = key === 'catatan' ? '' : 'belum'
    })
  }
}

const getUpdateStatus = (id) => {
  if (!existingData.value) return 'Belum Dinilai'
  const date = new Date(existingData.value.updated_at)
  return `Update: ${date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })}`
}

const handleSave = async () => {
  saving.value = true
  const payload = {
    ...form.value,
    santri_id: selectedSantriId.value,
    updated_at: new Date().toISOString()
  }

  const { error } = await supabase.from('penilaian_sholat').upsert([payload], { onConflict: 'santri_id' })

  if (error) {
    showError('Gagal menyimpan penilaian')
  } else {
    showSuccess('Penilaian sholat berhasil disimpan!')
    loadAssessment()
  }
  saving.value = false
}

onMounted(fetchSantri)
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:120px; }

.student-header {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 16px;
}

.avatar {
  width: 56px;
  height: 56px;
  background: #E8F5E9;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #2E7D32;
}

.info .name { font-size: 18px; font-weight: 700; color: var(--color-on-surface); margin: 0; }
.info .meta { font-size: 13px; color: var(--color-outline); margin: 2px 0 6px; }
.status-chip {
  background: #E8F5E9;
  color: #2E7D32;
  font-size: 10px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 4px;
}

.section-label {
  font-size: 11px;
  font-weight: 700;
  color: var(--color-outline);
  letter-spacing: 1px;
  margin-bottom: 12px;
  display: flex;
  justify-content: space-between;
}

.assessment-group .group-header {
  background: #F1F8E9;
  padding: 10px 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.group-icon { font-size: 18px; color: #33691E; }
.group-title { font-size: 14px; font-weight: 600; color: #33691E; }

.assessment-item {
  padding: 16px;
  border-bottom: 1px solid var(--color-surface-container);
}

.assessment-item:last-child { border-bottom: none; }

.item-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.item-label { font-size: 15px; font-weight: 600; color: var(--color-on-surface); }
.item-status { font-size: 11px; color: var(--color-outline); }

.rating-toggle {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 8px;
}

.rating-btn {
  background: #fff;
  border: 1px solid var(--color-surface-container-high);
  border-radius: 8px;
  padding: 10px 4px;
  font-size: 10px;
  font-weight: 700;
  color: var(--color-outline);
  transition: all 0.2s;
}

.rating-btn.active {
  background: #FFEBEE;
  color: #C62828;
  border-color: #EF9A9A;
}

.rating-btn.btn-lancar.active {
  background: #E8F5E9;
  color: #2E7D32;
  border-color: #A5D6A7;
}

.rating-btn.btn-sempurna.active {
  background: #E0F2F1;
  color: #00695C;
  border-color: #80CBC4;
}

.notes-area {
  resize: none;
  background: #FAFAFA;
  border: 1px solid var(--color-surface-container-high);
  font-size: 14px;
}

.submit-container {
  position: fixed;
  bottom: 24px;
  left: 0;
  right: 0;
  padding: 0 16px;
  max-width: 768px;
  margin: 0 auto;
  z-index: 10;
}

@media(min-width: 768px) {
  .submit-container { left: 96px; }
}

.btn-save {
  width: 100%;
  background: #006747;
  color: white;
  padding: 16px;
  border-radius: 12px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: 0 4px 12px rgba(0, 103, 71, 0.3);
}

.btn-save:disabled { opacity: 0.7; }
</style>
