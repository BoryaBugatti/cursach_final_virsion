<template>
  <div class="lk-container">
    <h2 class="auth-title">Личный кабинет</h2>
    <div class="avatar-container">
      <img :src="user_avatar" alt="Аватар пользователя" class="user-avatar" />
    </div>
    <p>Добро пожаловать, {{ user_name }}!</p>
    <p>Ваша почта: {{ user_email }}</p>
    <form @submit.prevent="download_avatar">
      <button type="submit" class="submit-button">Загрузить аватар</button>
    </form>
    <form @submit.prevent="logout">
      <button type="submit" class="submit-button">Выйти</button>
    </form>
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
    };
  },
  created() {
    const email = sessionStorage.getItem('client_email');
    const name = sessionStorage.getItem('user_name');
    const avatar = sessionStorage.getItem('user_avatar'); 
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
    }
  },
};
</script>

<style scoped>
.lk-container {
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

.avatar-container {
  display: flex;
  justify-content: center;
  margin-bottom: 15px;
}

.user-avatar {
  width: 100px;
  height: 100px; 
  border-radius: 50%; 
  border: 2px solid #4CAF50;
  object-fit: cover; 
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
