import {apiClient} from './apiClient'

export async function listChampionnats({sportId} = {}) {
    const qs = sportId ? `?sport_id=${encodeURIComponent(sportId)}` : ''
    return apiClient.get(`/api/v1/championnats${qs}`)
}

export async function createChampionnat({sportId, name}) {
    return apiClient.post('/api/v1/championnats', {
        sport_id: sportId,
        name
    })
}

export async function getOptionsSportsChampionnats() {
    return apiClient.get('/api/v1/options/sports-championnats')
}
