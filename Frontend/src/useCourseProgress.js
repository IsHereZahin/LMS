import { ref, computed } from "vue"
import api from "@/api"

export default function useCourseProgress(courseId) {
  const progress = ref({
    completed_lessons: "[]",
    progress_percentage: "0",
  })
  const isLoading = ref(false)
  const error = ref(null)

  // Parse completed lessons from JSON string
  const completedLessons = computed(() => {
    try {
      return JSON.parse(progress.value.completed_lessons || "[]")
    } catch (e) {
      console.error("Error parsing completed lessons:", e)
      return []
    }
  })

  // Fetch the user's progress for this course
  const fetchProgress = async () => {
    if (!courseId) return

    try {
      isLoading.value = true
      const response = await api.get(`/course-progress/show/${courseId}`)

      if (response.data.success) {
        progress.value = response.data.data.progress
      }
    } catch (err) {
      console.error("Error fetching course progress:", err)
      error.value = "Failed to load your progress"
    } finally {
      isLoading.value = false
    }
  }

  // Mark a lecture as completed
  const markLectureCompleted = async (lectureId) => {
    if (!courseId || !lectureId) return

    try {
      isLoading.value = true
      const response = await api.post(`/course-progress/update/${courseId}`, {
        lecture_id: lectureId,
        completed: true,
      })

      if (response.data.success) {
        progress.value = response.data.data.progress
      }
    } catch (err) {
      console.error("Error updating course progress:", err)
      error.value = "Failed to update your progress"
    } finally {
      isLoading.value = false
    }
  }

  // Check if a lecture is completed
  const isLectureCompleted = (lectureId) => {
    return completedLessons.value.includes(Number(lectureId))
  }

  return {
    progress,
    completedLessons,
    isLoading,
    error,
    fetchProgress,
    markLectureCompleted,
    isLectureCompleted,
  }
}
