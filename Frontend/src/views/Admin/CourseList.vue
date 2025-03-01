<template>
  <div class="course-list">
    <div class="header-actions">
      <h2 class="page-title">Course Management</h2>
      <router-link :to="{ name: 'CourseCreate' }" class="btn btn-primary">Create New Course</router-link>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
    </div>

    <div v-else-if="error" class="alert">
      {{ error }}
    </div>

    <div v-else-if="courses.length === 0" class="empty-state">
      <p>No courses found. Create your first course!</p>
    </div>

    <div v-else class="course-grid">
      <div v-for="course in courses" :key="course.id" class="course-card"
           @mouseenter="course.hover = true" @mouseleave="course.hover = false">
        <div class="card-img">
          <img :src="getImageUrl(course.thumbnail)" alt="Course thumbnail" class="course-thumbnail">
          <div class="course-status" :class="{ 'published': course.publish, 'draft': !course.publish }">
            {{ course.publish ? 'Published' : 'Draft' }}
          </div>
        </div>
        <div class="card-body">
          <h3 class="course-title">{{ course.title }}</h3>
          <p class="course-category">{{ course.category }} | {{ course.level }}</p>
          <div class="course-price">
            <span v-if="course.discount > 0" class="original-price">${{ course.price.toFixed(2) }}</span>
            <span class="current-price">${{ getDiscountedPrice(course) }}</span>
          </div>
        </div>
        <div class="card-footer">
          <div class="btn-group">
            <router-link :to="{ name: 'CourseView', params: { id: course.id } }" class="btn btn-sm btn-outline">View</router-link>
            <router-link :to="{ name: 'CourseEdit', params: { id: course.id }}" class="btn btn-sm btn-primary">Edit</router-link>
            <button @click="deleteCourse(course.id)" class="btn btn-sm btn-outline btn-delete">Delete</button>
          </div>
          <div class="btn-group mt-2">
            <router-link :to="{ name: 'LectureManagement', params: { id: course.id }}" class="btn btn-sm btn-outline">
              Manage Content
            </router-link>
            <router-link :to="{ name: 'FaqManagement', params: { id: course.id }}" class="btn btn-sm btn-outline">
              Manage FAQs
            </router-link>
          </div>
        </div>
        <div class="card-overlay" :class="{ 'visible': course.hover }"></div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/api'

export default {
  name: 'CourseList',
  data() {
    return {
      courses: [],
      loading: true,
      error: null
    }
  },
  created() {
    this.fetchCourses()
  },
  methods: {
    async fetchCourses() {
      try {
        this.loading = true
        const response = await api.get('/courses')
        this.courses = response.data.data

        // Ensure boolean values are properly set and add hover state
        this.courses = this.courses.map(course => {
          return {
            ...course,
            publish: Boolean(course.publish),
            certificate: Boolean(course.certificate),
            hover: false
          }
        })

        this.loading = false
      } catch (error) {
        console.error('Error fetching courses:', error)
        this.error = 'Failed to load courses. Please try again.'
        this.loading = false
      }
    },
    async deleteCourse(id) {
      if (!confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
        return
      }

      try {
        await api.delete(`/courses/${id}`)
        this.courses = this.courses.filter(course => course.id !== id)
      } catch (error) {
        console.error('Error deleting course:', error.response ? error.response.data : error)
        this.error = 'Failed to delete course. Please try again.'
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      return `${api.defaults.baseURL.replace('/api', '')}/storage/${path}`
    },
    getDiscountedPrice(course) {
      // Check if discount exists and discount end date is valid
      const hasValidDiscount = course.discount > 0 &&
        (!course.discount_ends_at || new Date(course.discount_ends_at) > new Date())

      if (hasValidDiscount) {
        return (parseFloat(course.price) - parseFloat(course.discount)).toFixed(2)
      }
      return parseFloat(course.price).toFixed(2)
    }
  }
}
</script>

<style scoped>
.course-list {
  background-color: #ffffff;
  min-height: 100vh;
  color: #000000;
}

.header-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding: 1rem 0;
  border-bottom: 1px solid #e0e0e0;
}

.page-title {
  font-size: 1.75rem;
  font-weight: 600;
  margin: 0;
}

.course-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.course-card {
  position: relative;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.3s, box-shadow 0.3s;
  background-color: #ffffff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.course-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.card-img {
  position: relative;
}

.course-thumbnail {
  width: 100%;
  height: 180px;
  object-fit: cover;
}

.course-status {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 0.25rem 0.75rem;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
}

.published {
  background-color: #ffffff;
  color: #000000;
}

.draft {
  background-color: #ffffff;
  color: #777777;
}

.card-body {
  padding: 1.25rem;
}

.course-title {
  margin-top: 0;
  margin-bottom: 0.5rem;
  font-size: 1.125rem;
  font-weight: 600;
  line-height: 1.4;
  color: #000000;
}

.course-category {
  color: #555555;
  font-size: 0.875rem;
  margin-bottom: 0.75rem;
}

.course-price {
  margin-bottom: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.original-price {
  text-decoration: line-through;
  color: #777777;
  font-size: 0.875rem;
}

.current-price {
  font-weight: 600;
  color: #000000;
  font-size: 1rem;
}

.card-footer {
  padding: 1.25rem;
  border-top: 1px solid #e0e0e0;
}

.btn-group {
  display: flex;
  gap: 0.5rem;
}

.mt-2 {
  margin-top: 0.75rem;
}

.card-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.02);
  opacity: 0;
  transition: opacity 0.3s;
  pointer-events: none;
}

.card-overlay.visible {
  opacity: 1;
}

/* Button styles */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 500;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  user-select: none;
  border: 1px solid transparent;
  padding: 0.625rem 1.25rem;
  font-size: 0.875rem;
  line-height: 1.5;
  border-radius: 4px;
  transition: all 0.2s ease-in-out;
  cursor: pointer;
  text-decoration: none;
}

.btn-sm {
  padding: 0.375rem 0.75rem;
  font-size: 0.8125rem;
}

.btn-primary {
  color: #ffffff;
  background-color: #000000;
  border-color: #000000;
}

.btn-primary:hover {
  background-color: #333333;
  border-color: #333333;
}

.btn-outline {
  color: #000000;
  background-color: transparent;
  border-color: #000000;
}

.btn-outline:hover {
  color: #ffffff;
  background-color: #000000;
}

.btn-delete:hover {
  color: #ffffff;
  background-color: #000000;
  border-color: #000000;
}

/* Loading and empty states */
.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #f3f3f3;
  border-top: 3px solid #000000;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.empty-state {
  background-color: #f8f8f8;
  border-radius: 8px;
  padding: 3rem 2rem;
  text-align: center;
  color: #555555;
}

.alert {
  padding: 1rem;
  margin-bottom: 1.5rem;
  border-radius: 4px;
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
  .header-actions {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .course-grid {
    grid-template-columns: 1fr;
  }
}
</style>
