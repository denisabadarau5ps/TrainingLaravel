<template>
    <div class="product-container">
        <h1>Product Form</h1>
        <form
            method="post"
            @submit.prevent="submit"
        >
            <input
                v-model="title"
                type="text"
                id="title"
                placeholder="Title"
            >
            <br>
            <span class="errors"> {{ errorTitle }} </span>
            <br>
            <textarea
                v-model="description"
                id="description"
                placeholder="Description"
            >
            </textarea>
            <br>
            <span class="errors"> {{ errorDescription}} </span>
            <br>
            <input
                v-model="price"
                type="number"
                id="price"
                placeholder="Price"
            >
            <br>
            <span class="errors">{{ errorPrice}}</span>
            <br>
            <input type="file" id="file" style="margin-left: 20%;">
            <br>
            <span class="errors">{{ errorFile}}</span>
            <br>
            <input
                type="submit"
                value="Save"
            >
            <br><br>
        </form>
    </div>
</template>

<script>
export default {
    name: "Product",
    data() {
        return {
            product: [],
            title: '',
            description: '',
            price: '',
            file: '',
            errorTitle: '',
            errorDescription: '',
            errorPrice: '',
            errorFile: '',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    mounted() {
        var id = this.$route.path.split('/')[2];
        if (id != 0) {
            this.editProduct(id);
        } else {
            this.addProduct();
        }
    },
    methods: {
        editProduct(id) {
            console.log(id);
            this.product.title = 'Title';
            this.product.description = 'Desc';
            this.product.price = '123';
        },
        addProduct() {
            this.product.title = '';
            this.product.description = '';
            this.product.price = '';
        },
        submit() {
            console.log('submit');
        }
    },
}
</script>

<style scoped>
    .product-container{
        margin: auto;
        width: 30%;
        border: 3px solid black;
        padding: 30px;
        text-align: center;
    }
    .errors{
        color:red;
    }
</style>
