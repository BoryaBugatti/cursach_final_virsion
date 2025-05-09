<template>
  <div class="registration-container">
    <h2 class="registration-title">Заказать вывоз мусора</h2>
    <form class="registration-form" @submit.prevent="make_order">
      <div class="form-group">
        <label for="name">Имя заказчика</label>
        <input type="text" id="name" v-model="order_data.client_name" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="address">Адрес</label>
        <input type="text" id="address" v-model="order_data.address" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="waste_type">Тип отходов</label>
        <select name="waste_type" v-model="order_data.waste_type" required class="form-input">
          <option value="Glass">Стекло</option>
          <option value="Metall">Металл</option>
          <option value="Paper">Бумага</option>
          <option value="Electronic">Электроника</option>
        </select>
      </div>
      <div class="form-group">
        <label for="date">Дата</label>
        <input type="date" id="date" v-model="order_data.date" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="time">Время</label>
        <input type="time" id="time" v-model="order_data.time" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="volume">Объем отходов</label>
        <input type="text" id="volume" v-model="order_data.waste_volume" required class="form-input" />
      </div>
      <button type="submit" class="submit-button">Сделать заказ</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
      return {
          order_data: {
              client_name: '',
              address: '',
              waste_type: '',
              date: '',
              time: '',
              waste_volume: '',
          }
      }
  },
  methods: {
      async make_order() {
          try {
              const response = await axios.post('http://localhost:8090/api/make_order', this.order_data);
              if (response.data['status'] === 'success') {
                  alert('Заказ успешно добавлен в базу данных');
              } else {
                  alert('Ошибка при добавлении заказа');
              }
          } catch (error) {
              console.error('Ошибка:', error);
              alert('Произошла ошибка при отправке запроса');
          }
      }
  }
}
</script>


<style scoped>
.registration-container {
  max-width: 500px; 
  margin: 5% auto; 
  padding: 20px;
  background-color: #ffffff;
  border-radius: 8px; 
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
}

.registration-title {
  color: #4CAF50; 
  text-align: center; 
  margin-bottom: 20px; 
}

.registration-form {
  display: flex;
  flex-direction: column;
  gap: 15px; 
}

.form-group {
  display: flex;
  flex-direction: column; 
}

label {
  margin-bottom: 5px; 
  font-weight: bold; 
  color: #333; 
}

.form-input {
  padding: 12px; 
  border: 1px solid #ccc; 
  border-radius: 4px; 
  transition: border-color 0.3s; 
}

.form-input:focus {
  border-color: #4CAF50; 
  outline: none; 
}

.submit-button {
  padding: 12px; 
  background-color: #4CAF50; 
  color: white; 
  border: none; 
  border-radius: 4px; 
  cursor: pointer; 
  transition: background-color 0.3s;
}

.submit-button:hover {
  background-color: #388E3C; 
}

.response-message {
  margin-top: 20px; 
  color: #d9534f; 
}
</style>