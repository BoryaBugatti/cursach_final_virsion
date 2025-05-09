<template>
  <nav class="header">
    <ul class="nav-links">
      <li><RouterLink to="/">Главная страница</RouterLink></li>
      <li><RouterLink to="Lk">Личный кабинет</RouterLink></li>
      <li><RouterLink to="make_order">Заказать вывоз мусора</RouterLink></li>
    </ul>
  </nav>
</template>

<script>
export default {};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.header {
  background-color: #7aaa16;
  padding: 15px 20px;
  display: flex;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  animation: slideDown 0.5s ease-in-out;
}

.nav-links {
  width: 100%;
  list-style: none;
  display: flex;
  justify-content: space-around;
}

.nav-links a {
  color: #ffffff;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s, transform 0.3s;
}

.nav-links a:hover {
  color: #388e3c;
  transform: scale(1.1);
}

@keyframes slideDown {
  from {
    transform: translateY(-20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
</style>
