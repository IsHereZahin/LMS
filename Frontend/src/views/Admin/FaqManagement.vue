<template>
  <div class="faq-management">
    <div class="header-actions">
      <h4 class="page-title">FAQ Management</h4>
      <div class="action-buttons">
        <button @click="goBack" class="btn btn-outline">
          <ArrowLeft class="icon" /> Back to Courses
        </button>
        <button @click="openFaqModal" class="btn btn-primary">
          <Plus class="icon" /> Add New FAQ
        </button>
      </div>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
    </div>

    <div v-else-if="error" class="alert">
      {{ error }}
    </div>

    <div v-else>
      <div class="course-info">
        <h3>{{ course.title }}</h3>
        <p>{{ course.category }} | {{ course.level }}</p>
      </div>

      <div v-if="!faqs.length" class="empty-state">
        <p>No FAQs found for this course. Add your first FAQ to get started!</p>
      </div>

      <div v-else class="faq-list">
        <div v-for="faq in faqs" :key="faq.id" class="faq-item" @mouseenter="faq.hover = true" @mouseleave="faq.hover = false">
          <div class="faq-content">
            <h4>Q: {{ faq.question }}</h4>
            <p>A: {{ faq.answer }}</p>
          </div>
          <div class="faq-actions" :class="{ 'visible': faq.hover }">
            <button @click="editFaq(faq)" class="action-btn edit-btn">
              <Edit class="icon-sm" />
            </button>
            <button @click="deleteFaq(faq.id)" class="action-btn delete-btn">
              <Trash class="icon-sm" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- FAQ Modal -->
    <div v-if="showFaqModal" class="modal-overlay" @click.self="closeFaqModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>{{ editingFaqId ? 'Edit FAQ' : 'Add New FAQ' }}</h3>
          <button @click="closeFaqModal" class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="question">Question*</label>
            <textarea
              id="question"
              v-model="faqForm.question"
              class="form-control"
              rows="3"
              required
              placeholder="Enter your question here"
            ></textarea>
          </div>
          <div class="form-group">
            <label for="answer">Answer*</label>
            <textarea
              id="answer"
              v-model="faqForm.answer"
              class="form-control"
              rows="5"
              required
              placeholder="Enter your answer here"
            ></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeFaqModal" class="btn btn-outline">Cancel</button>
          <button @click="submitFaqForm" class="btn btn-primary">
            {{ editingFaqId ? 'Update FAQ' : 'Add FAQ' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/api'
import { ArrowLeft, Edit, Plus, Trash } from 'lucide-vue-next'

export default {
  name: 'FaqManagement',
  components: {
    ArrowLeft,
    Edit,
    Plus,
    Trash
  },
  data() {
    return {
      courseId: null,
      course: {
        title: '',
        category: '',
        level: ''
      },
      faqs: [],
      loading: true,
      error: null,
      showFaqModal: false,
      editingFaqId: null,
      faqForm: {
        question: '',
        answer: ''
      }
    }
  },
  created() {
    this.courseId = this.$route.params.id
    if (this.courseId) {
      this.fetchCourseAndFaqs()
    } else {
      this.error = 'Course ID is required'
      this.loading = false
    }
  },
  methods: {
    async fetchCourseAndFaqs() {
      try {
        this.loading = true
        const [courseResponse, faqsResponse] = await Promise.all([
          api.get(`/courses/${this.courseId}`),
          api.get(`/courses/${this.courseId}/faqs`)
        ])
        this.course = courseResponse.data.data
        this.faqs = faqsResponse.data.data.map(faq => ({
          ...faq,
          hover: false
        }))
        this.loading = false
      } catch (error) {
        console.error('Error fetching course and FAQs:', error)
        this.error = 'Failed to load course and FAQ data. Please try again.'
        this.loading = false
      }
    },
    goBack() {
      this.$router.push({ name: 'CourseList' })
    },
    openFaqModal() {
      this.showFaqModal = true
      this.editingFaqId = null
      this.faqForm = { question: '', answer: '' }
    },
    closeFaqModal() {
      this.showFaqModal = false
      this.editingFaqId = null
      this.faqForm = { question: '', answer: '' }
    },
    editFaq(faq) {
      this.editingFaqId = faq.id
      this.faqForm = { ...faq }
      this.showFaqModal = true
    },
    async submitFaqForm() {
      if (!this.faqForm.question.trim() || !this.faqForm.answer.trim()) {
        this.error = 'Please fill in both question and answer fields.'
        return
      }

      try {
        let response
        if (this.editingFaqId) {
          response = await api.put(`/faqs/${this.editingFaqId}`, this.faqForm)
          const index = this.faqs.findIndex(faq => faq.id === this.editingFaqId)
          if (index !== -1) {
            this.faqs[index] = { ...response.data.data, hover: false }
          }
        } else {
          response = await api.post('/faqs', {
            ...this.faqForm,
            course_id: this.courseId
          })
          this.faqs.push({ ...response.data.data, hover: false })
        }
        this.closeFaqModal()
      } catch (error) {
        console.error('Error saving FAQ:', error)
        this.error = 'Failed to save FAQ. Please try again.'
      }
    },
    async deleteFaq(faqId) {
      if (!confirm('Are you sure you want to delete this FAQ?')) {
        return
      }

      try {
        await api.delete(`/faqs/${faqId}`)
        this.faqs = this.faqs.filter(faq => faq.id !== faqId)
      } catch (error) {
        console.error('Error deleting FAQ:', error)
        this.error = 'Failed to delete FAQ. Please try again.'
      }
    }
  }
}
</script>

<style scoped>
.faq-management {
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
  font-size: 1.5rem;
  font-weight: 600;
  margin: 0;
}

.action-buttons {
  display: flex;
  gap: 1rem;
}

.course-info {
  background-color: #f8f8f8;
  border-radius: 8px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.course-info h3 {
  margin-top: 0;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.course-info p {
  margin: 0;
  color: #555555;
}

.faq-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.faq-item {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  transition: all 0.2s ease;
  background-color: #ffffff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.faq-item:hover {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.faq-content {
  flex: 1;
}

.faq-content h4 {
  margin-top: 0;
  margin-bottom: 0.75rem;
  color: #000000;
  font-weight: 600;
}

.faq-content p {
  margin: 0;
  white-space: pre-wrap;
  color: #333333;
  line-height: 1.6;
}

.faq-actions {
  display: flex;
  gap: 0.5rem;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.faq-actions.visible {
  opacity: 1;
}

.action-btn {
  background: none;
  border: none;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.edit-btn:hover {
  background-color: #f0f0f0;
}

.delete-btn:hover {
  background-color: #f8d7da;
}

.icon-sm {
  width: 16px;
  height: 16px;
  color: #000000;
}

/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background-color: #ffffff;
  border-radius: 8px;
  width: 100%;
  max-width: 550px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid #e0e0e0;
}

.modal-header h3 {
  margin: 0;
  font-weight: 600;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #000000;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: background-color 0.2s ease;
}

.close-btn:hover {
  background-color: #f0f0f0;
}

.modal-body {
  padding: 1.5rem;
}

.modal-footer {
  padding: 1.25rem 1.5rem;
  border-top: 1px solid #e0e0e0;
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
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

.icon {
  width: 18px;
  height: 18px;
  margin-right: 0.5rem;
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

.empty-state {
  background-color: #f8f8f8;
  border-radius: 8px;
  padding: 2rem;
  text-align: center;
  color: #555555;
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

  .action-buttons {
    width: 100%;
  }

  .btn {
    flex: 1;
  }
}
</style>
