<template>
  <div class="flex justify-center items-center max-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-card w-full max-w-md">
      <h2 class="text-3xl font-bold text-center text-primary mb-6 font-sans">Admin Login</h2>
      <form @submit.prevent="handleLogin" class="space-y-5">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            v-model="email"
            type="email"
            id="email"
            required
            class="block w-full h-12 rounded-lg border border-gray-300 px-4 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"
            placeholder="you@email.com"
          />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input
            v-model="password"
            type="password"
            id="password"
            required
            class="block w-full h-12 rounded-lg border border-gray-300 px-4 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"
            placeholder="Your password"
          />
        </div>
        <button
          type="submit"
          class="w-full bg-primary text-white font-semibold py-2 rounded-lg hover:bg-primary/90 transition"
        >
          Login
        </button>
        <p v-if="error" class="text-red-500 text-sm text-center">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
// import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const error = ref('')
// const router = useRouter()

const handleLogin = async () => {
  console.log('Login button clicked')
  // Uncomment and use your API logic here
  // const { data, error: fetchError } = await useFetch('http://localhost:8000/api/auth/login', {
  //   method: 'POST',
  //   body: { email: email.value, password: password.value },
  // })
  // if (fetchError.value) {
  //   error.value = 'Login failed. Please check your credentials.'
  // } else {
  //   const token = data.value?.token
  //   if (token) {
  //     localStorage.setItem('token', token)
  //     router.push('/org1/events')
  //   }
  // }
}
</script>