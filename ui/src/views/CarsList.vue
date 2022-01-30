<template>
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Maker</th>
          <th scope="col">Name</th>
          <th scope="col">Model</th>
          <th scope="col">Quantity</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(car, key) in cars" :key="key">
          <th scope="row">{{ key + 1 }}</th>
          <td>{{ car.maker }}</td>
          <td>{{ car.name }}</td>
          <td>{{ car.model }}</td>
          <td>{{ car.quantity }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { cars } from './../api-urls';
export default {
  data() {
    return {
      cars: [],
    };
  },
  async created() {
    try {
      const response = await this.axios.get(cars, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token'),
        },
      });
      this.cars = response.data.data;
    } catch (error) {
      if (error.response.status == 401) {
        localStorage.removeItem('token');
        this.$router.push({ name: 'Login' });
      }
    }
  },
};
</script>
