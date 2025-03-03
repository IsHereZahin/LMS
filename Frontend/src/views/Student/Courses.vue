<template>
  <div class="course-list">
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
      <div v-for="course in courses" :key="course.id" class="course-card">
        <div class="card-img">
          <img :src="getImageUrl(course.thumbnail)" alt="Course thumbnail" class="course-thumbnail">
          <div class="course-status badge">
            {{ course.progress_percentage }}% completed
          </div>
        </div>
        <div class="card-body">
          <router-link :to="{ name: 'CourseView', params: { id: course.id } }" class="course-title">{{ course.title }}</router-link>
          <p class="course-category">{{ course.category }} | {{ course.level }}</p>
          <div class="course-price">
            <span v-if="course.discount > 0" class="original-price">${{ course.price.toFixed(2) }}</span>
            <span class="current-price">${{ getDiscountedPrice(course) }}</span>
          </div>
        </div>
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
        this.loading = true;
        const response = await api.get('/myCourses');
        this.courses = response.data.data || [];
        this.courses = this.courses.map(course => ({
          ...course,
          progress_percentage: course.progress_percentage || 0
        }));
        this.loading = false;
      } catch (error) {
        console.error('Error fetching courses:', error);
        this.error = 'Failed to load courses. Please try again.';
        this.loading = false;
      }
    },
    getImageUrl(path) {
      return path ? `${api.defaults.baseURL.replace('/api', '')}/storage/${path}` : '';
    },
    getDiscountedPrice(course) {
      const hasValidDiscount = course.discount > 0 && (!course.discount_ends_at || new Date(course.discount_ends_at) > new Date());
      return hasValidDiscount ? (parseFloat(course.price) - parseFloat(course.discount)).toFixed(2) : parseFloat(course.price).toFixed(2);
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

.course-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.course-card {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  overflow: hidden;
  background-color: #ffffff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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
  background-color: #ffffff;
  color: #000000;
}

.card-body {
  padding: 1.25rem;
}

.course-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #000000;
}

.course-category {
  color: #555555;
  font-size: 0.875rem;
}

.course-price {
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

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
