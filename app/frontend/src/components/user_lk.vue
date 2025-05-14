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
        <form @submit.prevent = "getAllOrders" v-if="user_role == 'Админ'">
          <button type="submit" class="submit-button">Получить данные о всех заказах</button>
        </form>
        <button @click='Click' class="submit-button">Скрыть заказы</button>
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
            <button @click="editOrder(order.id)" class="edit-button">Назначить водителя</button>
            <button @click="deleteOrder(order.id)" class="delete-button">Удалить</button>
          </div>
        </div>
      </div>
    </div>
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
    };
  },
  created() {
    const email = sessionStorage.getItem('client_email');
    const name = sessionStorage.getItem('user_name');
    const avatar = sessionStorage.getItem('user_avatar');
    this.user_role = sessionStorage.getItem('user_role'); 
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
    download_avatar(){
      this.user_avatar = prompt('Вставьте ссылку на картинку, которая будет отобржаться в вашем профиле');
      this.download_in_bd();
      sessionStorage.setItem('user_avatar', this.user_avatar);
    },
    async download_in_bd(){
      const response = await axios.post('http://localhost:8090/api/downloadavatar', {user_avatar: this.user_avatar, user_email: this.user_email});
      if (response.data['status'] == 'success')
        alert('Ваш аватар успешно обновлен');
    },
    async getAllOrders(){
      const response = await axios.get('http://localhost:8090/api/get_all_orders');
      this.orders = response.data;
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
    Click(){
      this.orders = [];
    },
    sortByDate() {
      this.orders.sort((a, b) => new Date(a.orderDate) - new Date(b.orderDate));
    },
  
    sortByClientName() {
      this.orders.sort((a, b) => a.orderClientName.localeCompare(b.orderClientName));
    },
    sortByOrderNumber(){
      this.orders.sort((a, b) => a.id - b.id);
    }
  },
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
</style>