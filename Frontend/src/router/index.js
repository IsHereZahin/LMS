import { createRouter, createWebHistory } from "vue-router"
import AdminLayout from "@/views/Layouts/AdminLayout.vue"
import StudentLayout from "@/views/Layouts/StudentLayout.vue"
import WebsiteLayout from "@/views/Layouts/WebsiteLayout.vue"

// Routes
const routes = [
  {
    path: "/",
    component: WebsiteLayout,
    children: [
      {
        path: "",
        component: () => import("../views/Website/Index.vue"),
      },
      {
        path: "course/:id",
        name: "CourseView",
        component: () => import("../views/Website/CourseDetails.vue"),
      },
    ],
  },

  // Auth Routes
  {
    path: "/login",
    component: () => import("../views/Auth/Login.vue"),
  },
  {
    path: "/register",
    component: () => import("../views/Auth/Register.vue"),
  },

  // Student Dashboard (Only accessible by students)
  {
    path: "/dashboard",
    component: StudentLayout,
    meta: { requiresAuth: true, role: "student" },
    children: [
      {
        path: "",
        component: () => import("../views/Student/Dashboard.vue"),
      },
      {
        path: "orders",
        name: "myOrders",
        component: () => import("../views/Student/Orders.vue"),
      },
      {
        path: "courses",
        name: "myCourses",
        component: () => import("../views/Student/Courses.vue"),
      },
    ],
  },

  // Admin Dashboard (Only accessible by admins)
  {
    path: "/admin-dashboard",
    component: AdminLayout,
    meta: { requiresAuth: true, role: "admin" },
    children: [
      {
        path: "",
        component: () => import("../views/Admin/Dashboard.vue"),
      },
      {
        path: "courses",
        name: "CourseList",
        component: () => import("../views/Admin/CourseList.vue"),
      },
      {
        path: "courses/create",
        name: "CourseCreate",
        component: () => import("../views/Admin/CourseForm.vue"),
      },
      {
        path: "courses/:id/edit",
        name: "CourseEdit",
        component: () => import("../views/Admin/CourseForm.vue"),
      },
      {
        path: "courses/:id/content",
        name: "LectureManagement",
        component: () => import("../views/Admin/LectureManagement.vue"),
      },
      {
        path: "courses/:id/faqs",
        name: "FaqManagement",
        component: () => import("../views/Admin/FaqManagement.vue"),
      },
      {
        path: "orders",
        name: "Orders",
        component: () => import("../views/Admin/Orders.vue"),
      },
    ],
  },
]

// Create Router
const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Navigation Guard
router.beforeEach((to, from, next) => {
  const loggedIn = localStorage.getItem("token");
  const role = localStorage.getItem("role");

  // logged-in users cannot access login and register pages
  if (loggedIn && (to.path === "/login" || to.path === "/register")) {
    next(role === "admin" ? "/admin-dashboard" : "/dashboard");
  }
  // Restrict access based on user role
  else if (to.path.startsWith("/admin-dashboard") && role !== "admin") {
    next("/dashboard");
  } else if (to.path.startsWith("/dashboard") && role !== "student") {
    next("/admin-dashboard");
  }
  // Protect all authenticated routes
  else if (to.matched.some((record) => record.meta.requiresAuth) && !loggedIn) {
    next("/login");
  } else {
    next();
  }
});

export default router
