<template>
  <div>
    <!-- List Products -->
    <ul>
      <li v-for="product in products" :key="product.id">
        {{ product.name }} - {{ product.price }}
        <button @click="deleteProduct(product.id)">Delete</button>
        <button @click="editProduct(product.id)">Edit</button>
      </li>
    </ul>

    <!-- Update Product Form -->
    <div v-if="editingProduct">
      <h2>Edit Product</h2>
      <input type="text" v-model="editedProduct.name" placeholder="Name">
      <input type="number" v-model="editedProduct.price" placeholder="Price">
      <button @click="updateProduct">Update</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      products: [],
      editingProduct: false,
      editedProduct: {
        id: null,
        name: '',
        price: null
      }
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    fetchProducts() {
      axios.get('http://127.0.0.1:8000/v1/product')
        .then(response => {
          this.products = response.data;
        })
        .catch(error => {
          console.error('Error fetching products: ', error);
        });
    },
    deleteProduct(id) {
      axios.delete(`http://127.0.0.1:8000/v1/product/${id}`)
        .then(() => {
          this.fetchProducts();
        })
        .catch(error => {
          console.error('Error deleting product: ', error);
        });
    },
    editProduct(id) {
      axios.get(`http://127.0.0.1:8000/v1/product/${id}`)
        .then(response => {
          this.editedProduct.id = response.data.id;
          this.editedProduct.name = response.data.name;
          this.editedProduct.price = response.data.price;
          this.editingProduct = true;
        })
        .catch(error => {
          console.error('Error fetching product: ', error);
        });
    },
    updateProduct() {
      axios.put(`http://127.0.0.1:8000/v1/product/${this.editedProduct.id}`, this.editedProduct)
        .then(() => {
          this.editingProduct = false;
          this.fetchProducts();
        })
        .catch(error => {
          console.error('Error updating product: ', error);
        });
    }
  }
};
</script>
