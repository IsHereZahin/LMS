<template>
<main>
	<section class="p-0 d-flex align-items-center position-relative overflow-hidden">

		<div class="container-fluid">
			<div class="row">
				<!-- left -->
				<div class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-primary bg-opacity-10 vh-lg-100">
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
							<ul class="avatar-group mb-2 mb-sm-0">
								<li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/01.jpg" alt="avatar"></li>
								<li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/02.jpg" alt="avatar"></li>
								<li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/03.jpg" alt="avatar"></li>
								<li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/04.jpg" alt="avatar"></li>
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
							<img src="../../assets/website/images/element/03.svg" class="h-40px mb-2" alt="">
							<h2>Sign up for your account!</h2>
							<p class="lead mb-4">Nice to see you! Please Sign up with your account.</p>

							<!-- Form START -->
              <form @submit.prevent="register">
								<!-- name -->
								<div class="mb-4">
									<label for="exampleInputEmail1" class="form-label">Name</label>
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-envelope-fill"></i></span>
										<input v-model="name" placeholder="Name" required type="name" class="form-control border-0 bg-light rounded-end ps-1">
									</div>
								</div>
								<!-- username -->
								<div class="mb-4">
									<label for="exampleInputEmail1" class="form-label">Username</label>
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-envelope-fill"></i></span>
										<input v-model="username" placeholder="Username" required type="name" class="form-control border-0 bg-light rounded-end ps-1">
									</div>
								</div>
								<!-- Email -->
								<div class="mb-4">
									<label for="exampleInputEmail1" class="form-label">Email address *</label>
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-envelope-fill"></i></span>
										<input v-model="email" placeholder="Email" required type="email" class="form-control border-0 bg-light rounded-end ps-1">
									</div>
								</div>
								<!-- Password -->
								<div class="mb-4">
									<label for="inputPassword5" class="form-label">Password *</label>
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="fas fa-lock"></i></span>
										<input type="password" v-model="password" required class="form-control border-0 bg-light rounded-end ps-1" placeholder="*********">
									</div>
								</div>
								<!-- Check box -->
								<div class="mb-4">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="checkbox-1">
										<label class="form-check-label" for="checkbox-1">By signing up, you agree to the<a href="#"> terms of service</a></label>
									</div>
								</div>
								<!-- Button -->
								<div class="align-items-center mt-0">
									<div class="d-grid">
										<button class="btn btn-primary mb-0" type="submit">Sign Up</button>
									</div>
								</div>
							</form>
							<!-- Form END -->

							<!-- Sign up link -->
							<div class="mt-4 text-center">
								<span>Already have an account?
                  <router-link to="/login">
                    Sign in here
                  </router-link>
                </span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
</template>

<script>
import api from '../../api';

export default {
  data() {
    return { name: '', username: '', email: '', password: '' };
  },
  methods: {
    async register() {
      try {
        // Send the registration request
        const response = await api.post('/register', {
          name: this.name,
          username: this.username,
          email: this.email,
          password: this.password,
        });

        const { token, user } = response.data;

        // Store the token and role in localStorage
        localStorage.setItem('token', token);
        localStorage.setItem('role', user.role);
        this.$router.push(user.role === 'admin' ? '/admin-dashboard' : '/dashboard');
      } catch (error) {
        alert('Registration failed');
      }
    },
  },
};
</script>

<style>
@import url("../../assets/website/css/style.css");
</style>
