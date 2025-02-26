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
            <router-link v-if="isAuthenticated" to="/dashboard">
              <button class="btn btn-success mb-0"><i class="fas fa-user me-2"></i>Dashboard</button>
            </router-link>
            <router-link v-else to="/login">
              <button class="btn btn-danger-soft mb-0"><i class="fas fa-sign-in-alt me-2"></i>Sign In</button>
            </router-link>
          </div>
        </div>
      </nav>
      <!-- Nav END -->
    </header>
    <!-- Header end -->

    <main>
      <router-view />
    </main>

    <!-- Footer START -->
    <footer class="bg-light pt-5">
      <div class="container">
        <!-- Row START -->
        <div class="row g-4">

          <!-- Widget 1 START -->
          <div class="col-lg-3">
            <!-- logo -->
            <a class="me-0" href="index.html">
              <img class="light-mode-item h-40px" src="../../assets/website/images/logo.svg" alt="logo">
              <img class="dark-mode-item h-40px" src="../../assets/website/images/logo-light.svg" alt="logo">
            </a>
            <p class="my-3">Eduport education theme, built specifically for the education centers which is dedicated to
              teaching and involve learners. </p>
          </div>
          <!-- Widget 1 END -->

          <!-- Widget 2 START -->
          <div class="col-lg-6">
            <div class="row g-4">
              <!-- Link block -->
              <div class="col-6 col-md-4">
                <h5 class="mb-2 mb-md-4">Company</h5>
                <ul class="nav flex-column">
                  <li class="nav-item"><a class="nav-link" href="#">About us</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Contact us</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">News and Blogs</a></li>
                </ul>
              </div>

              <!-- Link block -->
              <div class="col-6 col-md-4">
                <h5 class="mb-2 mb-md-4">Community</h5>
                <ul class="nav flex-column">
                  <li class="nav-item"><a class="nav-link" href="#">Documentation</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Faq</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Forum</a></li>
                </ul>
              </div>

              <!-- Link block -->
              <div class="col-6 col-md-4">
                <h5 class="mb-2 mb-md-4">Teaching</h5>
                <ul class="nav flex-column">
                  <li class="nav-item"><a class="nav-link" href="#">Become a teacher</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">How to guide</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Terms &amp; Conditions</a></li>
                </ul>
              </div>
            </div>
          </div>
          <!-- Widget 2 END -->

          <!-- Widget 3 START -->
          <div class="col-lg-3">
            <h5 class="mb-2 mb-md-4">Contact</h5>
            <!-- Time -->
            <p class="mb-2">
              Toll free:<span class="h6 fw-light ms-2">+1234 568 963</span>
              <span class="d-block small">(9:AM to 8:PM IST)</span>
            </p>

            <p class="mb-0">Email:<span class="h6 fw-light ms-2">example@gmail.com</span></p>
          </div>
          <!-- Widget 3 END -->
        </div><!-- Row END -->

        <!-- Divider -->
        <hr class="mt-4 mb-0">

        <!-- Bottom footer -->
        <div class="py-3">
          <div class="container px-0">
            <div class="d-md-flex justify-content-between align-items-center py-3 text-center text-md-left">
              <!-- copyright text -->
              <div class="text-primary-hover"> Copyrights <a href="#" class="text-body">©2021 Eduport</a>. All rights
                reserved. </div>
              <!-- copyright links-->
              <div class=" mt-3 mt-md-0">
                <ul class="list-inline mb-0">
                  <li class="list-inline-item"><a class="nav-link" href="#">Terms of use</a></li>
                  <li class="list-inline-item"><a class="nav-link pe-0" href="#">Privacy policy</a></li>
                </ul>
              </div>
            </div>
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
    }
  }
};
</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap");
@import url("../../assets/website/font-awesome/css/all.min.css");
@import url("../../assets/website/css/style.css");
</style>
