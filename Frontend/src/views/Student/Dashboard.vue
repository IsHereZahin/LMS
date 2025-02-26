<template>
  <div class="dashboard">
    <h1>Welcome to the Dashboard, {{ user.name }}!</h1>
    <p>Your role: {{ user.role }}</p>

    <!-- Logout Button -->
    <button @click="logout">Logout</button>
  </div>
</template>

<script>
import api from '../../api';

export default {
  data() {
    return {
      user: {
        name: '',
        role: '',
      },
    };
  },
  created() {
    this.fetchUserData();
  },
  methods: {
    // Fetch user data from API using the stored token
    async fetchUserData() {
      try {
        const response = await api.get('/user', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.user = response.data;
      } catch (error) {
        alert('Failed to fetch user data');
        this.logout();
      }
    },

    // Logout the user and clear the token
    logout() {
      localStorage.removeItem('token');
      this.$router.push('/');
    },
  },
};
</script>

<style scoped>
.dashboard {
  text-align: center;
  padding: 20rem;
}

button {
  padding: 10px 20px;
  background-color: #ff4d4f;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #ff7875;
}
</style>
