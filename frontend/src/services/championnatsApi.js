import {apiClient} from './apiClient'

export async function listChampionnats({sportId} = {}) {
    const qs = sportId ? `?sport_id=${encodeURIComponent(sportId)}` : ''
    return apiClient.get(`/api/v1/championnats${qs}`)
}

export async function getChampionnat(id) {
    return apiClient.get(`/api/v1/championnats/${encodeURIComponent(id)}`)
}

export async function createChampionnat({sportId, name, lieu = null}) {
    return apiClient.post('/api/v1/championnats', {
        sport_id: sportId,
        name,
        lieu
    })
}

export async function createChampionnatFull(payload) {
    // payload côté front: { sport_id, name, lieu, competitions: [{name, epreuves:[{name, sports?}]}] }
    return apiClient.post('/api/v1/championnats/full', payload)
}

export async function getOptionsSportsChampionnats() {
    return apiClient.get('/api/v1/options/sports-championnats')
}
