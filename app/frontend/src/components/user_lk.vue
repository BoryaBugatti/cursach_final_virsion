<template>
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
        <button type="submit" class="submit-button">Загрузить аватар</button>
      </form>
      <form @submit.prevent="logout">
        <button type="submit" class="submit-button logout-button">Выйти</button>
      </form>
      <form>
        <button type="submit" class="submit-button">Получить данные о всех заказах</button>
      </form>
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
    }
  },
};
</script>

<style scoped>
.lk-container {
  display: flex;
  flex-direction: column;
  width: 600px;
  margin-left: 32%;
  margin-top: 3%;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.auth-title {
  text-align: center;
  color: #333;
  margin-bottom: 20px;
}

.user-info {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.avatar-container {
  flex: 0 0 100px;
  margin-right: 20px;
}

.user-avatar {
  width: 100%;
  border-radius: 50%;
  border: 2px solid #007bff;
}

.user-details {
  flex: 1;
}

.welcome-message {
  font-size: 1.2em;
  color: #555;
}

.user-email {
  color: #777;
}

.user_role{
  color: #777;
}
.buttons-container {
  display: flex;
  justify-content: space-between;
}

.submit-button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.submit-button:hover {
  background-color: #0056b3;
}

.logout-button {
  background-color: #dc3545;
}

.logout-button:hover {
  background-color: #c82333;
}
</style>