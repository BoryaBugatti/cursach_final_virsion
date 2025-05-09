<template>
  <div class="auth-container" v-if="visible_form">
    <h2 class="auth-title">Авторизация</h2>
    <form @submit.prevent="athoriz" class="auth-form">
      <div class="form-group">
        <label for="username">Логин</label>
        <input type="text" id="username" v-model="formData.email" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" id="password" v-model="formData.password" required class="form-input" />
      </div>
      <button type="submit" class="submit-button">Войти</button>
    </form>
    <p class="register-link">Нет аккаунта? <RouterLink to="/register">Зарегистрироваться</RouterLink></p>
  </div>
  <user_lk  v-if="visible_lk"></user_lk>
</template>

<script>
import axios from 'axios';
import user_lk from "@/components/user_lk.vue";
export default {
  components:{
    user_lk,
  },
  data() {
    return {
      visible_lk: false,
      visible_form: true,
      formData: {
        email: '',
        password: '',
      },
      user_email: '',
      user_name: '',
    };
  },
  created() {
    const email = sessionStorage.getItem('client_email');
    const name = sessionStorage.getItem('user_name');
    if (email) {
      this.visible_lk = true;
      this.visible_form = false;
      this.user_email = email;
      this.user_name = name;
    }
  },
  methods: {
    async athoriz() {
      try {
        const response = await axios.post('http://localhost:8090/api/athoriz', this.formData);
        if (response.data['status'] == 'success') {
          this.visible_lk = true;
          this.visible_form = false;
          sessionStorage.setItem('client_email', this.formData.email);
          sessionStorage.setItem('client_password', this.formData.password);
          sessionStorage.setItem('user_name', response.data['user_name']);
          sessionStorage.setItem('user_avatar', response.data['user_avatar']);
          alert('Вы успешно авторизировались');
        } else {
          alert('Неверный логин или пароль');
        }
      } catch (error) {
        console.error('Ошибка при авторизации:', error);
      }
    },
  }
};
</script>

<style scoped>
.auth-container, .lk-container {
  max-width: 400px; 
  margin: 5% auto; 
  padding: 20px; 
  background-color: #ffffff;
  border-radius: 8px; 
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
  animation: fadeIn 0.5s ease-in-out;
}

.auth-title {
  color: #4CAF50; 
  text-align: center; 
  margin-bottom: 20px; 
}

.auth-form {
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

.register-link {
  text-align: center; 
  margin-top: 15px; 
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
