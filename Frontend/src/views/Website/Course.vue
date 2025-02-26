<template>
  <div>
    <!-- ideo START -->
    <section class="py-0 pb-lg-5">
      <div class="container">
        <div class="row g-3">
          <!-- Course video START -->
          <div class="col-12">
            <div class="video-player rounded-3  mt-8">
              <video controls="" crossorigin="anonymous" playsinline=""
                poster="../../assets/website/images/videos/poster.jpg">
                <source src="../../assets/website/images/videos/360p.mp4" type="video/mp4" size="360">
                <source src="../../assets/website/images/videos/720p.mp4" type="video/mp4" size="720">
                <source src="../../assets/website/images/videos/1080p.mp4" type="video/mp4" size="1080">
                <!-- Caption files -->
                <track kind="captions" label="English" srclang="en" src="../../assets/website/images/videos/en.vtt.txt"
                  default="">
                <track kind="captions" label="French" srclang="fr" src="../../assets/website/images/videos/fr.vtt.txt">
                </track>
                </track>
              </video>
            </div>
          </div>
          <!-- Course video END -->

          <!-- Playlist responsive toggler START -->
          <div class="col-12">
            <button class="btn btn-primary d-lg-none mb-4" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
              <i class="bi bi-camera-video me-1"></i> Playlist
            </button>
          </div>
          <!-- Playlist responsive toggler END -->
        </div>
      </div>
    </section>
    <!-- video END -->

    <!-- Page content START -->
    <section class="pt-0">
      <div class="container">
        <div class="row g-lg-5">

          <!-- Main content START -->
          <div class="col-lg-8">
            <div class="row g-4">
              <div class="col-12">
                <!-- Title -->
                <h1>The Complete Digital Marketing Course - 12 Courses in 1</h1>
                <!-- Content -->
                <ul class="list-inline mb-0">
                  <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i class="fas fa-star text-warning me-2"></i>4.5/5.0
                  </li>
                  <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i
                      class="fas fa-user-graduate text-orange me-2"></i>12k Enrolled</li>
                  <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i class="fas fa-signal text-success me-2"></i>All
                    levels</li>
                </ul>
              </div>

              <!-- Instructor detail START -->
              <div class="col-12">
                <div class="d-sm-flex justify-content-sm-between align-items-center">
                  <!-- Avatar detail -->
                  <div class="d-flex align-items-center">
                    <!-- Avatar image -->
                    <div class="avatar avatar-lg">
                      <img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/05.jpg"
                        alt="avatar">
                    </div>
                    <div class="ms-3">
                      <h6 class="mb-0"><a href="#">By Jacqueline Miller</a></h6>
                      <p class="mb-0 small">Founder Dupont company</p>
                    </div>
                  </div>

                  <!-- Button -->
                  <div class="d-flex mt-2 mt-sm-0">
                    <a href="#" class="btn btn-sm mb-0 btn-success-soft small">
                      Enroll Now
                    </a>
                  </div>
                </div>
              </div>
              <!-- Instructor detail END -->

              <!-- Course detail START -->
              <div class="col-12">
                <!-- Tabs START -->
                <ul class="nav nav-pills nav-pills-bg-soft px-3" id="course-pills-tab" role="tablist">
                  <!-- Tab item -->
                  <li class="nav-item me-2 me-sm-4" role="presentation">
                    <button class="nav-link mb-0 active" id="course-pills-tab-1" data-bs-toggle="pill"
                      data-bs-target="#course-pills-1" type="button" role="tab" aria-controls="course-pills-1"
                      aria-selected="true">Overview</button>
                  </li>
                  <!-- Tab item -->
                  <li class="nav-item me-2 me-sm-4" role="presentation">
                    <button class="nav-link mb-0" id="course-pills-tab-2" data-bs-toggle="pill"
                      data-bs-target="#course-pills-2" type="button" role="tab" aria-controls="course-pills-2"
                      aria-selected="false">Reviews</button>
                  </li>
                  <!-- Tab item -->
                  <li class="nav-item me-2 me-sm-4" role="presentation">
                    <button class="nav-link mb-0" id="course-pills-tab-3" data-bs-toggle="pill"
                      data-bs-target="#course-pills-3" type="button" role="tab" aria-controls="course-pills-3"
                      aria-selected="false">FAQs </button>
                  </li>
                </ul>
                <!-- Tabs END -->

                <!-- Tab contents START -->
                <div class="tab-content pt-4 px-3" id="course-pills-tabContent">
                  <!-- Content START -->
                  <div class="tab-pane fade show active" id="course-pills-1" role="tabpanel"
                    aria-labelledby="course-pills-tab-1">
                    <!-- Course detail START -->
                    <h5 class="mb-3">Course Description</h5>
                    <p class="mb-3">Welcome to the Digital Marketing - <strong>Courses in 1</strong></p>
                    <!-- List content -->
                    <h5 class="mt-4">What you’ll learn</h5>

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <ul class="list-group list-group-borderless">
                          <li class="list-group-item h6 fw-light d-flex mb-0"><i
                              class="fas fa-check-circle text-success me-2"></i>Digital
                            marketing course introduction</li>
                          <li class="list-group-item h6 fw-light d-flex mb-0"><i
                              class="fas fa-check-circle text-success me-2"></i>Customer
                            Life cycle</li>
                          <li class="list-group-item h6 fw-light d-flex mb-0"><i
                              class="fas fa-check-circle text-success me-2"></i>What is
                            Search engine optimization(SEO)</li>
                        </ul>
                      </div>

                      <div class="col-md-6">
                        <ul class="list-group list-group-borderless">
                          <li class="list-group-item h6 fw-light d-flex mb-0"><i
                              class="fas fa-check-circle text-success me-2"></i>Why SEO
                          </li>
                          <li class="list-group-item h6 fw-light d-flex mb-0"><i
                              class="fas fa-check-circle text-success me-2"></i>URL
                            Structure</li>
                          <li class="list-group-item h6 fw-light d-flex mb-0"><i
                              class="fas fa-check-circle text-success me-2"></i>Featured
                            Snippet</li>
                        </ul>
                      </div>
                    </div>

                    <p class="mb-0">As it so contrasted oh estimating instrument.</p>
                    <!-- Course detail END -->

                  </div>
                  <!-- Content END -->

                  <!-- Content START -->
                  <div class="tab-pane fade" id="course-pills-2" role="tabpanel" aria-labelledby="course-pills-tab-2">
                    <!-- Review START -->
                    <div class="row mb-4">
                      <h5 class="mb-4">Our Student Reviews</h5>

                      <!-- Rating info -->
                      <div class="col-md-4 mb-3 mb-md-0">
                        <div class="text-center">
                          <!-- Info -->
                          <h2 class="mb-0">4.5</h2>
                          <!-- Star -->
                          <ul class="list-inline mb-0">
                            <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                          </ul>
                          <p class="mb-0">(Based on todays review)</p>
                        </div>
                      </div>

                      <!-- Progress-bar and star -->
                      <div class="col-md-8">
                        <div class="row align-items-center text-center">
                          <!-- Progress bar and Rating -->
                          <div class="col-6 col-sm-8">
                            <!-- Progress item -->
                            <div class="progress progress-sm bg-warning bg-opacity-15">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                              </div>
                            </div>
                          </div>

                          <div class="col-6 col-sm-4">
                            <!-- Star item -->
                            <ul class="list-inline mb-0">
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                            </ul>
                          </div>

                          <!-- Progress bar and Rating -->
                          <div class="col-6 col-sm-8">
                            <!-- Progress item -->
                            <div class="progress progress-sm bg-warning bg-opacity-15">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                              </div>
                            </div>
                          </div>

                          <div class="col-6 col-sm-4">
                            <!-- Star item -->
                            <ul class="list-inline mb-0">
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                            </ul>
                          </div>

                          <!-- Progress bar and Rating -->
                          <div class="col-6 col-sm-8">
                            <!-- Progress item -->
                            <div class="progress progress-sm bg-warning bg-opacity-15">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 60%"
                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              </div>
                            </div>
                          </div>

                          <div class="col-6 col-sm-4">
                            <!-- Star item -->
                            <ul class="list-inline mb-0">
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                            </ul>
                          </div>

                          <!-- Progress bar and Rating -->
                          <div class="col-6 col-sm-8">
                            <!-- Progress item -->
                            <div class="progress progress-sm bg-warning bg-opacity-15">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                              </div>
                            </div>
                          </div>

                          <div class="col-6 col-sm-4">
                            <!-- Star item -->
                            <ul class="list-inline mb-0">
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                            </ul>
                          </div>

                          <!-- Progress bar and Rating -->
                          <div class="col-6 col-sm-8">
                            <!-- Progress item -->
                            <div class="progress progress-sm bg-warning bg-opacity-15">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 20%"
                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              </div>
                            </div>
                          </div>

                          <div class="col-6 col-sm-4">
                            <!-- Star item -->
                            <ul class="list-inline mb-0">
                              <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Review END -->

                    <!-- Student review START -->
                    <div class="row">
                      <!-- Review item START -->
                      <div class="d-md-flex my-4">
                        <!-- Avatar -->
                        <div class="avatar avatar-xl me-4 flex-shrink-0">
                          <img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/09.jpg"
                            alt="avatar">
                        </div>
                        <!-- Text -->
                        <div>
                          <div class="d-sm-flex mt-1 mt-md-0 align-items-center">
                            <h5 class="me-3 mb-0">Jacqueline Miller</h5>
                            <!-- Review star -->
                            <ul class="list-inline mb-0">
                              <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0"><i class="far fa-star text-warning"></i></li>
                            </ul>
                          </div>
                          <!-- Info -->
                          <p class="small mb-2">2 days ago</p>
                          <p class="mb-2">Perceived end knowledge certainly day sweetness why
                            cordially. Ask a quick six seven offer see among. Handsome met
                            debating sir dwelling age material. As style lived he worse
                            dried. Offered related so visitors we private removed. Moderate
                            do subjects to distance. </p>
                        </div>
                      </div>
                      <!-- Divider -->
                      <hr>
                      <!-- Review item END -->

                      <!-- Review item START -->
                      <div class="d-md-flex my-4">
                        <!-- Avatar -->
                        <div class="avatar avatar-xl me-4 flex-shrink-0">
                          <img class="avatar-img rounded-circle" src="../../assets/website/images/avatar/07.jpg"
                            alt="avatar">
                        </div>
                        <!-- Text -->
                        <div>
                          <div class="d-sm-flex mt-1 mt-md-0 align-items-center">
                            <h5 class="me-3 mb-0">Dennis Barrett</h5>
                            <!-- Review star -->
                            <ul class="list-inline mb-0">
                              <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0"><i class="fas fa-star text-warning"></i></li>
                              <li class="list-inline-item me-0"><i class="far fa-star text-warning"></i></li>
                            </ul>
                          </div>
                          <!-- Info -->
                          <p class="small mb-2">2 days ago</p>
                          <p class="mb-2">Handsome met debating sir dwelling age material. As
                            style lived he worse dried. Offered related so visitors we
                            private removed. Moderate do subjects to distance. </p>
                        </div>
                      </div>
                      <!-- Review item END -->
                      <!-- Divider -->
                      <hr>
                    </div>
                    <!-- Student review END -->

                    <!-- Leave Review START -->
                    <div class="mt-2">
                      <h5 class="mb-4">Leave a Review</h5>
                      <form class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputtext" placeholder="Name"
                            aria-label="First name">
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                          <input type="email" class="form-control" placeholder="Email" id="inputEmail4">
                        </div>
                        <!-- Rating -->
                        <div class="col-12">
                          <select id="inputState2" class="form-select  js-choice">
                            <!-- <option selected="">★★★★★ (5/5)</option> -->
                            <option>★★★★★ (5/5)</option>
                            <option>★★★★☆ (4/5)</option>
                            <option>★★★☆☆ (3/5)</option>
                            <option>★★☆☆☆ (2/5)</option>
                            <option>★☆☆☆☆ (1/5)</option>
                          </select>
                        </div>
                        <!-- Message -->
                        <div class="col-12">
                          <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Your review"
                            rows="3"></textarea>
                        </div>
                        <!-- Button -->
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary mb-0">Post
                            Review</button>
                        </div>
                      </form>
                    </div>
                    <!-- Leave Review END -->

                  </div>
                  <!-- Content END -->

                  <!-- Content START -->
                  <div class="tab-pane fade" id="course-pills-3" role="tabpanel" aria-labelledby="course-pills-tab-3">
                    <!-- Title -->
                    <h5 class="mb-3">Frequently Asked Questions</h5>
                    <!-- Accordion START -->
                    <div class="accordion accordion-flush" id="accordionExample">
                      <!-- Item -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span class="text-secondary fw-bold me-3">01</span>
                            <span class="fw-bold">How Digital Marketing Work?</span>
                          </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                          data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0">
                            Comfort reached gay perhaps suffering concealed.
                          </div>
                        </div>
                      </div>
                      <!-- Item -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <span class="text-secondary fw-bold me-3">02</span>
                            <span class="fw-bold">What is SEO?</span>
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                          data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0">
                            Pleasure out of particularly ill are purer.
                            <p class="mt-2">Person she control of parents up just
                              regulatory.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Accordion END -->
                  </div>
                  <!-- Content END -->
                </div>
                <!-- Tab contents END -->
              </div>
              <!-- Course detail END -->
            </div>
          </div>
          <!-- Main content END -->

          <!-- Right sidebar START -->
          <div class="col-lg-4">
            <div class="row g-4">
              <!-- Responsive offcanvas body START -->
              <nav class="navbar navbar-light navbar-expand-lg mx-0">
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSidebar"
                  aria-labelledby="offcanvasSidebarLabel">
                  <div class="offcanvas-header bg-dark">
                    <h5 class="offcanvas-title text-white" id="offcanvasSidebarLabel">Course
                      playlist</h5>
                    <button type="button" class="btn btn-sm btn-light mb-0" data-bs-dismiss="offcanvas"
                      aria-label="Close"><i class="bi bi-x-lg"></i></button>
                  </div>
                  <div class="offcanvas-body p-3 p-lg-0">
                    <div class="col-12">
                      <!-- Accordion START -->
                      <div class="accordion accordion-icon accordion-bg-light" id="accordionExample2">
                        <!-- Item -->
                        <div class="accordion-item mb-3">
                          <h6 class="accordion-header font-base" id="heading-1">
                            <a class="accordion-button fw-bold rounded collapsed d-block" href="#collapse-1"
                              data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true"
                              aria-controls="collapse-1">
                              <span class="mb-0">Introduction of Digital Marketing</span>
                              <span class="small d-block mt-1">(3 Lectures)</span>
                            </a>
                          </h6>
                          <div id="collapse-1" class="accordion-collapse collapse show" aria-labelledby="heading-1"
                            data-bs-parent="#accordionExample2">
                            <div class="accordion-body mt-3">
                              <div class="vstack gap-3">

                                <!-- Progress bar -->
                                <div class="overflow-hidden">
                                  <div class="d-flex justify-content-between">
                                    <p class="mb-1 h6">1/3 Completed</p>
                                    <h6 class="mb-1 text-end">30%</h6>
                                  </div>
                                  <div class="progress progress-sm bg-primary bg-opacity-10">
                                    <div class="progress-bar bg-primary aos" role="progressbar" data-aos="slide-right"
                                      data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-in-out"
                                      style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                  </div>
                                </div>

                                <!-- Course lecture -->
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="position-relative d-flex align-items-center">
                                    <a href="#"
                                      class="btn btn-danger-soft btn-round btn-sm mb-0 stretched-link position-static">
                                      <i class="fas fa-play me-0"></i>
                                    </a>
                                    <span
                                      class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-200px">Introduction</span>
                                  </div>
                                  <p class="mb-0 text-truncate">2m 10s</p>
                                </div>

                                <!-- Course lecture -->
                                <div class="p-2 bg-success bg-opacity-10 rounded-3">
                                  <div class="d-flex justify-content-between align-items-center">
                                    <div class="position-relative d-flex align-items-center">
                                      <a href="#"
                                        class="btn btn-success btn-round btn-sm mb-0 stretched-link position-static">
                                        <i class="fas fa-play me-0"></i>
                                      </a>
                                      <span class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-200px">
                                        What is Digital Marketing What is
                                        Digital Marketing</span>
                                    </div>
                                    <p class="mb-0 text-truncate">Playing</p>
                                  </div>
                                </div>

                                <!-- Course lecture -->
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="position-relative d-flex align-items-center">
                                    <a href="#"
                                      class="btn btn-danger-soft btn-round btn-sm mb-0 stretched-link position-static">
                                      <i class="fas fa-play me-0"></i>
                                    </a>
                                    <span class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-200px">Type
                                      of Digital Marketing</span>
                                  </div>
                                  <p class="mb-0 text-truncate">18m 10s</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Item -->
                        <div class="accordion-item mb-3">
                          <h6 class="accordion-header font-base" id="heading-2">
                            <a class="accordion-button fw-bold collapsed rounded d-block" href="#collapse-2"
                              data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false"
                              aria-controls="collapse-2">
                              <span class="mb-0">Customer Life cycle</span>
                              <span class="small d-block mt-1">(3 Lectures)</span>
                            </a>
                          </h6>
                          <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2"
                            data-bs-parent="#accordionExample2">
                            <!-- Accordion body START -->
                            <div class="accordion-body mt-3">
                              <div class="vstack gap-3">
                                <!-- Progress bar -->
                                <div class="overflow-hidden">
                                  <div class="d-flex justify-content-between">
                                    <p class="mb-1 h6">0/3 Completed</p>
                                    <h6 class="mb-1 text-end">0%</h6>
                                  </div>
                                  <div class="progress progress-sm bg-primary bg-opacity-10">
                                    <div class="progress-bar bg-primary aos" role="progressbar" data-aos="slide-right"
                                      data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-in-out"
                                      style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- Course lecture -->
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="position-relative d-flex align-items-center">
                                    <a href="#"
                                      class="btn btn-danger-soft btn-round btn-sm mb-0 stretched-link position-static">
                                      <i class="fas fa-play me-0"></i>
                                    </a>
                                    <span
                                      class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-200px">Introduction</span>
                                  </div>
                                  <p class="mb-0 text-truncate">2m 10s</p>
                                </div>

                                <!-- Course lecture -->
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="position-relative d-flex align-items-center">
                                    <a href="#"
                                      class="btn btn-danger-soft btn-round btn-sm mb-0 stretched-link position-static">
                                      <i class="fas fa-play me-0"></i>
                                    </a>
                                    <span class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-200px">
                                      What is Digital Marketing What is Digital
                                      Marketing</span>
                                  </div>
                                  <p class="mb-0 text-truncate">15m 10s</p>
                                </div>

                                <!-- Course lecture -->
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="position-relative d-flex align-items-center">
                                    <a href="#"
                                      class="btn btn-light btn-round btn-sm mb-0 stretched-link position-static"
                                      data-bs-toggle="modal" data-bs-target="#coursePremium">
                                      <i class="bi bi-lock-fill"></i>
                                    </a>
                                    <span class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-200px">Type
                                      of Digital Marketing</span>
                                  </div>
                                  <p class="mb-0 text-truncate">18m 10s</p>
                                </div>
                              </div>
                            </div>
                            <!-- Accordion body END -->
                          </div>
                        </div>

                      </div>
                      <!-- Accordion END -->
                    </div>
                  </div>
                </div>
              </nav>
              <!-- Responsive offcanvas body END -->

            </div><!-- Row End -->
          </div>
          <!-- Right sidebar END -->

        </div><!-- Row END -->
      </div>
    </section>
    <!-- Page content END -->
  </div>
</template>
