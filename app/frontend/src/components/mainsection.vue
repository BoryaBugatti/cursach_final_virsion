<template>
    <section class="sec1">
      <div class="card">
        <div class="line1"><p>Наши цели</p></div>
        <div class="line2">
          <div class="left-side">
            <img :src="icon1" alt="#" />
            <p>Чистота во дворах и на улицах нашего города</p>
          </div>
          <div class="center">
            <img :src="icon3" alt="#" />
            <p>Привлечение внимания населения к экологическим проблемам нашего города</p>
          </div>
          <div class="right-side">
            <img :src="icon2" alt="#" />
            <p>Cохранность и защита окружающей среды</p>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  import icon1 from "@/assets/images/free-icon-hurricane-4518666.png";
  import icon2 from "@/assets/images/free-icon-planting-4518686.png";
  import icon3 from "@/assets/images/free-icon-planting-4504567.png";
  
  export default {
    data() {
      return {
        icon1,
        icon2,
        icon3,
      };
    },
  };
  </script>
  
  <style scoped>
  .sec1 {
    margin-top: 3.13vw;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
  }
  
  .card {
    display: flex;
    flex-direction: column;
    border: 2px solid greenyellow;
    border-radius: 10px;
    height: auto;
    width: 90%;
    max-width: 800px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    animation: fadeIn 0.5s ease-in-out;
  }
  
  .line1 {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    margin-top: 0.63vw;
    font-size: 1.5em;
    font-weight: bold;
  }
  
  .line2 {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    padding: 20px;
  }
  
  .left-side, .center, .right-side {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 10px;
  }
  
  img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
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
  