<template>
    <table>
        <tr>
            <th>Product</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Options</th>
        </tr>
        <tr v-for="product in products" :key="product.id">
            <td>
                <img :src="getImage(product)"/>
            </td>
            <td>{{ product.title }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
            <td>
                <button>Delete</button>
                <button>Edit</button>
            </td>
        </tr>
    </table>
</template>

<script>
export default {
    name: "Products",
    data() {
        return {
            products: [],
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios.get('api/products').then(response => {
                this.products = response.data.products;
            });
        },
        getImage(product) {
            return 'storage/images/' + product.id + '.' + product.extension;
        },
    }
}
</script>

<style scoped>
table{
    width: 100%;
    text-align: center;
}
th{
    font-size: 30px;
}
th,td{
    padding: 20px;
    width: 20%;
}
img{
    height: 100px;
    width: 100px;
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
</style>
