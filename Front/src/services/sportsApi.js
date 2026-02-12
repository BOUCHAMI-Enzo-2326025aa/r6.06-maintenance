import {apiClient} from './apiClient'

export async function listSports() {
    return apiClient.get('/api/v1/sports')
}

export async function createSport({name}) {
    return apiClient.post('/api/v1/sports', {name})
}
