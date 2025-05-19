// Example composable: useApiFetch.ts
export function useApiFetch<T>(endpoint: string, options: any = {}) {
  const token = useCookie('access_token').value
  return useFetch<T>(`http://localhost:8000/api${endpoint}`, {
    ...options,
    headers: {
      ...(options.headers || {}),
      Authorization: token ? `Bearer ${token}` : undefined
    }
  })
}
