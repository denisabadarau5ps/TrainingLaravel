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
                <td>{{ product.price }}</td>
                <td>
                    <button @click="removeFromCart(product.id)">Remove</button>
                </td>
            </tr>
        </table>
        <div class="checkout-details-container">
            <form
                id="checkout"
                @submit.prevent="checkForm"
                method="post"
            >
                <input type="hidden" name="_token" :value="csrf">
                <br>
                <input
                    v-model="name"
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Name"
                >
                <br>
                <span class="errors"> {{ nameError }}</span>
                <br>
                <input
                    v-model="contacts"
                    type="email"
                    id="contacts"
                    name="contacts"
                    placeholder="Contacts"
                >
                <br>
                <span class="errors">{{ contactsError }}</span>
                <br>
                <textarea
                    v-model="comments"
                    id="comments"
                    name="comments"
                    rows="5"
                    placeholder="Comments">
                </textarea>
                <br>
                <span class="errors">{{ commentsError }}</span>
                <br>
                <input
                    type="submit"
                    value="Checkout"
                >
            </form>
        </div>
        <div class="button-container">
            <router-link to="/">
                <button class="btn">Go to index</button>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "Cart",
    data() {
        return {
            products: [],
            name: '',
            contacts: '',
            comments: '',
            nameError: '',
            contactsError: '',
            commentsError: '',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios.get('api/cart').then(response => {
                this.products = response.data.products;
            });
        },
        getImage(product) {
            return 'storage/images/' + product.id + '.' + product.extension;
        },
        removeFromCart(id) {
            axios.post('api/cart', { id }).then(() => {this.getProducts()});
        },
        async checkForm() {
            axios.post(
                'api/checkout',
                {
                    'name': this.name,
                    'contacts': this.contacts,
                    'comments': this.comments,
                })
            .then(() => {
                this.$router.push('/');
            })
            .catch(error => {
                this.nameError = error.response.data.error.name[0];
                this.contactsError = error.response.data.error.contacts[0];
                this.commentsError = error.response.data.error.comments[0];
            });
        },
    }
}
</script>
<style scoped>
    .checkout-details-container {
        width: 15%;
        padding: 10px;
        margin-left: 40%;
    }
    .errors{
        color:red;
    }
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
