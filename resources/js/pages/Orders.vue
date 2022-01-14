<template>
    <table>
        <tr>
            <th>NO.</th>
            <th>Customer name</th>
            <th>Contact</th>
            <th>Comments</th>
            <th>Summed price</th>
        </tr>
        <tr v-for="order in orders" :key="order.id">
            <td>
                <a href="/">{{order.id}}</a>
            </td>
            <td> {{order.customer.name}} </td>
            <td> {{order.customer.contacts}} </td>
            <td> {{order.customer.comments}} </td>
            <td> {{order.total}} $ </td>
        </tr>
    </table>
</template>

<script>
export default {
    name: "Orders",
    data() {
        return {
            orders: [],
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios.get('api/orders').then(response => {
                this.orders = response.data.orders;
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
