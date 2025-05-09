<template>
  <div class="registration-container">
    <h2 class="registration-title">Регистрация</h2>
    <form @submit.prevent="registerUser" class="registration-form">
      <div class="form-group">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" v-model="formData.username" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="formData.email" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" id="password" v-model="formData.password" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="address">Адрес:</label>
        <input type="text" id="text" v-model="formData.address" required class="form-input" />
      </div>
      <button type="submit" class="submit-button">Зарегистрироваться</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      formData: {
        username: '',
        email: '',
        password: '',
        address: '',
      },
    };
  },
  methods: {
    async registerUser() {
      try {
        const response = await axios.post('http://localhost:8090/api/register', this.formData);
        this.formData.username = '';
        this.formData.email = '';
        this.formData.password = '';
        this.formData.address = '';
        if (response.data['status'] == 'success'){
          alert('Вы успешно зарегистрировались');
        }
      } catch (error) {
        console.error('Ошибка при регистрации:', error);
        this.responseMessage = { status: 'error', message: 'Ошибка при регистрации' };
      }
    }
  }
};
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
