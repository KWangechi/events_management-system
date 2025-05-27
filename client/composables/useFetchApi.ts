const baseUrl = "http://localhost:8000/api";

export function useApiFetch<T>(endpoint: string, options: any = {}) {
  // let token;
  const token = useCookie("sanctum.token.cookie");
  // console.log("mY TOKEN", token.value);

  return useFetch<T>(`${baseUrl}${endpoint}`, {
    ...options,
    headers: {
      ...(options.headers || {}),
      Authorization: `Bearer ${token.value}`,
    },
  });
}
