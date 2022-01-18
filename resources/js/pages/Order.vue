<template>
   <div class="order-container">
       <h1>Order #{{ order.id }} </h1>
       <h3>Created at: {{ order.created_at }} </h3>
       <table>
           <tr>
               <th>Image</th>
               <th>Title</th>
               <th>Description</th>
               <th>Price</th>
           </tr>
           <tr v-for="product in order.products" :key="product.id">
               <td>
                   <img :src="getImage(product)"/>
               </td>
               <td> {{ product.title }}</td>
               <td> {{ product.description }}</td>
               <td> {{ product.pivot.product_price }}$</td>
           </tr>
       </table>
       <br>
       <h3>Total: {{ order.total }}$</h3>
       <div class="button-container">
           <router-link to="/orders">
               <button class="btn">Go to orders</button>
           </router-link>
       </div>
   </div>
</template>

<script>
export default {
    name: "Order",
    data() {
        return {
            order: [],
        }
    },
    mounted() {
        var id = this.$route.path.split('/')[2];
        this.getOrder(id);
    },
    methods: {
        getOrder(id) {
            axios.get(
                '/api/order/' + id
            )
            .then(response => {
                this.order = response.data.order;
            })
        },
        getImage(product) {
            return '/storage/images/' + product.id + '.' + product.extension;
        },
    }
}
</script>

<style scoped>
    .order-container {
        margin: auto;
        width: 50%;
        border: 2px solid black;
        padding: 30px;
        text-align: center;
    }
    table{
        border-collapse: collapse;
        width:100%;
        border: 1px solid black;
        text-align: center
    }
    tr{
        border-bottom: 1px solid black
    }
    img{
        width: 100px;
        height: 100px;
    }
    button {
        font: bold 15px Arial;
        background-color: #EEEEEE;
        text-decoration: none;
        color: #333333;
        padding: 2px 6px 2px 6px;
        border: 1px solid black;
        margin-top: 10%;
    }
    .button-container {
        width: 80%;
        position: relative;
        margin-top: 5%;
    }
    .btn{
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
    }
</style>
