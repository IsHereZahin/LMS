<template>
  <div>
    <div class="header-actions">
      <h2>Course Details</h2>
      <div>
        <router-link to="/" class="btn btn-secondary">Back to Courses</router-link>
      </div>
    </div>

    <div v-if="loading" class="loading"></div>

    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <div v-else class="course-details">
      <div class="course-header">
        <div class="course-thumbnail">
          <img :src="getImageUrl(course.thumbnail)" alt="Course thumbnail">
        </div>
        <div class="course-info">
          <h1>{{ course.title }}</h1>
          <p class="course-category">{{ course.category }} | {{ course.level }}</p>
          <p class="course-language">Language: {{ course.language }}</p>
          <div class="course-price">
            <span v-if="course.discount > 0" class="original-price">${{ course.price }}</span>
            <span class="current-price">${{ getDiscountedPrice(course) }}</span>
            <span v-if="course.discount > 0 && course.discount_ends_at" class="discount-ends">
              Discount ends on {{ formatDate(course.discount_ends_at) }}
            </span>
          </div>
          <p class="course-status" :class="{ 'published': course.publish, 'draft': !course.publish }">
            {{ course.publish ? 'Published' : 'Draft' }}
          </p>
          <div class="course-actions">
            <router-link :to="`/courses/${course.id}/edit`" class="btn btn-primary">Edit Course</router-link>
            <router-link :to="`/courses/${course.id}/content`" class="btn btn-success">Manage Content</router-link>
            <router-link :to="`/courses/${course.id}/faqs`" class="btn btn-success">Manage FAQs</router-link>
          </div>
        </div>
      </div>

      <div class="course-content">
        <div class="course-description">
          <h3>Description</h3>
          <p>{{ course.description || 'No description provided.' }}</p>
        </div>

        <div class="course-learn">
          <h3>What You'll Learn</h3>
          <ul v-if="course.what_you_learn && course.what_you_learn.length">
            <li v-for="(item, index) in course.what_you_learn" :key="index">{{ item }}</li>
          </ul>
          <p v-else>No learning points specified.</p>
        </div>

        <div class="course-sections">
          <h3>Course Content</h3>
          <div v-if="course.sections && course.sections.length">
            <div v-for="section in course.sections" :key="section.id" class="section-card">
              <div class="section-header">
                <h4>{{ section.title }}</h4>
                <div class="section-stats">
                  <span>{{ section.lectures ? section.lectures.length : 0 }} lectures</span>
                  <span>{{ getTotalDuration(section) }} min</span>
                </div>
              </div>
              <div class="section-content">
                <div v-if="section.lectures && section.lectures.length">
                  <div v-for="lecture in section.lectures" :key="lecture.id" class="lecture-item">
                    <div class="lecture-info">
                      <span class="lecture-title">{{ lecture.title }}</span>
                      <span class="lecture-duration">{{ lecture.duration }} min</span>
                    </div>
                    <span v-if="lecture.is_premium" class="premium-badge">Premium</span>
                  </div>
                </div>
                <p v-else>No lectures in this section.</p>

                <div v-if="section.notes && section.notes.length" class="notes-list">
                  <h5>Downloadable Materials</h5>
                  <div v-for="note in section.notes" :key="note.id" class="note-item">
                    <div class="note-info">
                      <span class="note-title">{{ note.title }}</span>
                      <span class="note-size">{{ note.file_size }}</span>
                    </div>
                    <span v-if="note.is_premium" class="premium-badge">Premium</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <p v-else>No sections added to this course yet.</p>
        </div>

        <div class="course-faqs">
          <h3>Frequently Asked Questions</h3>
          <div v-if="course.faqs && course.faqs.length">
            <div v-for="faq in course.faqs" :key="faq.id" class="faq-item">
              <h4>{{ faq.question }}</h4>
              <p>{{ faq.answer }}</p>
            </div>
          </div>
          <p v-else>No FAQs added to this course yet.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'CourseDetails',
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      courseId: this.id,
      course: {},
      loading: true,
      error: null
    }
  },
  created() {
    this.fetchCourse()
  },
  methods: {
    async fetchCourse() {
      try {
        this.loading = true
        const response = await axios.get(`/courses/${this.courseId}`)
        this.course = response.data.data

        // Ensure what_you_learn is an array
        if (typeof this.course.what_you_learn === 'string') {
          this.course.what_you_learn = JSON.parse(this.course.what_you_learn)
        }

        this.loading = false
      } catch (error) {
        this.error = 'Failed to load course details. Please try again.'
        this.loading = false
        console.error(error)
      }
    },
    getImageUrl(path) {
      return `${axios.defaults.baseURL.replace('/api', '')}/storage/${path}`
    },
    getDiscountedPrice(course) {
      if (course.discount > 0) {
        return (course.price - course.discount).toFixed(2)
      }
      return course.price.toFixed(2)
    },
    formatDate(dateString) {
      const date = new Date(dateString)
      return date.toLocaleDateString()
    },
    getTotalDuration(section) {
      if (!section.lectures || !section.lectures.length) {
        return 0
      }

      return section.lectures.reduce((total, lecture) => total + lecture.duration, 0)
    }
  }
}
</script>

<style scoped>
.course-details {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.course-header {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
}

@media (min-width: 768px) {
  .course-header {
    flex-direction: row;
  }
}

.course-thumbnail {
  flex: 0 0 300px;
}

.course-thumbnail img {
  width: 100%;
  border-radius: 8px;
  object-fit: cover;
}

.course-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.course-category {
  color: #6c757d;
  font-size: 1rem;
}

.course-language {
  font-size: 0.9rem;
}

.course-price {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  margin-bottom: 0.5rem;
}

.original-price {
  text-decoration: line-through;
  color: #6c757d;
}

.current-price {
  font-size: 1.5rem;
  font-weight: bold;
  color: #4a6cf7;
}

.discount-ends {
  font-size: 0.8rem;
  color: #dc3545;
}

.course-status {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.8rem;
  font-weight: bold;
}

.published {
  background-color: #d4edda;
  color: #155724;
}

.draft {
  background-color: #f8f9fa;
  color: #6c757d;
}

.course-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-top: 0.5rem;
}

.course-content {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
}

.section-card {
  border: 1px solid #e9ecef;
  border-radius: 8px;
  margin-bottom: 1rem;
  overflow: hidden;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #f8f9fa;
  border-bottom: 1px solid #e9ecef;
}

.section-stats {
  display: flex;
  gap: 1rem;
  color: #6c757d;
  font-size: 0.9rem;
}

.section-content {
  padding: 1rem;
}

.lecture-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 0;
  border-bottom: 1px solid #f8f9fa;
}

.lecture-info {
  display: flex;
  flex-direction: column;
}

.lecture-title {
  font-weight: 500;
}

.lecture-duration {
  font-size: 0.8rem;
  color: #6c757d;
}

.notes-list {
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid #f8f9fa;
}

.note-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 0;
  border-bottom: 1px solid #f8f9fa;
}

.note-info {
  display: flex;
  flex-direction: column;
}

.note-title {
  font-weight: 500;
}

.note-size {
  font-size: 0.8rem;
  color: #6c757d;
}

.premium-badge {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.7rem;
  font-weight: bold;
  background-color: #ffc107;
  color: #212529;
}

.faq-item {
  margin-bottom: 1.5rem;
}

.faq-item h4 {
  margin-bottom: 0.5rem;
  color: #4a6cf7;
}
</style>

