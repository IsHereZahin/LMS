<template>
  <div>
    <!-- Video START -->
    <section class="py-0 pb-lg-5">
      <div class="container">
        <div class="row g-3">
          <!-- Course video START -->
          <div class="col-12">
            <div class="video-player rounded-3 mt-8">
              <video controls crossorigin="anonymous" playsinline poster="../../assets/website/images/videos/poster.jpg">
                <source src="../../assets/website/images/videos/360p.mp4" type="video/mp4" size="360">
                <source src="../../assets/website/images/videos/720p.mp4" type="video/mp4" size="720">
                <source src="../../assets/website/images/videos/1080p.mp4" type="video/mp4" size="1080">
                <!-- Caption files -->
                <track kind="captions" label="English" srclang="en" src="../../assets/website/images/videos/en.vtt.txt" default>
                <track kind="captions" label="French" srclang="fr" src="../../assets/website/images/videos/fr.vtt.txt">
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
    <!-- Video END -->

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
              </div>

              <!-- Course detail START -->
              <div class="col-lg-12">
                <div class="bg-body shadow rounded-2 p-4">
                  <!-- Tabs START -->
                  <ul class="nav nav-pills nav-tabs-line pt-0" id="course-pills-tab" role="tablist">
                    <!-- Tab item -->
                    <li class="nav-item me-2 me-sm-4" role="presentation">
                      <button class="nav-link mb-2 mb-md-0" :class="{ active: activeTab === 'overview' }" id="course-pills-tab-1" @click="setActiveTab('overview')"
                        type="button" role="tab" aria-controls="course-pills-1" aria-selected="true">Overview</button>
                    </li>
                    <!-- Tab item -->
                    <li class="nav-item me-2 me-sm-4" role="presentation">
                      <button class="nav-link mb-2 mb-md-0" :class="{ active: activeTab === 'curriculum' }" id="course-pills-tab-2" @click="setActiveTab('curriculum')"
                        type="button" role="tab" aria-controls="course-pills-2" aria-selected="false">Curriculum</button>
                    </li>
                    <!-- Tab item -->
                    <li class="nav-item me-2 me-sm-4" role="presentation">
                      <button class="nav-link mb-2 mb-md-0" :class="{ active: activeTab === 'instructor' }" id="course-pills-tab-3" @click="setActiveTab('instructor')"
                        type="button" role="tab" aria-controls="course-pills-3" aria-selected="false">Instructor</button>
                    </li>
                    <!-- Tab item -->
                    <li class="nav-item me-2 me-sm-4" role="presentation">
                      <button class="nav-link mb-2 mb-md-0" :class="{ active: activeTab === 'reviews' }" id="course-pills-tab-4" @click="setActiveTab('reviews')"
                        type="button" role="tab" aria-controls="course-pills-4" aria-selected="false">Reviews</button>
                    </li>
                    <!-- Tab item -->
                    <li class="nav-item me-2 me-sm-4" role="presentation">
                      <button class="nav-link mb-2 mb-md-0" :class="{ active: activeTab === 'faqs' }" id="course-pills-tab-5" @click="setActiveTab('faqs')"
                        type="button" role="tab" aria-controls="course-pills-5" aria-selected="false">FAQs</button>
                    </li>
                  </ul>
                  <hr>
                  <!-- Tabs END -->

                  <!-- Tab contents START -->
                  <div class="tab-content pt-2" id="course-pills-tabContent">
                    <!-- Content START -->
                    <div class="tab-pane fade" :class="{ 'show active': activeTab === 'overview' }" id="course-pills-1" role="tabpanel"
                      aria-labelledby="course-pills-tab-1">
                      <!-- Course detail START -->
                      <h5 class="mb-3">Course Description</h5>
                      <p class="mb-3">In this practical hands-on training, you're going to learn to become a digital
                        marketing expert with this
                        <strong> ultimate course bundle that includes 12 digital marketing courses in 1!</strong>
                      </p>

                      <!-- List content -->
                      <h5 class="mt-4">What you'll learn</h5>
                      <ul class="list-group list-group-borderless mb-3">
                        <li class="list-group-item h6 fw-light d-flex mb-0"><i
                            class="fas fa-check-circle text-success me-2"></i>Digital marketing course introduction</li>
                        <li class="list-group-item h6 fw-light d-flex mb-0"><i
                            class="fas fa-check-circle text-success me-2"></i>Customer Life cycle</li>
                        <li class="list-group-item h6 fw-light d-flex mb-0"><i
                            class="fas fa-check-circle text-success me-2"></i>What is Search engine optimization(SEO)
                        </li>
                      </ul>
                      <!-- Course detail END -->
                    </div>
                    <!-- Content END -->

                    <!-- Content START -->
                    <div class="tab-pane fade" :class="{ 'show active': activeTab === 'curriculum' }" id="course-pills-2" role="tabpanel" aria-labelledby="course-pills-tab-2">
                      <!-- Course accordion START -->
                      <div class="accordion accordion-icon accordion-bg-light" id="accordionExample2">
                        <!-- Item -->
                        <div class="accordion-item mb-3" v-for="(section, index) in curriculumSections" :key="index">
                          <h6 class="accordion-header font-base" :id="'heading-' + index">
                            <button class="accordion-button fw-bold rounded d-sm-flex d-inline-block"
                              :class="{ 'collapsed': !section.isOpen }"
                              type="button"
                              @click="toggleSection(index)"
                              aria-expanded="true"
                              :aria-controls="'collapse-' + index">
                              {{ section.title }}
                              <span class="small ms-0 ms-sm-2">
                                ({{ section.lectureCount }} Lectures)
                                <span v-if="section.noteFiles && section.noteFiles.length"> and ({{ section.noteFiles.length }} Notes)</span>
                              </span>
                            </button>
                          </h6>
                          <div :id="'collapse-' + index" class="accordion-collapse collapse" :class="{ 'show': section.isOpen }"
                            :aria-labelledby="'heading-' + index" data-bs-parent="#accordionExample2">
                            <div class="accordion-body mt-3">
                              <!-- Section Header -->
                              <h5 class="fw-bold">{{ section.title }}</h5>

                              <!-- Lectures -->
                              <div v-for="(lecture, lectureIndex) in section.lectures" :key="lectureIndex">
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="position-relative d-flex align-items-center">
                                    <a href="#" class="btn btn-danger-soft btn-round btn-sm mb-0 stretched-link position-static">
                                      <i class="fas fa-play me-0"></i>
                                    </a>
                                    <span class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-100px w-sm-200px w-md-400px">
                                      {{ lecture.title }}
                                    </span>
                                    <span v-if="lecture.isPremium" class="badge bg-orange text-white ms-2 ms-md-0">
                                      <i class="fas fa-lock fa-fw me-1"></i> Premium
                                    </span>
                                    <span v-else class="badge bg-success text-white ms-2 ms-md-0">
                                      <i class="fas fa-unlock fa-fw me-1"></i> Free
                                    </span>
                                  </div>
                                  <p class="mb-0">{{ lecture.duration }}</p>
                                </div>
                                <hr v-if="lectureIndex < section.lectures.length - 1">
                              </div>

                              <!-- Section Notes -->
                              <div v-if="section.noteFiles && section.noteFiles.length">
                                <hr>
                                <div v-for="(note, noteIndex) in section.noteFiles" :key="noteIndex">
                                  <div class="d-flex justify-content-between align-items-center">
                                    <div class="position-relative d-flex align-items-center">
                                      <a :href="'/assets/notes/' + note.file" class="btn btn-dark-soft btn-round btn-sm mb-0 stretched-link position-static" download>
                                        <i class="fas fa-file-pdf me-0"></i>
                                      </a>
                                      <span class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-100px w-sm-200px w-md-400px">
                                        {{ note.title }} ({{ note.size }})
                                      </span>
                                      <span v-if="note.isPremium" class="badge bg-orange text-white ms-2 ms-md-0">
                                        <i class="fas fa-lock fa-fw me-1"></i> Premium
                                      </span>
                                      <span v-else class="badge bg-success text-white ms-2 ms-md-0">
                                        <i class="fas fa-unlock fa-fw me-1"></i> Free
                                      </span>
                                    </div>
                                  </div>
                                  <hr v-if="noteIndex < section.noteFiles.length - 1">
                                </div>
                              </div>

                            </div>

                          </div>
                        </div>
                      </div>
                      <!-- Course accordion END -->
                    </div>
                    <!-- Content END -->

                    <!-- Content START -->
                    <div class="tab-pane fade" :class="{ 'show active': activeTab === 'instructor' }" id="course-pills-3" role="tabpanel" aria-labelledby="course-pills-tab-3">
                      <p>will add</p>
                    </div>
                    <!-- Content END -->

                    <!-- Content START -->
                    <div class="tab-pane fade" :class="{ 'show active': activeTab === 'reviews' }" id="course-pills-4" role="tabpanel" aria-labelledby="course-pills-tab-4">
                      <!-- Review START -->
                      <div class="row mb-4">
                        <h5 class="mb-4">Our Student Reviews</h5>
                          <p>will be add</p>
                      </div>
                      <!-- Review END -->
                    </div>
                    <!-- Content END -->

                    <!-- Content START -->
                    <div class="tab-pane fade" :class="{ 'show active': activeTab === 'faqs' }" id="course-pills-5" role="tabpanel" aria-labelledby="course-pills-tab-5">
                      <!-- Title -->
                      <h5 class="mb-3">Frequently Asked Questions</h5>
                      <!-- Accordion START -->
                      <div class="accordion accordion-flush" id="accordionExample">
                        <!-- Item -->
                        <div class="accordion-item" v-for="(faq, index) in faqs" :key="index">
                          <h2 class="accordion-header" :id="'faqHeading' + index">
                            <button class="accordion-button" :class="{ 'collapsed': !faq.isOpen }" type="button"
                              @click="toggleFaq(index)"
                              aria-expanded="true" :aria-controls="'faqCollapse' + index">
                              <span class="text-secondary fw-bold me-3">{{ String(index + 1).padStart(2, '0') }}</span>
                              <span class="fw-bold">{{ faq.question }}</span>
                            </button>
                          </h2>
                          <div :id="'faqCollapse' + index" class="accordion-collapse collapse" :class="{ 'show': faq.isOpen }"
                            :aria-labelledby="'faqHeading' + index" data-bs-parent="#accordionExample">
                            <div class="accordion-body pt-0">
                              {{ faq.answer }}
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Accordion END -->
                    </div>
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
                    <img src="../../assets/website/images/courses/4by3/01.jpg" class="card-img" alt="course image"> // cources tambaline
                  </div>

                  <!-- Card body -->
                  <div class="card-body px-3">
                    <!-- Info -->
                    <div class="d-flex justify-content-between align-items-center">
                      <!-- Price and time -->
                      <div>
                        <div class="d-flex align-items-center">
                          <h3 class="fw-bold mb-0 me-2">$150</h3>
                          <span class="text-decoration-line-through mb-0 me-2">$350</span>
                          <span class="badge bg-orange text-white mb-0">60% off</span>
                        </div>
                        <p class="mb-0 text-danger"><i class="fas fa-stopwatch me-2"></i>5 days left at this price</p>
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
                      <a href="#" class="btn btn-outline-primary mb-0">Free trial</a>
                      <a href="#" class="btn btn-success mb-0">Buy course</a>
                    </div>
                  </div>
                </div>
                <!-- Video END -->

                <!-- Course info START -->
                <div class="card card-body shadow p-4 mb-4">
                  <!-- Title -->
                  <h4 class="mb-3">This course includes</h4>
                  <ul class="list-group list-group-borderless">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-book-open text-primary"></i>Lectures</span>
                      <span>30</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-clock text-primary"></i>Duration</span>
                      <span>4h 50m</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-signal text-primary"></i>Skills</span>
                      <span>Beginner</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-globe text-primary"></i>Language</span>
                      <span>English</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-user-clock text-primary"></i>Last Update</span>
                      <span>Nov 30 2021</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-medal text-primary"></i>Certificate</span>
                      <span>Yes</span>
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
</template>

<script setup>
import { ref } from 'vue'

// Active tab state
const activeTab = ref('overview')

// Set active tab
const setActiveTab = (tab) => {
  activeTab.value = tab
}

// Curriculum sections data
const curriculumSections = ref([
  {
    title: 'Introduction of Digital Marketing',
    lectureCount: 2,
    isOpen: true,
    lectures: [
      {
        title: 'Introduction',
        duration: '2m 10s',
        isPremium: false
      },
      {
        title: 'What is Digital Marketing What is Digital Marketing',
        duration: '15m 10s',
        isPremium: false
      }
    ],
    noteFiles: [
      {
        title: 'Course Overview',
        file: 'course-overview.pdf',
        size: '1.2MB',
        isPremium: false
      }
    ]
  },
  {
    title: 'Customer Life Cycle',
    lectureCount: 1,
    lectures: [
      {
        title: 'How to Flip Features Into Benefits',
        duration: '35m 30s',
        isPremium: true
      }
    ],
    noteFiles: [
      {
        title: 'Customer Journey Guide',
        file: 'customer-journey-guide.pdf',
        size: '900KB',
        isPremium: true
      }
    ]
  }
]);

// Toggle curriculum section
const toggleSection = (index) => {
  curriculumSections.value[index].isOpen = !curriculumSections.value[index].isOpen
}

// FAQs data
const faqs = ref([
  {
    question: 'How Digital Marketing Work?',
    answer: 'Comfort reached gay She rapturous suffering concealed.',
    isOpen: true
  },
  {
    question: 'What is SEO and how does it work?',
    answer: 'Search Engine Optimization is the practice of increasing the quantity and quality of traffic to your website through organic search engine results.',
    isOpen: false
  },
  {
    question: 'Do I need technical knowledge for digital marketing?',
    answer: 'No, you don\'t need deep technical knowledge to start with digital marketing. This course is designed for beginners and will guide you through all the necessary concepts.',
    isOpen: false
  },
  {
    question: 'How long will it take to see results?',
    answer: 'Results vary depending on the strategies implemented. Some tactics like paid advertising can show immediate results, while SEO might take 3-6 months to show significant improvements.',
    isOpen: false
  }
])

// Toggle FAQ
const toggleFaq = (index) => {
  faqs.value[index].isOpen = !faqs.value[index].isOpen
}
</script>

<style>
/* You can add custom styles here if needed */
.accordion-button:not(.collapsed) {
  background-color: rgba(var(--bs-primary-rgb), 0.1);
  color: var(--bs-primary);
}

.nav-tabs-line .nav-link.active {
  border-bottom: 3px solid var(--bs-primary);
  color: var(--bs-primary);
}

.dropdown-w-sm {
  width: 200px;
}
</style>
