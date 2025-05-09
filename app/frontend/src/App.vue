<template>
  <mainheader></mainheader>
  <Header></Header>
  <mainwindow></mainwindow>
  <RouterView></RouterView>
  <mainsection></mainsection>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import Header from "./components/Header.vue";
import mainwindow from './components/mainwindow.vue';
import mainheader from "./components/MainHeader.vue";
import mainsection from "./components/mainsection.vue";
export default{
  components: {
    Header,
    mainwindow,
    mainheader,
    mainsection,
  },
}
</script>
<style scoped>

</style>
