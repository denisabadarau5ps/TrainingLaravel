<template>
    <div>

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
                <td>{{ product.price }}$</td>
                <td>
                    <button @click="deleteProduct(product.id)">Delete</button>
                    <router-link :to="editLink(product.id)">
                        <button> Edit </button>
                    </router-link>
                </td>
            </tr>
        </table>
        <div class="button-container">
            <router-link :to="addLink()">
                <button class="btn">
                    Add
                </button>
            </router-link>
        </div>
    </div>
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
        deleteProduct(id) {
            axios.post('api/products', {id})
                .then(() => {this.getProducts()});
        },
        editLink(id) {
            return 'product/' + id + '/edit';
        },
        addLink() {
            return 'product/0';
        }
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
