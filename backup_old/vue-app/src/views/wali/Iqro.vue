<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Progres Iqro" showBack role="wali_santri" />
    <main class="page-content">
      <h2 class="page-title">Progres Membaca Iqro</h2>
      <div class="progress-cards">
        <div v-for="p in progresList" :key="p.id" class="card animate-slide-up" style="margin-bottom:10px;">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
            <span class="chip chip-emerald">Jilid {{ p.jilid }}</span>
            <span class="chip" :class="p.kategori==='hafalan'?'chip-success':'chip-neutral'">{{ p.kategori }}</span>
          </div>
          <p style="font-size:14px;color:var(--color-on-surface);margin-bottom:8px;">Halaman {{ p.halaman }} / 32</p>
          <div class="progress-track"><div class="progress-fill" :style="{width: (p.halaman/32*100)+'%'}"></div></div>
          <p style="font-size:12px;color:var(--color-outline);margin-top:6px;">{{ formatDate(p.created_at) }}</p>
        </div>
        <div v-if="progresList.length===0" class="empty-state"><span class="material-icon">menu_book</span><p>Belum ada data progres</p></div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase, safeQuery } from '../../lib/supabase'
import AppNavbar from '../../components/AppNavbar.vue'

const progresList = ref([])
const fetchProgres = async () => {
  const { data } = await safeQuery(() => supabase.from('progres_iqro').select('*').order('created_at', { ascending: false }))
  progresList.value = data || []
}
const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
onMounted(fetchProgres)
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.page-title { font-size:20px; font-weight:700; color:var(--color-on-surface); margin-bottom:16px; }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
