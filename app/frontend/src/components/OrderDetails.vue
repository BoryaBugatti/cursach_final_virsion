<template>
  <div>
    <h2>Детали заказа №{{ orderId }}</h2>
    <div class="order-container" v-if="currentOrder">
      <div class="order-card">
        <h3>Заказ №{{ currentOrder.id }}</h3>
        <p>Имя клиента: {{ currentOrder.orderClientName }}</p>
        <p>Адрес заказа: {{ currentOrder.orderAddress }}</p>
        <p>Тип отходов: {{ currentOrder.orderWasteType }}</p>
        <p>Дата: {{ formatDate(currentOrder.orderDate) }}</p>
        <p>Время: {{ formatTime(currentOrder.orderTime) }}</p>
        <p>Объем отходов(кг): {{ currentOrder.orderWasteVolume }}</p>

        <div class="route-info" v-if="routeInfo">
          <h4>Информация о маршруте:</h4>
          <p>Машина: {{ routeInfo.transport.type }} (№{{ routeInfo.transport.number }})</p>
          <p>Водитель: {{ routeInfo.driver.name }}</p>
          <p>Дата и время маршрута: {{ formatDateTime(routeInfo.schedule) }}</p>
        </div>
        <div v-else>
          <p>Маршрут не назначен</p>
        </div>

        <div class="order-actions">
          <button @click="openRouteModal(currentOrder)" class="edit-button">Назначить Маршрут</button>
          <button @click="deleteOrder(currentOrder.id)" class="delete-button">Удалить</button>
          <button @click="goBack" class="edit-button">Назад к списку</button>
        </div>
      </div>
    </div>
    <div v-else>
      <p>Заказ с ID {{ orderId }} не найден</p>
      <button @click="goBack" class="edit-button">Назад к списку</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      orderId: parseInt(this.$route.params.id),
      orders: [],
      currentOrder: null,
      routeInfo: null 
    };
  },
  methods: {
    async showDetails() {
      const storedOrders = sessionStorage.getItem('orders');
      console.log('Stored Orders:', storedOrders);
      
      if (storedOrders) {
        try {
          this.orders = JSON.parse(storedOrders);
          this.currentOrder = this.orders.find(order => 
            parseInt(order.id) === this.orderId
          );
          
          if (this.currentOrder && this.currentOrder.route_id) {
            await this.fetchRouteInfo(this.currentOrder.route_id);
          }
        } catch (e) {
          console.error('Error:', e);
        }
      }
    },
    async fetchRouteInfo(routeId) {
      try {
        const response = await fetch("http://localhost:8090/api/get_route_info");
        if (response.ok) {
          this.routeInfo = await response.json();
          console.log('Route info:', this.routeInfo);
        }
      } catch (e) {
        console.error('Error fetching route info:', e);
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('ru-RU', options);
    },
    formatTime(timeString) {
      const options = { hour: '2-digit', minute: '2-digit' };
      return new Date(timeString).toLocaleTimeString('ru-RU', options);
    },
    formatDateTime(datetimeString) {
      const date = new Date(datetimeString);
      return date.toLocaleString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    },
    goBack() {
      this.$router.push('/Lk');
    },
    openRouteModal(order) {
      console.log('Open modal for order:', order.id);
    },
    deleteOrder(id) {
      console.log('Delete order:', id);
    }
  },
  mounted() {
    this.showDetails();
  }
};
</script>

<style scoped>
.order-container {
  margin-top: 20px;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.order-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  background: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.route-info {
  margin-top: 20px;
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 5px;
  border-left: 4px solid #007bff;
}

.route-info h4 {
  margin-top: 0;
  color: #007bff;
}

.order-actions {
  display: flex;
  gap: 10px;
  margin-top: 20px;
  justify-content: center;
}

.edit-button {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
}

.delete-button {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
}

h2 {
  text-align: center;
  color: #333;
}

p {
  margin: 8px 0;
  line-height: 1.6;
}
</style>