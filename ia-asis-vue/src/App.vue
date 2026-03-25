<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 text-white flex justify-center items-center p-6">

    <div class="w-full max-w-4xl bg-gray-900 rounded-2xl shadow-2xl p-8">

      <!-- Header -->
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold">AI Content Assistant 🚀</h1>
        <p class="text-gray-400 mt-2">
          Resume, mejora y genera contenido con IA
        </p>
      </div>

      <!-- Input -->
      <textarea v-model="inputText" placeholder="Escribe tu texto aquí..."
        class="w-full p-4 rounded-xl bg-gray-800 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
        rows="5"></textarea>

      <!-- Button -->
      <button @click="processText"
        class="w-full bg-blue-600 py-3 rounded-xl font-semibold hover:bg-blue-700 transition flex justify-center items-center"
        :disabled="loading">
        <span v-if="!loading">Procesar Texto</span>
        <span v-else class="animate-pulse">Procesando...</span>
      </button>

      <!-- Error -->
      <div v-if="error" class="mt-4 bg-red-500/20 text-red-400 p-3 rounded-lg">
        {{ error }}
      </div>

      <!-- Tabs -->
      <div v-if="result" class="mt-8">

        <!-- Tab buttons -->
        <div class="flex gap-2 border-b border-gray-700 mb-4">
          <button v-for="tab in tabs" :key="tab" @click="activeTab = tab" :class="[
            'px-4 py-2 rounded-t-lg text-sm font-medium transition',
            activeTab === tab
              ? 'bg-blue-600 text-white'
              : 'bg-gray-800 text-gray-400 hover:bg-gray-700'
          ]">
            {{ tab }}
          </button>
        </div>

        <!-- Content -->
        <div class="bg-gray-800 p-6 rounded-xl whitespace-pre-wrap text-gray-300 min-h-[150px]">
          {{ parsedResult[activeTab] || 'No hay contenido disponible' }}
        </div>

        <!-- Actions -->
        <div class="flex justify-between mt-4">
          <button @click="copyToClipboard(parsedResult[activeTab])" class="text-blue-400 hover:underline">
            {{ copied ? 'Copiado ✅' : 'Copiar' }}
          </button>

          <button @click="downloadText" class="text-gray-400 hover:underline">
            Descargar
          </button>
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'

// STATE
const inputText = ref('')
const result = ref('')
const loading = ref(false)
const error = ref('')
const activeTab = ref('Completo')

// Tabs
const tabs = ['Completo', 'Resumen', 'Profesional', 'Redes']

// API CALL
const processText = async () => {
  if (!inputText.value.trim()) {
    error.value = 'Por favor escribe un texto.'
    return
  }

  loading.value = true
  error.value = ''
  result.value = ''

  try {
    const response = await axios.post('https://laravel-ai-content-assis-production.up.railway.app/api/process-text', {
      text: inputText.value
    })

    result.value = response.data.result
  } catch (err) {
    error.value = 'Error al procesar el texto'
  } finally {
    loading.value = false
  }
}

// 🧠 PARSER INTELIGENTE
const parsedResult = computed(() => {
  const text = result.value || ''

  return {
    Completo: text,
    Resumen: extract(text, 'Resumen'),
    Profesional: extract(text, 'Profesional'),
    Redes: extract(text, 'Redes')
  }
})

// Función para extraer secciones
function extract(text, section) {
  const regex = new RegExp(
    `\\*\\*${section}\\*\\*\\s*([\\s\\S]*?)(?=\\n\\*\\*|$)`,
    'i'
  )

  const match = text.match(regex)

  if (!match) return 'No disponible'

  const cleaned = match[1].trim()

  if (!cleaned || cleaned === '-' || cleaned === '""') {
    return 'No disponible'
  }

  return cleaned
}

// Copy
const copied = ref(false)

const copyToClipboard = async (text) => {
  if (!text) return
  await navigator.clipboard.writeText(text)
  copied.value = true
  setTimeout(() => copied.value = false, 2000)
}

// Download
const downloadText = () => {
  const blob = new Blob([result.value], { type: 'text/plain' })
  const link = document.createElement('a')
  link.href = URL.createObjectURL(blob)
  link.download = 'resultado.txt'
  link.click()
}
</script>

<style scoped>
textarea {
  resize: none;
}
</style>
