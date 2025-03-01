<template>
  <div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="m-0">Order Management</h2>
    </div>

    <div v-if="loading" class="text-center my-5">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <div v-else>
      <!-- Orders Table -->
      <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="py-3">ID</th>
                  <th class="py-3">User</th>
                  <th class="py-3">Course</th>
                  <th class="py-3">Amount</th>
                  <th class="py-3">Payment Method</th>
                  <th class="py-3">Transaction ID</th>
                  <th class="py-3">Status</th>
                  <th class="py-3">Date</th>
                  <th class="py-3 text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in orders.data" :key="order.id">
                  <td class="py-3">{{ order.id }}</td>
                  <td class="py-3">{{ order.user.name }}</td>
                  <td class="py-3">{{ order.course.title }}</td>
                  <td class="py-3">${{ order.amount }}</td>
                  <td class="py-3">{{ order.payment_method }}</td>
                  <td class="py-3">
                    <span class="badge bg-light text-dark border">
                      {{ order.transaction_id }}
                    </span>
                  </td>
                  <td class="py-3">
                    <span
                      class="badge"
                      :class="{
                        'bg-light text-dark border border-warning': order.payment_status === 'pending',
                        'bg-light text-dark border border-success': order.payment_status === 'completed',
                        'bg-light text-dark border border-danger': order.payment_status === 'failed'
                      }"
                    >
                      {{ order.payment_status }}
                    </span>
                  </td>
                  <td class="py-3">{{ formatDate(order.created_at) }}</td>
                  <td class="py-3 text-end">
                    <!-- Direct action buttons instead of dropdown -->
                    <div class="btn-group">
                      <button
                        v-if="order.payment_status === 'pending'"
                        @click="updateOrderStatus(order.id, 'completed')"
                        class="btn btn-sm btn-outline-dark"
                        title="Approve Payment"
                      >
                        <i class="fas fa-check"></i>
                      </button>
                      <button
                        v-if="order.payment_status === 'pending'"
                        @click="updateOrderStatus(order.id, 'failed')"
                        class="btn btn-sm btn-outline-dark ms-1"
                        title="Reject Payment"
                      >
                        <i class="fas fa-times"></i>
                      </button>
                      <button
                        v-if="order.payment_status === 'completed' || order.payment_status === 'failed'"
                        @click="updateOrderStatus(order.id, 'pending')"
                        class="btn btn-sm btn-outline-dark"
                        title="Mark as Pending"
                      >
                        <i class="fas fa-undo"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="orders.data && orders.data.length === 0">
                  <td colspan="9" class="text-center py-5">No orders found</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import api from '@/api'

export default {
  setup() {
    const orders = ref({ data: [] })
    const loading = ref(true)
    const error = ref(null)

    // Fetch orders from API
    const fetchOrders = async () => {
      try {
        loading.value = true
        const response = await api.get('/orders')
        orders.value = response.data.orders
        loading.value = false
      } catch (err) {
        console.error('Error fetching orders:', err)
        error.value = 'Failed to load orders. Please try again.'
        loading.value = false
      }
    }

    // Update order status
    const updateOrderStatus = async (orderId, status) => {
      try {
        loading.value = true

        await api.put(`/orders/${orderId}/status`, {
          payment_status: status
        })

        // Refresh orders list
        await fetchOrders()

        // Show success message
        const statusMessages = {
          'completed': 'Payment approved successfully',
          'failed': 'Payment rejected',
          'pending': 'Order marked as pending'
        }

        alert(statusMessages[status] || `Status updated to ${status}`)
      } catch (err) {
        console.error('Error updating order status:', err)
        alert('Failed to update order status. Please try again.')
        loading.value = false
      }
    }

    // Format date
    const formatDate = (dateString) => {
      if (!dateString) return 'Unknown'
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      })
    }

    // Fetch orders on component mount
    onMounted(() => {
      fetchOrders()
    })

    return {
      orders,
      loading,
      error,
      fetchOrders,
      updateOrderStatus,
      formatDate
    }
  }
}
</script>

<style scoped>
.table th {
  font-weight: 600;
  color: #333;
}

.badge {
  font-size: 0.85em;
  padding: 0.35em 0.65em;
  font-weight: 500;
}

.btn-outline-dark:hover {
  background-color: #333;
  color: white;
}

.shadow-sm {
  box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}

/* Clean table styles */
.table {
  color: #333;
}

.table-hover tbody tr:hover {
  background-color: rgba(0,0,0,.03);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .table {
    font-size: 0.9rem;
  }
}
</style>
