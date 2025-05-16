<template>
     <div>
       <h1>Детали заказа №{{ orderId }}</h1>
     </div>
</template>

<script>
   export default {
     data() {
       return {
         orderId: this.$route.params.id 
       };
     },
   };
</script>
