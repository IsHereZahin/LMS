<template>
  <main>
    <section class="p-0 d-flex align-items-center position-relative overflow-hidden">
      <div class="container-fluid">
        <div class="row">
          <!-- left -->
          <div
            class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-primary bg-opacity-10 vh-lg-100">
            <div class="p-3 p-lg-5">
              <!-- Title -->
              <div class="text-center">
                <h2 class="fw-bold">Welcome to our largest community</h2>
                <p class="mb-0 h6 fw-light">Let's learn something new today!</p>
              </div>
              <!-- SVG Image -->
              <img src="../../assets/website/images/element/02.svg" class="mt-5" alt="">
              <!-- Info -->
              <div class="d-sm-flex mt-5 align-items-center justify-content-center">
                <!-- Avatar group -->
                <ul class="avatar-group mb-2 mb-sm-0">
                  <li class="avatar avatar-sm">
                    <img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/01.jpg"
                      alt="avatar">
                  </li>
                  <li class="avatar avatar-sm">
                    <img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/02.jpg"
                      alt="avatar">
                  </li>
                  <li class="avatar avatar-sm">
                    <img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/03.jpg"
                      alt="avatar">
                  </li>
                  <li class="avatar avatar-sm">
                    <img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/04.jpg"
                      alt="avatar">
                  </li>
                </ul>
                <!-- Content -->
                <p class="mb-0 h6 fw-light ms-0 ms-sm-3">4k+ Students joined us, now it's your turn.</p>
              </div>
            </div>
          </div>

          <!-- Right -->
          <div class="col-12 col-lg-6 m-auto">
            <div class="row my-5">
              <div class="col-sm-10 col-xl-8 m-auto">
                <!-- Title -->
                <span class="mb-0 fs-1">👋</span>
                <h1 class="fs-2">Login into Eduport!</h1>
                <p class="lead mb-4">Nice to see you! Please log in with your account.</p>

                <!-- Form START -->
                <form @submit.prevent="login">
                  <!-- Email -->
                  <div class="mb-4">
                    <label for="exampleInputEmail1" class="form-label">Email address *</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i
                          class="bi bi-envelope-fill"></i></span>
                      <input v-model="email" type="email" placeholder="Email" required
                        class="form-control border-0 bg-light rounded-end ps-1" id="exampleInputEmail1">
                    </div>
                  </div>
                  <!-- Password -->
                  <div class="mb-4">
                    <label for="inputPassword5" class="form-label">Password *</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i
                          class="fas fa-lock"></i></span>
                      <input v-model="password" type="password" placeholder="Password" required
                        class="form-control border-0 bg-light rounded-end ps-1" id="inputPassword5">
                    </div>
                    <div id="passwordHelpBlock" class="form-text">
                      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
                    </div>
                  </div>
                  <!-- Button -->
                  <div class="align-items-center mt-0">
                    <div class="d-grid">
                      <button class="btn btn-primary mb-0" type="submit" :disabled="loading">
                        {{ loading ? 'Logging in...' : 'Login' }}
                      </button>
                    </div>
                  </div>
                </form>
                <!-- Form END -->

                <!-- Sign up link -->
                <div class="mt-4 text-center">
                  <span>Don't have an account?
                    <router-link to="/register">
                      Signup here
                    </router-link>
                  </span>
                </div>
              </div>
            </div>
            <!-- Row END -->
          </div>
        </div>
        <!-- Row END -->
      </div>
    </section>
  </main>
</template>

<script>
import api from '../../api.js';

export default {
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      errorMessage: ''
    };
  },
  created() {
    // Redirect if already logged in
    const token = localStorage.getItem('token');
    const role = localStorage.getItem('role');

    if (token) {
      this.$router.push(role === 'admin' ? '/admin-dashboard' : '/dashboard');
    }
  },
  methods: {
    async login() {
      this.loading = true;
      this.errorMessage = '';

      try {
        // Send login request to the server
        const response = await api.post('/login', {
          email: this.email,
          password: this.password,
        });

        const { token, user } = response.data;

        // Store the token and role in localStorage
        localStorage.setItem('token', token);
        localStorage.setItem('role', user.role);

        this.$router.push(user.role === 'admin' ? '/admin-dashboard' : '/dashboard');
      } catch (error) {
        // If login fails, remove the token and show error
        localStorage.removeItem('token');
        localStorage.removeItem('role');
        this.errorMessage = 'Invalid credentials';
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style>
@import url("../../assets/website/css/style.css");
</style>
