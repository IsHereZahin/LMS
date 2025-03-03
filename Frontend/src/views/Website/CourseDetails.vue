<template>
  <div>
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <div v-else>
      <!-- Video START -->
      <section class="py-0 pb-lg-5">
        <div class="container">
          <div class="row g-3">
            <!-- Course video START -->
            <div class="col-12">
              <div class="video-player rounded-3 mt-8">
                <div class="ratio-16x9">
                  <iframe v-if="currentVideo && (canAccessPremiumContent || !isCurrentVideoPremium)"
                    :src="'https://www.youtube.com/embed/' + currentVideo + '?autoplay=1&enablejsapi=1'"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen @load="setupYouTubePlayer"
                    id="youtube-player">
                  </iframe>
                  <div v-else-if="currentVideo && isCurrentVideoPremium && !canAccessPremiumContent"
                    class="placeholder-video position-relative"
                    :style="{ backgroundImage: `url(${getThumbnailUrl(course.thumbnail)})` }">
                    <div class="placeholder-overlay d-flex flex-column align-items-center justify-content-center">
                      <i class="fas fa-lock fs-1 text-white opacity-75 mb-2"></i>
                      <p class="text-white mb-0">This is premium content. Please purchase the course to access.</p>
                    </div>
                  </div>
                  <div v-else class="placeholder-video position-relative"
                    :style="{ backgroundImage: `url(${getThumbnailUrl(course.thumbnail)})` }">
                    <div class="placeholder-overlay d-flex flex-column align-items-center justify-content-center">
                      <i class="fas fa-play-circle fs-1 text-white opacity-75 mb-2"></i>
                      <p class="text-white mb-0">Select a lecture to start playing</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Course video END -->
          </div>
        </div>
      </section>
      <!-- Video END -->

      <!-- Page content START -->
      <section class="pt-0">
        <div class="container">
          <div class="row g-lg-5">

            <!-- Main content START -->
            <div class="col-lg-8">
              <div class="row g-4">
                <div class="col-12">
                  <!-- Course Title -->
                  <h3>{{ course.title }}</h3>
                  <!-- Content -->
                  <ul class="list-inline mb-0">
                    <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i
                        class="fas fa-star text-warning me-2"></i>4.5/5.0</li>
                    <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i
                        class="fas fa-user-graduate text-orange me-2"></i>12k Enrolled</li>
                    <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i class="fas fa-signal text-success me-2"></i>{{
                      course.level }}</li>
                    <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i
                        class="bi bi-patch-exclamation-fill text-danger me-2"></i>Last updated {{
                          formatDate(course.updated_at) }}</li>
                    <li class="list-inline-item h6 mb-0"><i class="fas fa-globe text-info me-2"></i>{{ course.language
                    }}</li>
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
                        <p class="mb-0 small">Instructor of Marketing</p>
                      </div>
                    </div>

                    <!-- Button -->
                    <div class="d-flex mt-2 mt-sm-0">
                      <a class="btn btn-danger-soft btn-sm mb-0" href="#">Follow</a>
                      <!-- Share button with dropdown -->
                      <div class="dropdown ms-2">
                        <a href="#" class="btn btn-sm mb-0 btn-info-soft small" role="button" id="dropdownShare"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          share
                        </a>
                        <!-- dropdown button -->
                        <ul class="dropdown-menu dropdown-w-sm dropdown-menu-end min-w-auto shadow rounded"
                          aria-labelledby="dropdownShare">
                          <li><a class="dropdown-item" href="#"><i class="fab fa-twitter-square me-2"></i>Twitter</a>
                          </li>
                          <li><a class="dropdown-item" href="#"><i class="fab fa-facebook-square me-2"></i>Facebook</a>
                          </li>
                          <li><a class="dropdown-item" href="#"><i class="fab fa-linkedin me-2"></i>LinkedIn</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Copy link</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Instructor detail END -->


                <!-- Course detail START -->
                <div class="col-lg-12">
                  <div class="bg-body shadow rounded-2 p-4">
                    <!-- Tabs START -->
                    <ul class="nav nav-pills nav-tabs-line pt-0" id="course-pills-tab" role="tablist">
                      <!-- Tab item -->
                      <li class="nav-item me-2 me-sm-4" role="presentation">
                        <button class="nav-link mb-2 text-black" :class="{ active: activeTab === 'overview' }"
                          id="course-pills-tab-1" @click="setActiveTab('overview')" type="button" role="tab"
                          aria-controls="course-pills-1" aria-selected="true">Overview</button>
                      </li>
                      <!-- Tab item -->
                      <li class="nav-item me-2 me-sm-4" role="presentation">
                        <button class="nav-link mb-2 text-black" :class="{ active: activeTab === 'curriculum' }"
                          id="course-pills-tab-2" @click="setActiveTab('curriculum')" type="button" role="tab"
                          aria-controls="course-pills-2" aria-selected="false">Curriculum</button>
                      </li>
                      <li class="nav-item me-2 me-sm-4" role="presentation">
                        <button class="nav-link mb-2 text-black" :class="{ active: activeTab === 'instructor' }"
                          id="course-pills-tab-3" @click="setActiveTab('instructor')" type="button" role="tab"
                          aria-controls="course-pills-3" aria-selected="false">Instructor</button>
                      </li>
                      <!-- Tab item -->
                      <li class="nav-item me-2 me-sm-4" role="presentation">
                        <button class="nav-link mb-2 text-black" :class="{ active: activeTab === 'reviews' }"
                          id="course-pills-tab-4" @click="setActiveTab('reviews')" type="button" role="tab"
                          aria-controls="course-pills-4" aria-selected="false">Reviews</button>
                      </li>
                      <!-- Tab item -->
                      <li class="nav-item me-2 me-sm-4" role="presentation">
                        <button class="nav-link mb-2 text-black" :class="{ active: activeTab === 'faqs' }"
                          id="course-pills-tab-5" @click="setActiveTab('faqs')" type="button" role="tab"
                          aria-controls="course-pills-5" aria-selected="false">FAQs</button>
                      </li>
                      <!-- Tab item for purchase status -->
                      <li v-if="isAuthenticated" class="nav-item me-2 me-sm-4" role="presentation">
                        <button class="nav-link mb-2 text-black" :class="{ active: activeTab === 'purchase' }"
                          id="course-pills-tab-6" @click="setActiveTab('purchase')" type="button" role="tab"
                          aria-controls="course-pills-6" aria-selected="false">Purchase</button>
                      </li>
                    </ul>
                    <hr>
                    <!-- Tabs END -->

                    <!-- Tab contents START -->
                    <div class="tab-content pt-2" id="course-pills-tabContent">
                      <!-- Overview Content START -->
                      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'overview' }"
                        id="course-pills-1" role="tabpanel" aria-labelledby="course-pills-tab-1">
                        <!-- Course detail START -->
                        <h5 class="mb-3">Course Description</h5>
                        <p class="mb-3">{{ course.description }}</p>

                        <!-- List content -->
                        <h5 class="mt-4">What you'll learn</h5>
                        <ul class="list-group list-group-borderless mb-3">
                          <li v-for="(item, index) in course.what_you_learn" :key="index"
                            class="list-group-item h6 fw-light d-flex mb-0">
                            <i class="fas fa-check-circle text-success me-2"></i>{{ item }}
                          </li>
                        </ul>
                        <!-- Course detail END -->
                      </div>
                      <!-- Overview Content END -->

                      <!-- Curriculum Content START -->
                      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'curriculum' }"
                        id="course-pills-2" role="tabpanel" aria-labelledby="course-pills-tab-2">
                        <!-- Course accordion START -->
                        <div class="accordion accordion-icon accordion-bg-light" id="accordionExample2">
                          <!-- Item -->
                          <div class="accordion-item mb-3" v-for="(section, index) in sections" :key="section.id">
                            <h6 class="accordion-header font-base" :id="'heading-' + section.id">
                              <button class="accordion-button fw-bold rounded d-sm-flex d-inline-block"
                                :class="{ 'collapsed': !section.isOpen }" type="button" @click="toggleSection(index)"
                                aria-expanded="true" :aria-controls="'collapse-' + section.id">
                                {{ section.title }}
                                <span class="small ms-0 ms-sm-2">
                                  ({{ section.lectures.length }} Lectures)
                                  <span v-if="section.notes && section.notes.length"> and ({{ section.notes.length }}
                                    Notes)</span>
                                </span>
                              </button>
                            </h6>
                            <div :id="'collapse-' + section.id" class="accordion-collapse collapse"
                              :class="{ 'show': section.isOpen }" :aria-labelledby="'heading-' + section.id"
                              data-bs-parent="#accordionExample2">
                              <div class="accordion-body mt-3">
                                <!-- Section Header -->
                                <h5 class="fw-bold">{{ section.title }}</h5>

                                <!-- Lectures -->
                                <div v-for="(lecture, lectureIndex) in section.lectures" :key="lecture.id">
                                  <div class="d-flex justify-content-between align-items-center">
                                    <div class="position-relative d-flex align-items-center">
                                      <!-- Changed play button to be green when completed -->
                                      <a href="#"
                                        @click.prevent="playVideo(lecture.youtube_video_id, lecture.is_premium, lecture.id)"
                                        class="btn btn-sm mb-0 stretched-link position-static"
                                        :class="isLectureCompleted(lecture.id) ? 'btn-success btn-round' : 'btn-danger-soft btn-round'">
                                        <i class="fas fa-play me-0"></i>
                                      </a>
                                      <span
                                        class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-100px w-sm-200px w-md-400px">
                                        {{ lecture.title }}
                                      </span>
                                      <span v-if="lecture.is_premium" class="badge bg-orange text-white ms-2 ms-md-0">
                                        <i class="fas fa-lock fa-fw me-1"></i> Premium
                                      </span>
                                      <span v-else class="badge bg-success text-white ms-2 ms-md-0">
                                        <i class="fas fa-unlock fa-fw me-1"></i> Free
                                      </span>
                                    </div>
                                    <p class="mb-0">{{ formatDuration(lecture.duration) }}</p>
                                  </div>
                                  <hr v-if="lectureIndex < section.lectures.length - 1">
                                </div>

                                <!-- Section Notes -->
                                <div v-if="section.notes && section.notes.length">
                                  <hr>
                                  <div v-for="(note, noteIndex) in section.notes" :key="note.id">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="position-relative d-flex align-items-center">
                                        <a @click.prevent="downloadNote(note)"
                                          class="btn btn-dark-soft btn-round btn-sm mb-0 stretched-link position-static"
                                          href="#">
                                          <i class="fas fa-file-pdf me-0"></i>
                                        </a>
                                        <span
                                          class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-100px w-sm-200px w-md-400px">
                                          {{ note.title }} ({{ note.file_size || 'Unknown size' }})
                                        </span>
                                        <span v-if="note.is_premium" class="badge bg-orange text-white ms-2 ms-md-0">
                                          <i class="fas fa-lock fa-fw me-1"></i> Premium
                                        </span>
                                        <span v-else class="badge bg-success text-white ms-2 ms-md-0">
                                          <i class="fas fa-unlock fa-fw me-1"></i> Free
                                        </span>
                                      </div>
                                    </div>
                                    <hr v-if="noteIndex < section.notes.length - 1">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Course accordion END -->
                      </div>
                      <!-- Curriculum Content END -->

                      <!-- Content START -->
                      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'instructor' }"
                        id="course-pills-3" role="tabpanel" aria-labelledby="course-pills-tab-3">
                        <!-- Card START -->
                        <div class="mb-0 mb-md-4">
                          <div class="row g-0 align-items-center">
                            <div class="col-md-5">
                              <!-- Image -->
                              <img src="../../assets/website/images/avatar/05.jpg" class="img-fluid rounded-3"
                                alt="instructor-image">
                            </div>
                            <div class="col-md-7">
                              <!-- Card body -->
                              <div class="card-body">
                                <!-- Title -->
                                <h3 class="card-title mb-0">Jacqueline Miller</h3>
                                <p class="mb-2">Instructor of Marketing</p>

                                <!-- Info -->
                                <ul class="list-inline">
                                  <li class="list-inline-item">
                                    <div class="d-flex align-items-center me-3 mb-2">
                                      <span class="icon-md bg-orange bg-opacity-10 text-orange rounded-circle"><i
                                          class="fas fa-user-graduate"></i></span>
                                      <span class="h6 fw-light mb-0 ms-2">9.1k</span>
                                    </div>
                                  </li>
                                  <li class="list-inline-item">
                                    <div class="d-flex align-items-center me-3 mb-2">
                                      <span class="icon-md bg-warning bg-opacity-15 text-warning rounded-circle"><i
                                          class="fas fa-star"></i></span>
                                      <span class="h6 fw-light mb-0 ms-2">4.5</span>
                                    </div>
                                  </li>
                                  <li class="list-inline-item">
                                    <div class="d-flex align-items-center me-3 mb-2">
                                      <span class="icon-md bg-danger bg-opacity-10 text-danger rounded-circle"><i
                                          class="fas fa-play"></i></span>
                                      <span class="h6 fw-light mb-0 ms-2">29 Courses</span>
                                    </div>
                                  </li>
                                  <li class="list-inline-item">
                                    <div class="d-flex align-items-center me-3 mb-2">
                                      <span class="icon-md bg-info bg-opacity-10 text-info rounded-circle"><i
                                          class="fas fa-comment-dots"></i></span>
                                      <span class="h6 fw-light mb-0 ms-2">205</span>
                                    </div>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Card END -->

                        <!-- Instructor info -->
                        <h5 class="mb-3">About Instructor</h5>
                        <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipiscing elit aliquam, rutrum metus
                          vestibulum commodo natoque tempus accumsan dui fusce, sed fames parturient platea quam integer
                          pellentesque. Quis varius curabitur litora eros augue tristique nec, mauris erat fames auctor
                          etiam proin, faucibus luctus sodales est dignissim nulla. Tempus sed felis aliquam nam dis
                          justo aptent tortor massa.</p>
                        <!-- Email address -->
                        <div class="col-12">
                          <ul class="list-group list-group-borderless mb-0">
                            <li class="list-group-item pb-0">Mail ID:<a href="#" class="ms-2">hello@email.com</a></li>
                            <li class="list-group-item pb-0">Web:<a href="#" class="ms-2">example.com</a></li>
                          </ul>
                        </div>
                      </div>
                      <!-- Content END -->

                      <!-- Content START -->
                      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'reviews' }" id="course-pills-4"
                        role="tabpanel" aria-labelledby="course-pills-tab-4">
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
                            <div class="row align-items-center">
                              <!-- Progress bar and Rating -->
                              <div class="col-6 col-sm-8">
                                <!-- Progress item -->
                                <div class="progress progress-sm bg-warning bg-opacity-15">
                                  <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
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
                                    aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
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
                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
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
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
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
                                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
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
                              <p class="mb-2">Handsome met debating sir dwelling age material. As style lived he worse
                                dried. Offered related so visitors we private removed. Moderate do subjects to distance.
                              </p>
                              <!-- Reply button -->
                              <a href="#" class="text-body mb-0"><i class="fas fa-reply me-2"></i>Reply</a>
                            </div>
                          </div>

                          <hr>

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
                              <p class="mb-2">Perceived end knowledge certainly day sweetness why cordially. Ask a quick
                                six seven offer see among. Handsome met debating sir dwelling age material. As style
                                lived he worse dried. Offered related so visitors we private removed. Moderate do
                                subjects to distance. </p>

                              <!-- Reply button -->
                              <a href="#" class="text-body mb-0"><i class="fas fa-reply me-2"></i>Reply</a>
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
                            <!-- Rating -->
                            <div class="col-12 bg-light-input">
                              <select id="inputState2" class="form-select js-choice">
                                <option selected="">★★★★★ (5/5)</option>
                                <option>★★★★☆ (4/5)</option>
                                <option>★★★☆☆ (3/5)</option>
                                <option>★★☆☆☆ (2/5)</option>
                                <option>★☆☆☆☆ (1/5)</option>
                              </select>
                            </div>
                            <!-- Message -->
                            <div class="col-12 bg-light-input">
                              <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Your review"
                                rows="3"></textarea>
                            </div>
                            <!-- Button -->
                            <div class="col-12">
                              <button type="submit" class="btn btn-dark mb-0" disabled>Post Review (Feature not
                                implemented)</button>
                            </div>
                          </form>
                        </div>
                        <!-- Leave Review END -->
                      </div>
                      <!-- Content END -->

                      <!-- FAQs Content START -->
                      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'faqs' }" id="course-pills-5"
                        role="tabpanel" aria-labelledby="course-pills-tab-5">
                        <!-- Title -->
                        <h5 class="mb-3">Frequently Asked Questions</h5>
                        <!-- Accordion START -->
                        <div class="accordion accordion-flush" id="accordionExample">
                          <!-- Item -->
                          <div class="accordion-item" v-for="(faq, index) in faqs" :key="faq.id">
                            <h2 class="accordion-header" :id="'faqHeading' + index">
                              <button class="accordion-button" :class="{ 'collapsed': !faq.isOpen }" type="button"
                                @click="toggleFaq(index)" aria-expanded="true" :aria-controls="'faqCollapse' + index">
                                <span class="text-secondary fw-bold me-3">{{ String(index + 1).padStart(2, '0')
                                  }}</span>
                                <span class="fw-bold">{{ faq.question }}</span>
                              </button>
                            </h2>
                            <div :id="'faqCollapse' + index" class="accordion-collapse collapse"
                              :class="{ 'show': faq.isOpen }" :aria-labelledby="'faqHeading' + index"
                              data-bs-parent="#accordionExample">
                              <div class="accordion-body pt-0">
                                {{ faq.answer }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Accordion END -->
                      </div>
                      <!-- FAQs Content END -->

                      <!-- Purchase Status Content START -->
                      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'purchase' }"
                        id="course-pills-6" role="tabpanel" aria-labelledby="course-pills-tab-6">
                        <div v-if="!isAuthenticated" class="alert alert-warning">
                          Please log in to view your purchase status.
                        </div>
                        <div v-else>
                          <h5 class="mb-3">Purchase Status</h5>

                          <!-- If user has already purchased the course -->
                          <div v-if="purchaseStatus.purchased" class="alert" :class="{
                            'alert-success': purchaseStatus.order.payment_status === 'completed',
                            'alert-warning': purchaseStatus.order.payment_status === 'pending',
                            'alert-danger': purchaseStatus.order.payment_status === 'failed'
                          }">
                            <h6 class="alert-heading">Your Purchase Status</h6>
                            <p>Status: <strong>{{ purchaseStatus.order.payment_status }}</strong></p>
                            <p v-if="purchaseStatus.order.payment_status === 'completed'">
                              You have full access to all premium content.
                            </p>
                            <p v-else-if="purchaseStatus.order.payment_status === 'pending'">
                              Your payment is pending approval. Once approved, you will have access to all premium
                              content.
                            </p>
                            <p v-else>
                              Your payment has failed. Please contact support or try purchasing again.
                            </p>

                            <!-- Allow repurchase if payment failed -->
                            <div v-if="purchaseStatus.order.payment_status === 'failed'" class="mt-3">
                              <button @click="showPurchaseForm = true" class="btn btn-dark">
                                Try Purchasing Again
                              </button>
                            </div>
                          </div>

                          <a v-if="course.price === 0 && !purchaseStatus.purchased" @click.prevent="enrollFree" href="#" class="btn btn-dark mb-0 w-100" :disabled="enrollLoading">
                            <span v-if="enrollLoading"><i class="fas fa-spinner fa-spin me-2"></i>Enrolling...</span>
                            <span v-else>Enroll for Free</span>
                          </a>

                          <div v-else>
                            <!-- If user hasn't purchased yet or needs to repurchase -->
                            <div
                              v-if="!purchaseStatus.purchased || (purchaseStatus.purchased && purchaseStatus.order.payment_status === 'failed')">
                              <!-- Purchase form -->
                              <div v-if="!showPurchaseForm && !purchaseStatus.purchased" class="text-center">
                                <button @click="showPurchaseForm = true" class="btn btn-dark">
                                  Purchase Now
                                </button>
                              </div>

                              <div v-if="showPurchaseForm" class="card p-4 mt-3">
                                <h5 class="mb-3">Complete Your Purchase</h5>
                                <form @submit.prevent="submitPurchase">
                                  <div class="mb-3">
                                    <label for="paymentMethod" class="form-label">Payment Method</label>
                                    <select v-model="purchaseForm.payment_method" id="paymentMethod" class="form-select"
                                      required>
                                      <option value="">Select payment method</option>
                                      <option value="bKash">bKash</option>
                                      <option value="Nagad">Nagad</option>
                                      <option value="Rocket">Rocket</option>
                                      <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                  </div>

                                  <div class="mb-3">
                                    <label for="transactionId" class="form-label">Transaction ID</label>
                                    <input type="text" v-model="purchaseForm.transaction_id" class="form-control"
                                      id="transactionId" placeholder="Enter your transaction ID" required>
                                    <small class="form-text text-muted">
                                      Please enter the transaction ID from your payment provider.
                                    </small>
                                  </div>

                                  <div class="alert alert-info">
                                    <p class="mb-0"><strong>Amount to pay:</strong> ${{ getDiscountedPrice }}</p>
                                    <p class="mb-0"><strong>Payment Instructions:</strong></p>
                                    <ul class="mb-0">
                                      <li>Make the payment to our account</li>
                                      <li>Enter the transaction ID you received</li>
                                      <li>Your access will be granted after admin verification</li>
                                    </ul>
                                  </div>

                                  <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success" :disabled="purchaseLoading">
                                      <span v-if="purchaseLoading">
                                        <i class="fas fa-spinner fa-spin me-2"></i>Processing...
                                      </span>
                                      <span v-else>Submit Purchase</span>
                                    </button>
                                    <button type="button" @click="showPurchaseForm = false"
                                      class="btn btn-outline-secondary">
                                      Cancel
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Purchase Status Content END -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Main content END -->

            <!-- Right sidebar START -->
            <div class="col-lg-4 pt-5 pt-lg-0">
              <div class="row mb-5 mb-lg-0">
                <div class="col-md-6 col-lg-12">
                  <!-- Video START -->
                  <div class="card shadow p-2 mb-4 z-index-9">
                    <div class="overflow-hidden rounded-3">
                      <img :src="getThumbnailUrl(course.thumbnail)" class="card-img" alt="course image">
                    </div>

                    <!-- Card body -->
                    <div class="card-body px-3">
                      <!-- Info -->
                      <div class="d-flex justify-content-between align-items-center">
                        <!-- Price and time -->
                        <div v-if="course.price > 0">
                          <div class="d-flex align-items-center">
                            <h3 class="fw-bold mb-0 me-2">${{ getDiscountedPrice }}</h3>
                            <span v-if="hasValidDiscount" class="text-decoration-line-through mb-0 me-2">${{
                              course.price }}</span>
                            <span v-if="hasValidDiscount" class="badge bg-orange text-white mb-0">
                              {{ calculateDiscountPercentage }}% off
                            </span>
                          </div>
                          <p v-if="hasValidDiscount && course.discount_ends_at" class="mb-0 text-danger">
                            <i class="fas fa-stopwatch me-2"></i>{{ daysLeft }} days left at this price
                          </p>
                        </div>
                        <div v-else>
                          <h3 class="fw-bold mb-0 me-2">Free</h3>
                        </div>

                        <!-- Share button with dropdown -->
                        <div class="dropdown">
                          <!-- Share button -->
                          <a href="#" class="btn btn-sm btn-light rounded small">
                            <i class="fas fa-fw fa-share-alt"></i>
                          </a>
                        </div>
                      </div>

                      <!-- Buttons -->
                      <div class="mt-3 d-sm-flex justify-content-sm-between">
                        <a v-if="!purchaseStatus.purchased && course.price > 0"
                          @click.prevent="setActiveTab('purchase')" href="#" class="btn btn-success mb-0">Buy course</a>
                        <a v-else-if="purchaseStatus.purchased && purchaseStatus.order.payment_status === 'completed'"
                          href="#" class="btn btn-dark mb-0 w-100">Access Course</a>
                        <a v-else-if="purchaseStatus.purchased && purchaseStatus.order.payment_status === 'pending'"
                          href="#" class="btn btn-warning mb-0 w-100">Payment Pending</a>
                        <a v-else-if="purchaseStatus.purchased && purchaseStatus.order.payment_status === 'failed'"
                          @click.prevent="setActiveTab('purchase')" href="#" class="btn btn-danger mb-0 w-100">Payment
                          Failed - Try Again</a>
                        <a v-else-if="course.price === 0" @click.prevent="enrollFree" href="#" class="btn btn-dark mb-0 w-100" :disabled="enrollLoading">
                          <span v-if="enrollLoading"><i class="fas fa-spinner fa-spin me-2"></i>Enrolling...</span>
                          <span v-else>Enroll for Free</span>
                        </a>
                      </div>
                    </div>
                  </div>
                  <!-- Video END -->

                  <!-- Course info START -->
                  <div class="card card-body shadow p-4 mb-4">
                    <!-- Title -->
                    <h4 class="mb-3">This course includes</h4>
                    <ul class="list-group list-group-borderless">
                      <!-- Calculate total lectures -->
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="h6 fw-light mb-0"><i
                            class="fas fa-fw fa-book-open text-dark"></i>Lectures</span>
                        <span>{{ totalLectures }}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-clock text-dark"></i>Duration</span>
                        <span>{{ formatTotalDuration }}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-signal text-dark"></i>Level</span>
                        <span>{{ course.level }}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-globe text-dark"></i>Language</span>
                        <span>{{ course.language }}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="h6 fw-light mb-0"><i
                            class="fas fa-fw fa-user-clock text-dark"></i>Created</span>
                        <span>{{ formatDate(course.created_at) }}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-medal text-dark"></i>Certificate</span>
                        <span>{{ course.certificate ? 'Yes' : 'No' }}</span>
                      </li>
                      <!-- Add progress indicator -->
                      <li  v-if="purchaseStatus.purchased" class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-tasks text-dark"></i>Your
                          Progress</span>
                        <div class="d-flex align-items-center">
                          <span class="me-2">{{ progress.progress_percentage }}%</span>
                          <div class="progress" style="width: 100px; height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar"
                              :style="`width: ${progress.progress_percentage}%`"
                              :aria-valuenow="progress.progress_percentage" aria-valuemin="0" aria-valuemax="100">
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <!-- Course info END -->
                </div>
              </div><!-- Row End -->
            </div>
            <!-- Right sidebar END -->
          </div><!-- Row END -->
        </div>
      </section>
      <!-- Page content END -->
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/api'

export default {
  setup() {
    const route = useRoute()
    const courseId = route.params.id

    // ==========================================
    // STATE MANAGEMENT
    // ==========================================
    const course = ref({})
    const sections = ref([])
    const faqs = ref([])
    const loading = ref(true)
    const error = ref(null)
    const activeTab = ref('overview')
    const currentVideo = ref(null)
    const currentLectureId = ref(null)
    const isCurrentVideoPremium = ref(false)
    const isAuthenticated = ref(false)
    const purchaseStatus = ref({ purchased: false, payment_status: null, order: null })
    const showPurchaseForm = ref(false)
    const purchaseLoading = ref(false)
    const purchaseForm = ref({
      payment_method: '',
      transaction_id: ''
    })
    const youtubePlayer = ref(null)
    const videoWatchTimer = ref(null)
    const enrollLoading = ref(false)

    // ==========================================
    // PROGRESS TRACKING
    // ==========================================
    const progress = ref({
      completed_lessons: "[]",
      progress_percentage: "0",
    })
    const progressLoading = ref(false)
    const progressError = ref(null)

    const completedLessons = computed(() => {
      try {
        return JSON.parse(progress.value.completed_lessons || "[]")
      } catch (e) {
        console.error("Error parsing completed lessons:", e)
        return []
      }
    })

    // ==========================================
    // AUTHENTICATION & DATA FETCHING
    // ==========================================
    const checkAuth = () => {
      const token = localStorage.getItem('token')
      isAuthenticated.value = !!token
    }

    const fetchCourse = async () => {
      try {
        loading.value = true
        const response = await api.get(`/course/${courseId}`)

        course.value = response.data.data

        sections.value = response.data.data.sections.map(section => ({
          ...section,
          isOpen: false
        }))

        if (sections.value.length > 0) {
          sections.value[0].isOpen = true
        }

        faqs.value = response.data.data.faqs.map((faq, index) => ({
          ...faq,
          isOpen: index === 0
        }))

        loading.value = false

        if (isAuthenticated.value) {
          checkPurchaseStatus()
        }
      } catch (err) {
        console.error('Error fetching course:', err)
        error.value = 'Failed to load course details. Please try again.'
        loading.value = false
      }
    }

    // ==========================================
    // PURCHASE HANDLING
    // ==========================================
    const checkPurchaseStatus = async () => {
      if (!isAuthenticated.value) return

      try {
        const response = await api.get(`/check-purchase/${courseId}`)
        purchaseStatus.value = response.data
        console.log('Purchase status:', purchaseStatus.value)

        if (canAccessPremiumContent.value) {
          fetchProgress()
        }
      } catch (err) {
        console.error('Error checking purchase status:', err)
      }
    }

    const submitPurchase = async () => {
      if (!isAuthenticated.value) {
        alert('Please log in to purchase this course')
        return
      }

      if (!purchaseForm.value.transaction_id) {
        alert('Transaction ID is required')
        return
      }

      try {
        purchaseLoading.value = true
        const response = await api.post('/orders', {
          course_id: courseId,
          payment_method: purchaseForm.value.payment_method,
          transaction_id: purchaseForm.value.transaction_id
        })

        alert('Your purchase has been submitted and is pending approval')
        showPurchaseForm.value = false

        // Clear transaction_id after a successful purchase
        purchaseForm.value = { payment_method: '', transaction_id: '' }

        await checkPurchaseStatus()
      } catch (err) {
        console.error('Error submitting purchase:', err)
        alert('Error: ' + (err.response?.data?.message || 'Failed to submit purchase'))
      } finally {
        purchaseLoading.value = false
      }
    }

    // ==========================================
    // VIDEO PLAYER & TRACKING
    // ==========================================
    const setupYouTubePlayer = () => {
      if (videoWatchTimer.value) {
        clearTimeout(videoWatchTimer.value)
      }

      if (currentVideo.value && currentLectureId.value && isAuthenticated.value && canAccessPremiumContent.value) {
        videoWatchTimer.value = setTimeout(() => {
          markLectureCompleted(currentLectureId.value)
        }, 30000)
      }
    }

    // ==========================================
    // COURSE STATISTICS & FORMATTING
    // ==========================================
    const totalLectures = computed(() => {
      return sections.value.reduce((total, section) => {
        return total + section.lectures.length
      }, 0)
    })

    const calculateTotalDuration = computed(() => {
      let totalMinutes = 0;
      sections.value.forEach(section => {
        section.lectures.forEach(lecture => {
          totalMinutes += parseInt(lecture.duration) || 0;
        });
      });
      return totalMinutes;
    });

    const formatTotalDuration = computed(() => {
      const totalMinutes = calculateTotalDuration.value;
      const hours = Math.floor(totalMinutes / 60)
      const minutes = totalMinutes % 60

      if (hours > 0) {
        return `${hours}h ${minutes}m`
      }
      return `${minutes}m`
    })

    const formatDuration = (minutes) => {
      const hrs = Math.floor(minutes / 60)
      const mins = minutes % 60

      if (hrs > 0) {
        return `${hrs}h ${mins}m`
      }
      return `${mins}m`
    }

    const formatDate = (dateString) => {
      if (!dateString) return 'Unknown'
      const date = new Date(dateString)
      const options = { year: 'numeric', month: 'short', day: 'numeric' }
      return date.toLocaleDateString('en-US', options)
    }

    // ==========================================
    // UI INTERACTIONS
    // ==========================================
    const toggleSection = (index) => {
      sections.value[index].isOpen = !sections.value[index].isOpen
    }

    const toggleFaq = (index) => {
      faqs.value = faqs.value.map((faq, i) => ({
        ...faq,
        isOpen: i === index ? !faq.isOpen : faq.isOpen
      }))
    }

    const getThumbnailUrl = (path) => {
      if (!path) return ''
      return `${api.defaults.baseURL.replace('/api', '')}/storage/${path}`
    }

    const playVideo = (youtubeVideoId, isPremium, lectureId) => {
      if (!youtubeVideoId) {
        alert('This lecture has no video available.')
        return
      }

      currentVideo.value = youtubeVideoId
      currentLectureId.value = lectureId
      isCurrentVideoPremium.value = isPremium

      if (isPremium && !canAccessPremiumContent.value) {
        setActiveTab('purchase')
      }
    }

    const downloadNote = (note) => {
      if (note.is_premium && !canAccessPremiumContent.value) {
        alert('This is a premium note. Please purchase the course to access it.')
        setActiveTab('purchase')
        return
      }

      window.open(`${api.defaults.baseURL.replace('/api', '')}/storage/${note.file}`, '_blank')
    }

    // ==========================================
    // ACCESS & PRICING CALCULATIONS
    // ==========================================
    const canAccessPremiumContent = computed(() => {
      return purchaseStatus.value.purchased &&
        purchaseStatus.value.order &&
        purchaseStatus.value.order.payment_status === 'completed'
    })

    const hasValidDiscount = computed(() => {
      return course.value.discount > 0 &&
        (!course.value.discount_ends_at || new Date(course.value.discount_ends_at) > new Date())
    })

    const getDiscountedPrice = computed(() => {
      if (hasValidDiscount.value) {
        return (parseFloat(course.value.price) - parseFloat(course.value.discount)).toFixed(2)
      }
      return parseFloat(course.value.price).toFixed(2)
    })

    const calculateDiscountPercentage = computed(() => {
      if (hasValidDiscount.value && parseFloat(course.value.price) > 0) {
        return Math.round((parseFloat(course.value.discount) / parseFloat(course.value.price)) * 100)
      }
      return 0
    })

    const daysLeft = computed(() => {
      if (!course.value.discount_ends_at) return 0

      const endDate = new Date(course.value.discount_ends_at)
      const today = new Date()
      const diffTime = endDate - today
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))

      return diffDays > 0 ? diffDays : 0
    })

    const setActiveTab = (tab) => {
      activeTab.value = tab
    }

    // ==========================================
    // PROGRESS MANAGEMENT
    // ==========================================
    const fetchProgress = async () => {
      if (!courseId || !canAccessPremiumContent.value) return

      try {
        progressLoading.value = true
        const response = await api.get(`/course-progress/show/${courseId}`)

        if (response.data.success) {
          progress.value = response.data.data.progress
        }
      } catch (err) {
        console.error("Error fetching course progress:", err)
        progressError.value = "Failed to load your progress"
      } finally {
        progressLoading.value = false
      }
    }

    const markLectureCompleted = async (lectureId) => {
      if (!courseId || !lectureId || !canAccessPremiumContent.value) return

      try {
        progressLoading.value = true
        const response = await api.post(`/course-progress/update/${courseId}`, {
          lecture_id: lectureId,
          completed: true,
        })

        if (response.data.success) {
          progress.value = response.data.data.progress
        }
      } catch (err) {
        console.error("Error updating course progress:", err)
        progressError.value = "Failed to update your progress"
      } finally {
        progressLoading.value = false
      }
    }

    const isLectureCompleted = (lectureId) => {
      return completedLessons.value.includes(Number(lectureId))
    }

    // =========== enrollFree ==========
    const enrollFree = async () => {
      if (!isAuthenticated.value) {
        alert('Please log in to enroll in this course')
        return
      }

      try {
        enrollLoading.value = true
        const response = await api.post('/enroll-free', {
          course_id: courseId
        })

        alert('Successfully enrolled in this free course!')

        // Update purchase status to reflect enrollment
        purchaseStatus.value = {
          purchased: true,
          order: response.data.order
        }

        // Fetch progress after successful enrollment
        fetchProgress()
      } catch (err) {
        console.error('Error enrolling in free course:', err)
        alert('Error: ' + (err.response?.data?.message || 'Failed to enroll in this course'))
      } finally {
        enrollLoading.value = false
      }
    }

    // ==========================================
    // WATCHERS & LIFECYCLE HOOKS
    // ==========================================
    watch(currentVideo, (newValue, oldValue) => {
      if (videoWatchTimer.value) {
        clearTimeout(videoWatchTimer.value)
      }

      if (newValue && currentLectureId.value && isAuthenticated.value && canAccessPremiumContent.value) {
        videoWatchTimer.value = setTimeout(() => {
          markLectureCompleted(currentLectureId.value)
        }, 30000)
      }
    })

    watch(() => purchaseStatus.value.order?.payment_status, (newStatus, oldStatus) => {
      if (newStatus === 'completed' && canAccessPremiumContent.value) {
        fetchProgress()
      }
    })

    onMounted(() => {
      checkAuth()
      fetchCourse()
    })

    // ==========================================
    // COMPONENT EXPORTS
    // ==========================================
    return {
      course,
      sections,
      faqs,
      loading,
      error,
      activeTab,
      currentVideo,
      currentLectureId,
      isCurrentVideoPremium,
      totalLectures,
      formatTotalDuration,
      calculateTotalDuration,
      formatDuration,
      formatDate,
      toggleSection,
      toggleFaq,
      getThumbnailUrl,
      playVideo,
      downloadNote,
      hasValidDiscount,
      getDiscountedPrice,
      calculateDiscountPercentage,
      daysLeft,
      isAuthenticated,
      purchaseStatus,
      canAccessPremiumContent,
      showPurchaseForm,
      purchaseForm,
      purchaseLoading,
      submitPurchase,
      setActiveTab,
      progress,
      progressLoading,
      progressError,
      completedLessons,
      fetchProgress,
      markLectureCompleted,
      isLectureCompleted,
      setupYouTubePlayer,
      enrollLoading,
      enrollFree,
    }
  }
}
</script>

<style>
/* Video player styles */
.video-player {
  position: relative;
  width: 100%;
  background-color: #000;
  border-radius: 0.5rem;
  overflow: hidden;
}

.video-player video {
  width: 100%;
  height: auto;
  display: block;
}

.placeholder-video {
  width: 100%;
  height: 400px;
  background-color: #212529;
  color: #fff;
}

/* Tab styling */
.nav-tabs-line .nav-link.active {
  background-color: #000;
  border: 1px solid var(--bs-dark);
  color: var(--bs-dark);
}

/* Loading spinner */
.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 300px;
}

.loading-spinner {
  width: 3rem;
  height: 3rem;
  border: 0.25rem solid rgba(0, 0, 0, 0.1);
  border-right-color: #000;
  border-radius: 50%;
  animation: spinner-border 0.75s linear infinite;
}

@keyframes spinner-border {
  to {
    transform: rotate(360deg);
  }
}

/* General spacing fixes */
.mt-8 {
  margin-top: 3rem;
}

.list-group-borderless .list-group-item {
  border: none;
  padding: 0.5rem 0;
}

/* Alert styles */
.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
  padding: 1rem;
  border-radius: 0.25rem;
  margin-bottom: 1rem;
}

/* Video player styles */
.video-player {
  position: relative;
  width: 100%;
  background-color: #000;
  border-radius: 0.5rem;
  overflow: hidden;
}

.ratio-16x9 {
  aspect-ratio: 16 / 9;
}

.placeholder-video {
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.placeholder-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(2px);
}

/* Responsive iframe */
.video-player iframe {
  width: 100%;
  height: 100%;
  border: none;
}
</style>
