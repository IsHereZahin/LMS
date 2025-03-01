<template>
  <div class="lecture-management">
    <div class="header-actions">
      <h2 class="page-title">Course Content Management</h2>
      <div class="action-buttons">
        <button @click="goBack" class="btn btn-outline">
          <ArrowLeft class="icon" /> Back to Courses
        </button>
        <button @click="addSection" class="btn btn-primary">
          <Plus class="icon" /> Add New Section
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
        <div class="course-meta">
          <span>{{ course.category }}</span>
          <span>{{ course.level }}</span>
          <span>{{ course.sections ? course.sections.length : 0 }} sections</span>
        </div>
      </div>

      <div v-if="!course.sections || course.sections.length === 0" class="empty-state">
        <p>No sections found. Add your first section to get started!</p>
      </div>

      <div v-else class="sections-container">
        <div v-for="(section, sectionIndex) in course.sections" :key="section.id" class="section-card">
          <div class="section-header">
            <div v-if="editingSectionId === section.id" class="section-edit">
              <input
                type="text"
                v-model="editingSectionTitle"
                class="form-control"
                placeholder="Section Title"
                ref="sectionTitleInput"
              >
              <div class="action-buttons">
                <button @click="updateSection(section.id)" class="btn btn-sm btn-primary">Save</button>
                <button @click="cancelEditSection()" class="btn btn-sm btn-outline">Cancel</button>
              </div>
            </div>
            <div v-else class="section-title">
              <h4>{{ sectionIndex + 1 }}. {{ section.title }}</h4>
              <div class="section-actions">
                <button @click="startEditSection(section)" class="action-btn">
                  <Edit class="icon-sm" />
                </button>
                <button @click="deleteSection(section.id)" class="action-btn">
                  <Trash class="icon-sm" />
                </button>
              </div>
            </div>
          </div>

          <!-- Lectures -->
          <div class="content-list">
            <h5>Lectures</h5>
            <div v-if="!section.lectures || section.lectures.length === 0" class="empty-state-small">
              No lectures in this section
            </div>
            <div v-else class="lecture-list">
              <div v-for="lecture in section.lectures" :key="lecture.id" class="content-item"
                   @mouseenter="lecture.hover = true" @mouseleave="lecture.hover = false">
                <div class="content-info">
                  <div class="content-title">
                    <Video class="icon-sm" />
                    <span>{{ lecture.title }}</span>
                  </div>
                  <div class="content-meta">
                    <span>{{ lecture.duration }} min</span>
                    <span :class="lecture.is_premium ? 'premium' : 'free'">
                      {{ lecture.is_premium ? 'Premium' : 'Free' }}
                    </span>
                  </div>
                </div>
                <div class="content-actions" :class="{ 'visible': lecture.hover }">
                  <button @click="editLecture(section.id, lecture)" class="action-btn">
                    <Edit class="icon-sm" />
                  </button>
                  <button @click="deleteLecture(lecture.id)" class="action-btn">
                    <Trash class="icon-sm" />
                  </button>
                </div>
              </div>
            </div>
            <button @click="addLecture(section.id)" class="btn btn-outline btn-sm mt-2">
              <Plus class="icon-sm" /> Add Lecture
            </button>
          </div>

          <!-- Notes -->
          <div class="content-list">
            <h5>Notes & Attachments</h5>
            <div v-if="!section.notes || section.notes.length === 0" class="empty-state-small">
              No notes or attachments in this section
            </div>
            <div v-else class="note-list">
              <div v-for="note in section.notes" :key="note.id" class="content-item"
                   @mouseenter="note.hover = true" @mouseleave="note.hover = false">
                <div class="content-info">
                  <div class="content-title">
                    <FileText class="icon-sm" />
                    <span>{{ note.title }}</span>
                  </div>
                  <div class="content-meta">
                    <span>{{ note.file_size || 'Unknown size' }}</span>
                    <span :class="note.is_premium ? 'premium' : 'free'">
                      {{ note.is_premium ? 'Premium' : 'Free' }}
                    </span>
                  </div>
                </div>
                <div class="content-actions" :class="{ 'visible': note.hover }">
                  <button @click="editNote(section.id, note)" class="action-btn">
                    <Edit class="icon-sm" />
                  </button>
                  <button @click="deleteNote(note.id)" class="action-btn">
                    <Trash class="icon-sm" />
                  </button>
                </div>
              </div>
            </div>
            <button @click="addNote(section.id)" class="btn btn-outline btn-sm mt-2">
              <Plus class="icon-sm" /> Add Note/Attachment
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Section Modal -->
    <div v-if="showSectionModal" class="modal-overlay" @click.self="closeSectionModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>{{ editingSectionId ? 'Edit Section' : 'Add New Section' }}</h3>
          <button @click="closeSectionModal" class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="sectionTitle">Section Title*</label>
            <input
              type="text"
              id="sectionTitle"
              v-model="sectionForm.title"
              class="form-control"
              required
              placeholder="Enter section title"
            >
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeSectionModal" class="btn btn-outline">Cancel</button>
          <button @click="submitSectionForm" class="btn btn-primary">
            {{ editingSectionId ? 'Update Section' : 'Add Section' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Lecture Modal -->
    <div v-if="showLectureModal" class="modal-overlay" @click.self="closeLectureModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>{{ editingLectureId ? 'Edit Lecture' : 'Add New Lecture' }}</h3>
          <button @click="closeLectureModal" class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="lectureTitle">Lecture Title*</label>
            <input
              type="text"
              id="lectureTitle"
              v-model="lectureForm.title"
              class="form-control"
              required
              placeholder="Enter lecture title"
            >
          </div>
          <div class="form-group">
            <label for="lectureDuration">Duration (minutes)*</label>
            <input
              type="number"
              id="lectureDuration"
              v-model="lectureForm.duration"
              class="form-control"
              min="1"
              required
            >
          </div>
          <div class="form-group">
            <label for="lectureVideo">Video URL</label>
            <input
              type="text"
              id="lectureVideo"
              v-model="lectureForm.youtube_video_id"
              class="form-control"
              placeholder="YouTube or Vimeo URL"
            >
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              id="lecturePremium"
              v-model="lectureForm.is_premium"
              class="form-check-input"
            >
            <label for="lecturePremium" class="form-check-label">Premium Content</label>
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeLectureModal" class="btn btn-outline">Cancel</button>
          <button @click="submitLectureForm" class="btn btn-primary">
            {{ editingLectureId ? 'Update Lecture' : 'Add Lecture' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Note Modal -->
    <div v-if="showNoteModal" class="modal-overlay" @click.self="closeNoteModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>{{ editingNoteId ? 'Edit Note/Attachment' : 'Add New Note/Attachment' }}</h3>
          <button @click="closeNoteModal" class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="noteTitle">Title*</label>
            <input
              type="text"
              id="noteTitle"
              v-model="noteForm.title"
              class="form-control"
              required
              placeholder="Enter title"
            >
          </div>
          <div class="form-group">
            <label for="noteFile">File*</label>
            <input
              type="file"
              id="noteFile"
              @change="handleFileChange"
              class="form-control"
              :required="!editingNoteId"
            >
            <small v-if="editingNoteId" class="form-text">
              Leave empty to keep the current file
            </small>
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              id="notePremium"
              v-model="noteForm.is_premium"
              class="form-check-input"
            >
            <label for="notePremium" class="form-check-label">Premium Content</label>
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeNoteModal" class="btn btn-outline">Cancel</button>
          <button @click="submitNoteForm" class="btn btn-primary">
            {{ editingNoteId ? 'Update Note' : 'Add Note' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/api'
import { ArrowLeft, Edit, FileText, Plus, Trash, Video } from 'lucide-vue-next'

export default {
  name: 'LectureManagement',
  components: {
    ArrowLeft,
    Edit,
    FileText,
    Plus,
    Trash,
    Video
  },
  data() {
    return {
      courseId: null,
      course: {
        title: '',
        sections: []
      },
      loading: true,
      error: null,

      // Section editing
      editingSectionId: null,
      editingSectionTitle: '',

      // Section modal
      showSectionModal: false,
      sectionForm: {
        title: ''
      },

      // Lecture modal
      showLectureModal: false,
      currentSectionId: null,
      editingLectureId: null,
      lectureForm: {
        title: '',
        duration: 0,
        youtube_video_id: '',
        is_premium: false
      },

      // Note modal
      showNoteModal: false,
      editingNoteId: null,
      noteForm: {
        title: '',
        is_premium: true,
        file: null
      }
    }
  },
  created() {
    this.courseId = this.$route.params.id
    if (this.courseId) {
      this.fetchCourse()
    } else {
      this.error = 'Course ID is required'
      this.loading = false
    }
  },
  methods: {
    async fetchCourse() {
      try {
        this.loading = true
        const response = await api.get(`/courses/${this.courseId}`)
        this.course = response.data.data

        // Ensure sections array exists
        if (!this.course.sections) {
          this.course.sections = []
        }

        // Ensure each section has lectures and notes arrays and add hover state
        this.course.sections.forEach(section => {
          if (!section.lectures) section.lectures = []
          if (!section.notes) section.notes = []

          // Add hover state to lectures and notes
          section.lectures = section.lectures.map(lecture => ({
            ...lecture,
            hover: false
          }))

          section.notes = section.notes.map(note => ({
            ...note,
            hover: false
          }))
        })

        this.loading = false
      } catch (error) {
        console.error('Error fetching course:', error)
        this.error = 'Failed to load course data. Please try again.'
        this.loading = false
      }
    },

    goBack() {
      this.$router.push({ name: 'CourseList' })
    },

    // Section methods
    addSection() {
      this.sectionForm = { title: '' }
      this.showSectionModal = true
    },

    startEditSection(section) {
      this.editingSectionId = section.id
      this.editingSectionTitle = section.title
      this.$nextTick(() => {
        if (this.$refs.sectionTitleInput) {
          this.$refs.sectionTitleInput.focus()
        }
      })
    },

    cancelEditSection() {
      this.editingSectionId = null
      this.editingSectionTitle = ''
    },

    async updateSection(sectionId) {
      if (!this.editingSectionTitle.trim()) {
        return
      }

      try {
        await api.put(`/sections/${sectionId}`, {
          title: this.editingSectionTitle
        })

        // Update local data
        const sectionIndex = this.course.sections.findIndex(s => s.id === sectionId)
        if (sectionIndex !== -1) {
          this.course.sections[sectionIndex].title = this.editingSectionTitle
        }

        this.editingSectionId = null
        this.editingSectionTitle = ''
      } catch (error) {
        console.error('Error updating section:', error)
        this.error = 'Failed to update section. Please try again.'
      }
    },

    async deleteSection(sectionId) {
      if (!confirm('Are you sure you want to delete this section? This will also delete all lectures and notes in this section.')) {
        return
      }

      try {
        await api.delete(`/sections/${sectionId}`)

        // Update local data
        this.course.sections = this.course.sections.filter(s => s.id !== sectionId)
      } catch (error) {
        console.error('Error deleting section:', error)
        this.error = 'Failed to delete section. Please try again.'
      }
    },

    closeSectionModal() {
      this.showSectionModal = false
      this.sectionForm = { title: '' }
    },

    async submitSectionForm() {
      if (!this.sectionForm.title.trim()) {
        return
      }

      try {
        const response = await api.post('/sections', {
          course_id: this.courseId,
          title: this.sectionForm.title
        })

        // Add new section to local data
        this.course.sections.push({
          ...response.data.data,
          lectures: [],
          notes: []
        })

        this.closeSectionModal()
      } catch (error) {
        console.error('Error creating section:', error)
        this.error = 'Failed to create section. Please try again.'
      }
    },

    // Lecture methods
    addLecture(sectionId) {
      this.currentSectionId = sectionId
      this.editingLectureId = null
      this.lectureForm = {
        title: '',
        duration: 0,
        youtube_video_id: '',
        is_premium: false
      }
      this.showLectureModal = true
    },

    editLecture(sectionId, lecture) {
      this.currentSectionId = sectionId
      this.editingLectureId = lecture.id
      this.lectureForm = {
        title: lecture.title,
        duration: lecture.duration,
        youtube_video_id: lecture.youtube_video_id || '',
        is_premium: lecture.is_premium
      }
      this.showLectureModal = true
    },

    closeLectureModal() {
      this.showLectureModal = false
      this.currentSectionId = null
      this.editingLectureId = null
      this.lectureForm = {
        title: '',
        duration: 0,
        youtube_video_id: '',
        is_premium: false
      }
    },

    async submitLectureForm() {
      if (!this.lectureForm.title.trim() || this.lectureForm.duration <= 0) {
        return
      }

      try {
        let response

        if (this.editingLectureId) {
          // Update existing lecture
          response = await api.put(`/lectures/${this.editingLectureId}`, {
            title: this.lectureForm.title,
            duration: this.lectureForm.duration,
            youtube_video_id: this.lectureForm.youtube_video_id,
            is_premium: this.lectureForm.is_premium
          })

          // Update local data
          const sectionIndex = this.course.sections.findIndex(s => s.id === this.currentSectionId)
          if (sectionIndex !== -1) {
            const lectureIndex = this.course.sections[sectionIndex].lectures.findIndex(
              l => l.id === this.editingLectureId
            )
            if (lectureIndex !== -1) {
              this.course.sections[sectionIndex].lectures[lectureIndex] = {
                ...response.data.data,
                hover: false
              }
            }
          }
        } else {
          // Create new lecture
          response = await api.post('/lectures', {
            section_id: this.currentSectionId,
            title: this.lectureForm.title,
            duration: this.lectureForm.duration,
            youtube_video_id: this.lectureForm.youtube_video_id,
            is_premium: this.lectureForm.is_premium
          })

          // Add to local data
          const sectionIndex = this.course.sections.findIndex(s => s.id === this.currentSectionId)
          if (sectionIndex !== -1) {
            this.course.sections[sectionIndex].lectures.push({
              ...response.data.data,
              hover: false
            })
          }
        }

        this.closeLectureModal()
      } catch (error) {
        console.error('Error saving lecture:', error)
        this.error = 'Failed to save lecture. Please try again.'
      }
    },

    async deleteLecture(lectureId) {
      if (!confirm('Are you sure you want to delete this lecture?')) {
        return
      }

      try {
        await api.delete(`/lectures/${lectureId}`)

        // Update local data
        for (let i = 0; i < this.course.sections.length; i++) {
          const section = this.course.sections[i]
          const lectureIndex = section.lectures.findIndex(l => l.id === lectureId)

          if (lectureIndex !== -1) {
            section.lectures.splice(lectureIndex, 1)
            break
          }
        }
      } catch (error) {
        console.error('Error deleting lecture:', error)
        this.error = 'Failed to delete lecture. Please try again.'
      }
    },

    // Note methods
    addNote(sectionId) {
      this.currentSectionId = sectionId
      this.editingNoteId = null
      this.noteForm = {
        title: '',
        is_premium: true,
        file: null
      }
      this.showNoteModal = true
    },

    editNote(sectionId, note) {
      this.currentSectionId = sectionId
      this.editingNoteId = note.id
      this.noteForm = {
        title: note.title,
        is_premium: note.is_premium,
        file: null
      }
      this.showNoteModal = true
    },

    handleFileChange(event) {
      this.noteForm.file = event.target.files[0]
    },

    closeNoteModal() {
      this.showNoteModal = false
      this.currentSectionId = null
      this.editingNoteId = null
      this.noteForm = {
        title: '',
        is_premium: true,
        file: null
      }
    },

    async submitNoteForm() {
      if (!this.noteForm.title.trim()) {
        return
      }

      if (!this.editingNoteId && !this.noteForm.file) {
        this.error = 'Please select a file to upload'
        return
      }

      try {
        const formData = new FormData()
        formData.append('title', this.noteForm.title)
        formData.append('is_premium', this.noteForm.is_premium ? '1' : '0')

        if (this.editingNoteId) {
          // Update existing note
          if (this.noteForm.file) {
            formData.append('file', this.noteForm.file)
          }

          const response = await api.post(`/notes/${this.editingNoteId}?_method=PUT`, formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })

          // Update local data
          const sectionIndex = this.course.sections.findIndex(s => s.id === this.currentSectionId)
          if (sectionIndex !== -1) {
            const noteIndex = this.course.sections[sectionIndex].notes.findIndex(
              n => n.id === this.editingNoteId
            )
            if (noteIndex !== -1) {
              this.course.sections[sectionIndex].notes[noteIndex] = {
                ...response.data.data,
                hover: false
              }
            }
          }
        } else {
          // Create new note
          formData.append('section_id', this.currentSectionId)
          formData.append('file', this.noteForm.file)

          const response = await api.post('/notes', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })

          // Add to local data
          const sectionIndex = this.course.sections.findIndex(s => s.id === this.currentSectionId)
          if (sectionIndex !== -1) {
            this.course.sections[sectionIndex].notes.push({
              ...response.data.data,
              hover: false
            })
          }
        }

        this.closeNoteModal()
      } catch (error) {
        console.error('Error saving note:', error)
        this.error = 'Failed to save note. Please try again.'
      }
    },

    async deleteNote(noteId) {
      if (!confirm('Are you sure you want to delete this note/attachment?')) {
        return
      }

      try {
        await api.delete(`/notes/${noteId}`)

        // Update local data
        for (let i = 0; i < this.course.sections.length; i++) {
          const section = this.course.sections[i]
          const noteIndex = section.notes.findIndex(n => n.id === noteId)

          if (noteIndex !== -1) {
            section.notes.splice(noteIndex, 1)
            break
          }
        }
      } catch (error) {
        console.error('Error deleting note:', error)
        this.error = 'Failed to delete note. Please try again.'
      }
    }
  }
}
</script>

<style scoped>
.lecture-management {
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

.course-meta {
  display: flex;
  gap: 1.5rem;
  color: #555555;
}

.course-meta span {
  position: relative;
}

.course-meta span:not(:last-child)::after {
  content: "•";
  position: absolute;
  right: -1rem;
  color: #aaaaaa;
}

.sections-container {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.section-card {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.section-header {
  background-color: #f8f8f8;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #e0e0e0;
}

.section-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.section-title h4 {
  margin: 0;
  font-weight: 600;
}

.section-actions {
  display: flex;
  gap: 0.5rem;
}

.section-edit {
  display: flex;
  gap: 0.75rem;
  align-items: center;
  width: 100%;
}

.section-edit input {
  flex: 1;
}

.content-list {
  padding: 1.5rem;
  border-bottom: 1px solid #e0e0e0;
}

.content-list:last-child {
  border-bottom: none;
}

.content-list h5 {
  margin-top: 0;
  margin-bottom: 1rem;
  color: #000000;
  font-weight: 600;
}

.empty-state {
  background-color: #f8f8f8;
  border-radius: 8px;
  padding: 2rem;
  text-align: center;
  color: #555555;
  margin-bottom: 1.5rem;
}

.empty-state-small {
  color: #777777;
  font-style: italic;
  padding: 0.5rem 0;
  margin-bottom: 1rem;
}

.lecture-list, .note-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  margin-bottom: 1rem;
}

.content-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #ffffff;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.content-item:hover {
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
}

.content-info {
  flex: 1;
}

.content-title {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 500;
}

.content-meta {
  margin-top: 0.25rem;
  font-size: 0.875rem;
  color: #777777;
  display: flex;
  gap: 1rem;
}

.premium {
  color: #000000;
  font-weight: 500;
}

.free {
  color: #555555;
}

.content-actions {
  display: flex;
  gap: 0.5rem;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.content-actions.visible {
  opacity: 1;
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

.form-check {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.form-check-input {
  margin-right: 0.75rem;
  width: 18px;
  height: 18px;
}

.form-check-label {
  font-weight: 500;
}

.form-text {
  display: block;
  margin-top: 0.5rem;
  font-size: 0.875rem;
  color: #777777;
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

.icon {
  width: 18px;
  height: 18px;
  margin-right: 0.5rem;
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

  .section-edit {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>
