<template>
  <div class="course-form">
    <h2 class="page-title">{{ isEditing ? 'Edit Course' : 'Create New Course' }}</h2>

    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
    </div>

    <div v-if="error" class="alert">
      {{ error }}
    </div>

    <form @submit.prevent="submitForm" class="form-card">
      <div class="card-body">
        <div class="form-group">
          <label for="title">Course Title*</label>
          <input type="text" id="title" v-model="course.title" class="form-control" required placeholder="Enter course title">
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" v-model="course.description" class="form-control" rows="4" placeholder="Enter course description"></textarea>
        </div>

        <div class="form-row">
          <div class="form-group col">
            <label for="category">Category*</label>
            <input type="text" id="category" v-model="course.category" class="form-control" required placeholder="e.g. Web Development">
          </div>

          <div class="form-group col">
            <label for="language">Language*</label>
            <input type="text" id="language" v-model="course.language" class="form-control" required placeholder="e.g. English">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col">
            <label for="level">Level*</label>
            <select id="level" v-model="course.level" class="form-control" required>
              <option value="Beginner">Beginner</option>
              <option value="Intermediate">Intermediate</option>
              <option value="Advanced">Advanced</option>
            </select>
          </div>

          <div class="form-group col">
            <label for="duration">Duration (minutes)</label>
            <input type="number" id="duration" v-model="course.duration" class="form-control" placeholder="Total course duration">
          </div>
        </div>

        <div class="form-group">
          <label>What You'll Learn*</label>
          <div v-for="(item, index) in course.what_you_learn" :key="index" class="learn-item">
            <input type="text" v-model="course.what_you_learn[index]" class="form-control" required placeholder="Learning outcome">
            <button type="button" @click="removeLearnItem(index)" class="action-btn">
              <Trash class="icon-sm" />
            </button>
          </div>
          <button type="button" @click="addLearnItem" class="btn btn-outline btn-sm mt-2">Add Item</button>
        </div>

        <div class="form-row">
          <div class="form-group col">
            <label for="price">Price ($)*</label>
            <input type="number" id="price" v-model="course.price" step="0.01" class="form-control" required placeholder="Regular price">
          </div>

          <div class="form-group col">
            <label for="discount">Discount ($)</label>
            <input type="number" id="discount" v-model="course.discount" step="0.01" class="form-control" placeholder="Discount amount">
          </div>

          <div class="form-group col">
            <label for="discount_ends_at">Discount End Date</label>
            <input type="date" id="discount_ends_at" v-model="course.discount_ends_at" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label for="thumbnail">Thumbnail*</label>
          <input type="file" id="thumbnail" @change="handleThumbnailChange" class="form-control" :required="!isEditing">
          <div v-if="thumbnailPreview" class="thumbnail-preview">
            <img :src="thumbnailPreview" alt="Thumbnail preview">
          </div>
        </div>

        <div class="form-options">
          <div class="form-check">
            <input type="checkbox" id="certificate" v-model="course.certificate" class="form-check-input">
            <label for="certificate" class="form-check-label">Offers Certificate</label>
          </div>

          <div class="form-check">
            <input type="checkbox" id="publish" v-model="course.publish" class="form-check-input">
            <label for="publish" class="form-check-label">Publish Course</label>
          </div>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary" :disabled="submitting">
          {{ submitting ? 'Saving...' : (isEditing ? 'Update Course' : 'Create Course') }}
        </button>
        <router-link :to="{ name: 'CourseList' }" class="btn btn-outline ml-2">Cancel</router-link>
      </div>
    </form>
  </div>
</template>

<script>
import api from '@/api'
import { Trash } from 'lucide-vue-next'

export default {
  name: 'CourseForm',
  components: {
    Trash
  },
  props: {
    id: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      course: {
        title: '',
        description: '',
        category: '',
        language: '',
        certificate: false,
        what_you_learn: [''],
        price: 0,
        discount: 0,
        discount_ends_at: '',
        duration: null,
        level: 'Beginner',
        publish: false
      },
      thumbnailFile: null,
      thumbnailPreview: null,
      loading: false,
      submitting: false,
      error: null
    }
  },
  computed: {
    isEditing() {
      return !!this.$route.params.id
    }
  },
  created() {
    if (this.isEditing) {
      this.fetchCourse(this.$route.params.id)
    }
  },
  methods: {
    async fetchCourse(courseId) {
      try {
        this.loading = true
        const response = await api.get(`/courses/${courseId}`)
        const course = response.data.data

        // Format the date properly for the input
        if (course.discount_ends_at) {
          course.discount_ends_at = new Date(course.discount_ends_at).toISOString().split('T')[0]
        }

        // Ensure what_you_learn is an array
        if (typeof course.what_you_learn === 'string') {
          try {
            course.what_you_learn = JSON.parse(course.what_you_learn)
          } catch (e) {
            course.what_you_learn = [course.what_you_learn]
          }
        }

        // Ensure we have at least one learning item
        if (!course.what_you_learn || !course.what_you_learn.length) {
          course.what_you_learn = ['']
        }

        // Ensure boolean fields are actually booleans
        course.certificate = Boolean(course.certificate)
        course.publish = Boolean(course.publish)

        this.course = course
        this.thumbnailPreview = this.getImageUrl(course.thumbnail)
        this.loading = false
      } catch (error) {
        console.error('Error fetching course:', error)
        this.error = 'Failed to load course data. Please try again.'
        this.loading = false
      }
    },
    handleThumbnailChange(event) {
      const file = event.target.files[0]
      if (!file) return

      this.thumbnailFile = file

      // Create preview
      const reader = new FileReader()
      reader.onload = e => {
        this.thumbnailPreview = e.target.result
      }
      reader.readAsDataURL(file)
    },
    addLearnItem() {
      this.course.what_you_learn.push('')
    },
    removeLearnItem(index) {
      if (this.course.what_you_learn.length > 1) {
        this.course.what_you_learn.splice(index, 1)
      }
    },
    async submitForm() {
      // Filter out empty learn items
      this.course.what_you_learn = this.course.what_you_learn.filter(item => item.trim() !== '')

      // Validate required fields
      if (!this.course.title || !this.course.category || !this.course.language ||
          !this.course.level || this.course.what_you_learn.length === 0) {
        this.error = 'Please fill in all required fields.'
        return
      }

      if (!this.isEditing && !this.thumbnailFile) {
        this.error = 'Please upload a thumbnail image.'
        return
      }

      try {
        this.submitting = true
        this.error = null

        // Create FormData for file upload
        const formData = new FormData()

        // Add all course data to FormData, ensuring correct types
        for (const key in this.course) {
          if (key === 'what_you_learn') {
            this.course.what_you_learn.forEach((item, index) => {
              formData.append(`what_you_learn[${index}]`, item)
            })
          } else if (key === 'certificate' || key === 'publish') {
            formData.append(key, this.course[key] ? '1' : '0')
          } else if (this.course[key] !== null && this.course[key] !== undefined) {
            formData.append(key, this.course[key])
          }
        }

        // Only add the new thumbnail if the user selects a new one
        if (this.thumbnailFile) {
          formData.append('thumbnail', this.thumbnailFile)
        }

        let response

        if (this.isEditing) {
          response = await api.post(`/courses/${this.$route.params.id}?_method=PUT`, formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
        } else {
          response = await api.post('/courses', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
        }

        console.log('API Response:', response.data)

        // Redirect to course list
        this.$router.push({ name: 'CourseList' })
      } catch (error) {
        console.error('API Error:', error.response ? error.response.data : error)
        this.error = 'Failed to save course. Please check your inputs and try again.'
        if (error.response && error.response.data && error.response.data.errors) {
          this.error += ' ' + Object.values(error.response.data.errors).join(' ')
        }
      } finally {
        this.submitting = false
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      return `${api.defaults.baseURL.replace('/api', '')}/storage/${path}`
    }
  }
}
</script>

<style scoped>
.course-form {
  background-color: #ffffff;
  min-height: 100vh;
  color: #000000;
  padding-bottom: 2rem;
}

.page-title {
  font-size: 1.75rem;
  font-weight: 600;
  margin: 0 0 2rem 0;
  padding-bottom: 1rem;
  border-bottom: 1px solid #e0e0e0;
}

.form-card {
  background-color: #ffffff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.card-body {
  padding: 1.5rem;
}

.form-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.25rem;
}

.learn-item {
  display: flex;
  gap: 0.75rem;
  margin-bottom: 0.75rem;
  align-items: center;
}

.action-btn {
  background: none;
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.action-btn:hover {
  background-color: #f0f0f0;
}

.icon-sm {
  width: 16px;
  height: 16px;
  color: #000000;
}

.thumbnail-preview {
  margin-top: 1rem;
  max-width: 300px;
  border-radius: 4px;
  overflow: hidden;
  border: 1px solid #e0e0e0;
}

.thumbnail-preview img {
  width: 100%;
  display: block;
}

.form-options {
  margin-top: 1.5rem;
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
}

.form-check {
  display: flex;
  align-items: center;
}

.form-check-input {
  margin-right: 0.75rem;
  width: 18px;
  height: 18px;
}

.form-check-label {
  font-weight: 500;
  color: #000000;
}

.card-footer {
  padding: 1.25rem 1.5rem;
  border-top: 1px solid #e0e0e0;
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.ml-2 {
  margin-left: 0.75rem;
}

/* Form styles */
.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #000000;
}

.form-control {
  display: block;
  width: 100%;
  padding: 0.75rem 1rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #000000;
  background-color: #ffffff;
  background-clip: padding-box;
  border: 1px solid #d0d0d0;
  border-radius: 4px;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
  border-color: #000000;
  outline: 0;
  box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
}

textarea.form-control {
  resize: vertical;
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

.btn:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}

.mt-2 {
  margin-top: 0.75rem;
}

/* Loading and alerts */
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
  .form-row {
    grid-template-columns: 1fr;
  }

  .card-footer {
    flex-direction: column;
    gap: 0.75rem;
  }

  .btn {
    width: 100%;
  }

  .ml-2 {
    margin-left: 0;
  }
}
</style>
