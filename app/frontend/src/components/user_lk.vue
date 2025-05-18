<template>
  <div class="lk-cont">
    <div class="lk-container">
      <h2 class="auth-title">Личный кабинет</h2>
      <div class="user-info">
        <div class="avatar-container">
          <img :src="user_avatar" alt="Аватар пользователя" class="user-avatar" />
        </div>
        <div class="user-details">
          <p class="welcome-message">Добро пожаловать, <strong>{{ user_name }}</strong>!</p>
          <p class="user-email">Ваша почта: <strong>{{ user_email }}</strong></p>
          <p class="user_role">Ваша роль: <strong>{{ user_role }}</strong></p>
        </div>
      </div>
      <div class="buttons-container">
        <form @submit.prevent="download_avatar">
          <button type="submit" class="submit-button">Изменить аватар</button>
        </form>
        <form @submit.prevent="logout">
          <button type="submit" class="submit-button logout-button">Выйти</button>
        </form>
        <form @submit.prevent="getAllOrders" v-if="user_role == 'Админ'">
          <button type="submit" class="submit-button">Получить данные о всех заказах</button>
        </form>
        <button @click="Click" class="submit-button">Скрыть заказы</button>
        <div class="sort_buttons" v-if="orders.length != 0">
          <button @click="sortByDate" class="submit-button">Сортировать по дате</button>
          <button @click="sortByClientName" class="submit-button">Сортировать по имени клиента</button>
          <button @click="sortByOrderNumber" class="submit-button">Сортировать по номеру заказа</button>
        </div>
      </div>
      <div class="orders-container">
        <div class="order-card" v-for="order in orders" :key="order.id">
          <h3>Заказ №{{ order.id }}</h3>
          <p>Имя клиента: {{ order.orderClientName }}</p>
          <p>Адрес заказа: {{ order.orderAddress }}</p>
          <p>Тип отходов: {{ order.orderWasteType }}</p>
          <p>Дата: {{ formatDate(order.orderDate) }}</p>
          <p>Время: {{ formatTime(order.orderTime) }}</p>
          <p>Объем отходов(кг): {{ order.orderWasteVolume }}</p>
          <div class="order-actions">
            <button @click="openRouteModal(order)" class="edit-button">Назначить Маршрут</button>
            <button @click="deleteOrder(order.id)" class="delete-button">Удалить</button>
            <button @click="more_details(order.id)" class="edit-button">Подробнее</button>
          </div>
        </div>
      </div>
    </div>

    <transition name="modal-fade">
      <div v-if="showRouteModal" class="modal-backdrop" @click.self="closeModal">
        <div class="modal">
          <div class="modal-header">
            <h3>Назначение маршрута для заказа №{{ selectedOrder.id }}</h3>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close modal">
              &times;
            </button>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label>Транспорт:</label>
              <select v-model="routeData.transport_id" class="form-control" required>
                <option value="" disabled>Выберите транспорт</option>
                <option 
                  v-for="transport in availableTransport" 
                  :value="transport.id" 
                  :key="transport.id"
                  :disabled="transport.transportCondition !== 'свободен'">
                  {{ transport.transportType }} №{{ transport.transportNumber }} 
                  ({{ transport.transportCapacity }}кг) - 
                  {{ transport.transportCondition}}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label>Водитель:</label>
              <select v-model="routeData.driver_id" class="form-control" required>
                <option value="" disabled>Выберите водителя</option>
                <option 
                  v-for="driver in availableDrivers" 
                  :value="driver.id" 
                  :key="driver.id">
                  {{ driver.driverName }}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label>Дата и время маршрута:</label>
              <input 
                type="datetime-local" 
                v-model="routeData.route_schedule" 
                class="form-control"
                required
              >
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">
              Отмена
            </button>
            <button 
              type="button" 
              class="btn btn-primary" 
              @click="assignRoute"
              :disabled="!isFormValid">
              Назначить маршрут
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user_email: '',
      user_name: '',
      user_avatar: '',
      user_role: '',
      orders: [],
      click_count: 0,
      showRouteModal: false,
      selectedOrder: null,
      availableTransport: [],
      availableDrivers: [],
      routeData: {
        transport_id: null,
        driver_id: null,
        route_schedule: '',
        order_id: null,
      }
    };
  },
  computed: {
    isFormValid() {
      return (
        this.routeData.transport_id && 
        this.routeData.driver_id && 
        this.routeData.route_schedule
      );
    }
  },
  created() {
    const email = sessionStorage.getItem('client_email');
    const name = sessionStorage.getItem('user_name');
    const avatar = sessionStorage.getItem('user_avatar');
    this.user_role = sessionStorage.getItem('user_role');
    const storedOrders = sessionStorage.getItem('orders');
    if (storedOrders) {
      this.orders = JSON.parse(storedOrders); 
    } 
    if (email) {
      this.visible_lk = true;
      this.visible_form = false;
      this.user_email = email;
      this.user_name = name;
      this.user_avatar = avatar || 'default-avatar.png'; 
    }
  },
  methods: {
    logout() {
      sessionStorage.clear();
      this.visible_lk = false;
      this.visible_form = true;
      this.user_email = '';
      alert('Вы вышли из системы');
      window.location.href='/';
    },
    download_avatar() {
      this.user_avatar = prompt('Вставьте ссылку на картинку, которая будет отображаться в вашем профиле');
      this.download_in_bd();
      sessionStorage.setItem('user_avatar', this.user_avatar);
    },
    async download_in_bd() {
      const response = await axios.post('http://localhost:8090/api/downloadavatar', {
        user_avatar: this.user_avatar, 
        user_email: this.user_email
      });
      if (response.data['status'] == 'success') {
        alert('Ваш аватар успешно обновлен');
      }
    },
    async getAllOrders() {
      const response = await axios.get('http://localhost:8090/api/get_all_orders');
      this.orders = response.data;
      sessionStorage.setItem('orders', JSON.stringify(this.orders));
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      const date = new Date(dateString);
      return date.toLocaleDateString('ru-RU', options);
    },
    formatTime(timeString) {
      const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'UTC' };
      const time = new Date(timeString);
      return time.toLocaleTimeString('ru-RU', options);
    },
    Click() {
      this.orders = [];
    },
    sortByDate() {
      this.orders.sort((a, b) => new Date(a.orderDate) - new Date(b.orderDate));
    },
    sortByClientName() {
      this.orders.sort((a, b) => a.orderClientName.localeCompare(b.orderClientName));
    },
    sortByOrderNumber() {
      this.orders.sort((a, b) => a.id - b.id);
    },
    more_details(id) {
      this.$router.push({ name: 'OrderDetails', params: { id: id } });
    },
    async openRouteModal(order) {
      this.selectedOrder = order;
      this.routeData.order_id = order.id;
      
      try {
        const transportResponse = await axios.get('http://localhost:8090/api/get_all_transport');
        this.availableTransport = transportResponse.data;
        
        const driversResponse = await axios.get('http://localhost:8090/api/get_all_drivers');
        this.availableDrivers = driversResponse.data;
        
        this.showRouteModal = true;
      } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
        alert('Не удалось загрузить данные для назначения маршрута');
      }
    },
    closeModal() {
      this.showRouteModal = false;
      this.resetRouteData();
    },
    resetRouteData() {
      this.routeData = {
        transport_id: null,
        driver_id: null,
        route_schedule: '',
        order_id: null
      };
    },
    async assignRoute() {
      try {
        const routeResponse = await axios.post('http://localhost:8090/api/create_route', {
          route_schedule: this.routeData.route_schedule,
          transport_id: this.routeData.transport_id,
          driver_session_id: this.routeData.driver_id
        });
        
        const routeId = routeResponse.data.id;
        
        await axios.patch("http://localhost:8090/api/update_route_id_in_order", {order_id: this.routeData.order_id, route_id: routeId});
        
        await axios.post('http://localhost:8090/api/execution-events', {
          order_id: this.routeData.order_id,
          route_id: routeId,
          ee_time: new Date().toISOString(),
          ee_status: 'scheduled'
        });
        
        alert('Маршрут успешно назначен!');
        this.closeModal();
        this.getAllOrders();
      } catch (error) {
        console.error('Ошибка при назначении маршрута:', error);
        alert('Произошла ошибка при назначении маршрута');
      }
    },
    async deleteOrder(orderId) {
      if (confirm('Вы уверены, что хотите удалить этот заказ?')) {
        try {
          await axios.delete(`http://localhost:8090/api/orders/${orderId}`);
          this.orders = this.orders.filter(order => order.id !== orderId);
          sessionStorage.setItem('orders', JSON.stringify(this.orders));
        } catch (error) {
          console.error('Ошибка при удалении заказа:', error);
          alert('Не удалось удалить заказ');
        }
      }
    }
  }
};
</script>

<style scoped>
.lk-cont {
  margin-top: 2%;
  margin-left: 20%;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  width: 1300px;
  padding: 20px;
}

.lk-container {
  display: flex;
  flex-direction: column;
  width: 100%; 
  max-width: 1200px;
  padding: 30px; 
  background-color: #ffffff; 
  border-radius: 12px; 
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.auth-title {
  text-align: center;
  color: #333;
  margin-bottom: 30px; 
  font-size: 2em; 
}


.user-info {
  display: flex;
  align-items: center;
  margin-bottom: 30px; 
}

.avatar-container {
  flex: 0 0 120px;
  margin-right: 20px;
}

.user-avatar {
  width: 100%;
  border-radius: 50%;
  border: 3px solid #007bff; 
}

.user-details {
  flex: 1;
}

.welcome-message {
  font-size: 1.5em; 
  color: #555;
}

.user-email, .user_role {
  color: #777;
}

.buttons-container {
  display: flex;
  flex-wrap: wrap;
  gap: 1.56vw;
  margin-bottom: 30px; 
}

.sort_buttons{
  display: flex;
  flex-wrap: wrap;
  gap: 1.56vw;
}

.submit-button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s; 
}

.submit-button:hover {
  background-color: #0056b3;
  transform: translateY(-2px); 
}

.logout-button {
  background-color: #dc3545;
  padding: 12px 24px; 
}

.logout-button:hover {
  background-color: #c82333;
  transform: translateY(-2px); 
}

.orders-container {
  display: flex;
  flex-wrap: wrap; 
  justify-content: flex-start;
  padding: 20px;
}

.order-card {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin: 15px;
  padding: 20px;
  width: 100%; 
  max-width: 400px; 
  transition: transform 0.2s, box-shadow 0.2s; 
}

.order-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
}

.order-card h3 {
  color: #333;
  font-size: 1.5em;
  margin-bottom: 10px;
}

.order-card p {
  color: #555;
  margin: 5px 0;
}

.order-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 15px;
}

.edit-button, .delete-button {
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s; 
}

.edit-button {
  background-color: #007bff;
  color: white;
}

.edit-button:hover {
  background-color: #0056b3;
  transform: translateY(-2px); 
}

.delete-button {
  background-color: #dc3545;
  color: white;
}

.delete-button:hover {
  background-color: #c82333;
  transform: translateY(-2px); 
}
.modal-fade-enter,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal {
  background: #ffffff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  border-radius: 8px;
  overflow: hidden;
  width: 500px;
  max-width: 95%;
}

.modal-header {
  padding: 15px 20px;
  background: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h3 {
  margin: 0;
  font-size: 1.25rem;
}

.btn-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #6c757d;
  padding: 0;
  line-height: 1;
}

.btn-close:hover {
  color: #333;
}

.modal-body {
  padding: 20px;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.form-control {
  display: block;
  width: 100%;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.modal-footer {
  padding: 15px 20px;
  background: #f8f9fa;
  border-top: 1px solid #dee2e6;
  display: flex;
  justify-content: flex-end;
}

.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  user-select: none;
  border: 1px solid transparent;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  cursor: pointer;
  margin-left: 10px;
}

.btn-primary {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0069d9;
  border-color: #0062cc;
}

.btn-primary:disabled {
  background-color: #6c757d;
  border-color: #6c757d;
  cursor: not-allowed;
}

.btn-secondary {
  color: #fff;
  background-color: #6c757d;
  border-color: #6c757d;
}

.btn-secondary:hover {
  background-color: #5a6268;
  border-color: #545b62;
}
</style>