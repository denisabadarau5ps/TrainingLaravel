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
                <router-link :to="linkOrder(order.id)">
                    {{ order.id }}
                </router-link>
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
        this.getOrders();
    },
    methods: {
        getOrders() {
            axios.get('api/orders').then(response => {
                this.orders = response.data.orders;
            });
        },
        linkOrder(id) {
            return '/order/' + id
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
</style>
