<template>
  <header class="header-container">
    <div class="img-container">
      <img :src="main_icon" alt="Логотип" class="logo" />
    </div>
    <div class="for-organization">
      <div class="line1">
        <p class="organization-title">Для организаций</p>
      </div>
      <div class="line2">
        <img :src="phone_icon" alt="Телефон" class="icon" />
        <p>+79046892129</p>
      </div>
      <div class="line3">
        <img :src="email_icon" alt="Email" class="icon" />
        <p>bl4856@gmail.com</p>
      </div>
      <div class="line4">
        <img :src="clock" alt="Расписание" class="icon" />
        <p>Пн-Чт: 8:30-17:30 Пт: 8:30-16:30</p>
      </div>
      <div class="line5">
        <img :src="geo_icon" alt="Адрес" class="icon" />
        <p>г. Липецк, пл. Плеханова, д. 3, оф. 504</p>
      </div>
    </div>
    <div class="for-organization">
      <div class="line1">
        <p class="organization-title">Для частных лиц</p>
      </div>
      <div class="line2">
        <img :src="phone_icon" alt="Телефон" class="icon" />
        <p>+79046892129</p>
      </div>
      <div class="line3">
        <img :src="email_icon" alt="Email" class="icon" />
        <p>bl4856@gmail.com</p>
      </div>
      <div class="line4">
        <img :src="clock" alt="Расписание" class="icon" />
        <p>Пн-Чт: 8:30-17:30 Пт: 8:30-16:30</p>
      </div>
      <div class="line5">
        <img :src="geo_icon" alt="Адрес" class="icon" />
        <p>г. Липецк, пл. Плеханова, д. 3, оф. 504</p>
      </div>
    </div>
  </header>
</template>

<script>
import phone_icon from "@/assets/images/phone-call_9900273.png";
import email_icon from "@/assets/images/email_561127.png";
import clock from "@/assets/images/alarm-clock_1950588.png";
import geo_icon from "@/assets/images/free-icon-placeholder-117967.png";
import main_icon from "@/assets/images/free-icon-recycle-sign-861143.png";

export default {
  data() {
    return {
      phone_icon,
      email_icon,
      clock,
      geo_icon,
      main_icon,
    };
  },
};
</script>

<style scoped>
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

.header-container {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: center;
  padding: 20px;
  background-color: #f9f9f9;
  border-bottom: 2px solid #4caf50;
  animation: fadeIn 1s ease-in-out;
}

.img-container {
  flex: 0 0 auto;
}

.logo {
  width: 100px;
  height: auto;
  transition: transform 0.3s;
}

.logo:hover {
  transform: scale(1.1);
}

.for-organization {
  display: flex;
  flex-direction: column;
  margin-left: 20px;
}

.line1 {
  margin-bottom: 10px;
}

.organization-title {
  font-weight: bold;
  color: #4caf50;
  animation: slideIn 0.5s ease-in-out;
}

.line2, .line3, .line4, .line5 {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  opacity: 0;
  animation: fadeInUp 0.5s forwards;
}

.line2 { animation-delay: 0.2s; }
.line3 { animation-delay: 0.4s; }
.line4 { animation-delay: 0.6s; }
.line5 { animation-delay: 0.8s; }

.icon {
  width: 20px;
  height: 20px;
  margin-right: 10px;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideIn {
  from {
    transform: translateY(-20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes fadeInUp {
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
