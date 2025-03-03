<template>
  <div>
    <!-- Header start -->
    <header class="navbar-light navbar-sticky navbar-transparent">
      <!-- Nav START -->
      <nav class="navbar navbar-expand-xl">
        <div class="container">
          <router-link class="navbar-brand" to="/">
            <img class="light-mode-item navbar-brand-item" src="../../assets/website/images/logo.svg" alt="logo">
            <img class="dark-mode-item navbar-brand-item" src="../../assets/website/images/logo-light.svg" alt="logo">
          </router-link>

          <!-- Signout button  -->
          <div class="navbar-nav">
            <router-link v-if="isAuthenticated && userRole === 'admin'" to="/admin-dashboard">
              <button class="btn btn-dark mb-0"><i class="fas fa-user-shield me-2"></i>Admin Panel</button>
            </router-link>

            <router-link v-if="isAuthenticated && userRole === 'student'" to="/dashboard">
              <button class="btn btn-dark mb-0"><i class="fas fa-user me-2"></i>Dashboard</button>
            </router-link>

            <router-link v-if="!isAuthenticated" to="/login">
              <button class="btn btn-dark-soft mb-0"><i class="fas fa-sign-in-alt me-2"></i>Sign In</button>
            </router-link>
          </div>
        </div>
      </nav>
      <!-- Nav END -->
    </header>
    <!-- Header end -->

    <main>
      <router-view />
      <!-- Newsletter START -->
      <section class="mb-n9 position-relative z-index-9">
        <div class="container">
          <div class="row">
            <div class="col-11 col-md-10 mx-auto">
              <div class="bg-warning rounded-3 shadow p-3 p-sm-4 position-relative overflow-hidden">
                <!-- SVG decoration -->
                <figure class="position-absolute top-100 start-100 translate-middle mt-n6 ms-n5">
                  <svg width="211px" height="211px">
                    <path class="fill-white opacity-4"
                      d="M210.030,105.011 C210.030,163.014 163.010,210.029 105.012,210.029 C47.013,210.029 -0.005,163.014 -0.005,105.011 C-0.005,47.015 47.013,-0.004 105.012,-0.004 C163.010,-0.004 210.030,47.015 210.030,105.011 Z">
                    </path>
                  </svg>
                </figure>
                <!-- SVG decoration -->
                <figure class="position-absolute top-100 start-0 translate-middle mt-n6 ms-5">
                  <svg width="141px" height="141px">
                    <path class="fill-white opacity-4"
                      d="M140.520,70.258 C140.520,109.064 109.062,140.519 70.258,140.519 C31.454,140.519 -0.004,109.064 -0.004,70.258 C-0.004,31.455 31.454,-0.003 70.258,-0.003 C109.062,-0.003 140.520,31.455 140.520,70.258 Z">
                    </path>
                  </svg>
                </figure>
                <!-- SVG decoration -->
                <figure class="position-absolute top-0 start-50 mt-4 ms-n9">
                  <svg width="41px" height="41px">
                    <path class="fill-white opacity-4"
                      d="M40.531,20.265 C40.531,31.458 31.457,40.531 20.265,40.531 C9.072,40.531 -0.001,31.458 -0.001,20.265 C-0.001,9.073 9.072,-0.001 20.265,-0.001 C31.457,-0.001 40.531,9.073 40.531,20.265 Z">
                    </path>
                  </svg>
                </figure>

                <!-- Icon logos START -->
                <div
                  class="p-2 bg-white shadow rounded-3 rotate-74 position-absolute top-0 start-0 ms-3 mt-5 d-none d-sm-block">
                  <img src="../../assets/website/images/client/science.svg" class="h-40px" alt="Icon">
                </div>
                <div
                  class="p-1 bg-white shadow rounded-3 rotate-74 position-absolute top-0 end-0 mt-5 me-5 d-none d-sm-block">
                  <img src="../../assets/website/images/client/angular.svg" class="h-30px" alt="Icon">
                </div>
                <div
                  class="p-2 bg-white shadow rounded-3 rotate-130 position-absolute bottom-0 start-50 ms-5 mb-2 d-none d-lg-block">
                  <img src="../../assets/website/images/client/figma.svg" class="h-20px" alt="Icon">
                </div>
                <!-- Icon logos END -->

                <div class="row">
                  <div class="col-md-8 mx-auto text-center py-5 position-relative">
                    <!-- Title -->
                    <h2>Subscribe to our Newsletter for Newest Course Updates</h2>
                    <!-- Form -->
                    <form class="row align-items-center justify-content-center mt-3">
                      <div class="col-lg-8">
                        <div class="bg-body shadow rounded-pill p-2">
                          <div class="input-group">
                            <input class="form-control border-0 me-1" type="email" placeholder="Enter your email">
                            <button type="button" class="btn btn-blue mb-0 rounded-pill">Subscribe!</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div> <!-- Row END -->
              </div>
            </div>
          </div> <!-- Row END -->
        </div>
      </section>
      <!-- Newsletter END -->

    </main>

    <!-- Footer START -->
    <footer class="pt-0 bg-blue rounded-4 position-relative mx-2 mx-md-4 mb-3">
      <!-- SVG decoration for curve -->
      <figure class="mb-0">
        <svg class="fill-body rotate-180" width="100%" height="150" viewbox="0 0 500 150" preserveaspectratio="none">
          <path d="M0,150 L0,40 Q250,150 500,40 L580,150 Z"></path>
        </svg>
      </figure>

      <div class="container">
        <div class="row mx-auto">
          <div class="col-lg-6 mx-auto text-center my-5">
            <!-- Logo -->
            <img class="mx-auto h-40px" src="../../assets/website/images/logo-light.svg" alt="logo">
            <p class="mt-3 text-white">Eduport education theme, built specifically for the education centers which is
              dedicated to teaching and involving learners.</p>
            <!-- Links -->
            <ul class="nav justify-content-center text-primary-hover mt-3 mt-md-0">
              <li class="nav-item"><a class="nav-link text-white" href="#">About</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="#">Terms</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="#">Privacy</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="#">Career</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="#">Contact us</a></li>
              <li class="nav-item"><a class="nav-link text-white pe-0" href="#">Cookies</a></li>
            </ul>
            <!-- Bottom footer link -->
            <div class="mt-3 text-white">©2021 <a href="index-3.htm" class="text-reset btn-link text-primary-hover"
                target="_blank">Eduport</a>. All rights reserved. </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer END -->
  </div>
</template>
<script>
export default {
  computed: {
    isAuthenticated() {
      return !!localStorage.getItem("token");
    },
    userRole() {
      return localStorage.getItem("role");
    }
  }
};
</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap");
@import url("../../assets/website/font-awesome/css/all.min.css");
@import url("../../assets/website/css/style.css");
.navbar {
  box-shadow: none !important;
  background-color: #F5F7F9;
}
</style>
