// resources/js/app.js

// 1) Importa Livewire y Alpine desde la versión ESM que incluye Alpine integrado
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm'

// 2) Sólo bootstrap.js para Axios u otros polyfills
import './bootstrap'

// 3) Exponemos Livewire y Alpine al global para poder usar window.livewire y Alpine.data(...)
window.livewire = Livewire
window.Alpine   = Alpine

// 4) Define tu componente de Alpine
Alpine.data('adminStats', () => ({
  selectedVendor:             null,
  fromDate:                   '',
  toDate:                     '',
  filterVendor:               '',
  filterType:                 '',
  searchNotes:                '',
  stats:                      { issued: 0, returned: 0, pending: 0 },
  transactions:               [],
  showGreetingModal:          !localStorage.getItem('greetingShown'),
  showDeleteVendorModal:      false,
  vendorToDelete:             null,
  showDeleteTransactionModal: false,
  transactionToDelete:        null,

  init() {
    this.load()
    if (!localStorage.getItem('greetingShown')) {
      setTimeout(() => {
        this.showGreetingModal = false
        localStorage.setItem('greetingShown','true')
      }, 5000)
    } else {
      this.showGreetingModal = false
    }
  },

  async load(vendorId = null) {
    if (vendorId !== null) {
      this.filterVendor   = ''
      this.selectedVendor = vendorId
    } else {
      this.selectedVendor = this.filterVendor || null
    }

    const params = new URLSearchParams()
    if (this.selectedVendor) params.append('vendor_id',   this.selectedVendor)
    if (this.fromDate)       params.append('from',        this.fromDate)
    if (this.toDate)         params.append('to',          this.toDate)
    if (this.filterType)     params.append('filter_type', this.filterType)
    if (this.searchNotes)    params.append('search_notes', this.searchNotes)

    const res  = await fetch(`/api/admin/stats?${params}`, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    const json = await res.json()

    this.stats        = json.stats
    this.transactions = json.transactions
  },

  /**
   * Exportar el historial filtrado en Excel o PDF.
   * `format` debe ser 'excel' o 'pdf'.
   */
  exportFile(format) {
    const params = new URLSearchParams()
    if (this.selectedVendor) params.append('vendor_id',   this.selectedVendor)
    if (this.fromDate)       params.append('from',        this.fromDate)
    if (this.toDate)         params.append('to',          this.toDate)
    if (this.filterType)     params.append('filter_type', this.filterType)
    if (this.searchNotes)    params.append('search_notes', this.searchNotes)

    // Redirige a la ruta de exportación, respetando los filtros actuales
    window.location.href = `/box/transactions/export/${format}?${params.toString()}`
  },
}))

// 5) Arranca Livewire (inicia también Alpine internamente)
Livewire.start()

// 6) Rebroadcast de tu evento de navegador a un evento de Livewire
window.addEventListener('open-report-modal', e => {
  Livewire.dispatch('openReportModal', ...e.detail)
})

// 7) (Opcional) Service Worker
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service-worker.js', { scope: '/' })
}
