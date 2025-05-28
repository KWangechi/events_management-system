export function useApiFetch<T>(endpoint: string, options: any = {}) {
  const config = useRuntimeConfig();
  const baseUrl = config.public.apiBase;

  const token = useCookie("sanctum.token.cookie");

  return useFetch<T>(`${baseUrl}${endpoint}`, {
    ...options,
    headers: {
      ...(options.headers || {}),
      Authorization: `Bearer ${token.value}`,
    },
  });
}
