// Client HTTP minimal (sans dépendance) pour parler à l'API Laravel
// Objectif: centraliser baseURL + gestion JSON + erreurs.

const DEFAULT_BASE_URL = (import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000')
    .replace(/\/$/, '')

async function request(path, {method = 'GET', body} = {}) {
    const url = `${DEFAULT_BASE_URL}${path}`

    const res = await fetch(url, {
        method,
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json'
        },
        body: body ? JSON.stringify(body) : undefined
    })

    const contentType = res.headers.get('content-type') || ''
    const isJson = contentType.includes('application/json')
    const payload = isJson ? await res.json().catch(() => null) : await res.text()

    if (!res.ok) {
        const message =
            (payload && payload.message) ||
            (typeof payload === 'string' ? payload : `HTTP ${res.status}`)
        const err = new Error(message)
        err.status = res.status
        err.payload = payload
        throw err
    }

    return payload
}

export const apiClient = {
    get: (path) => request(path),
    post: (path, body) => request(path, {method: 'POST', body}),
    put: (path, body) => request(path, {method: 'PUT', body}),
    del: (path) => request(path, {method: 'DELETE'})
}
