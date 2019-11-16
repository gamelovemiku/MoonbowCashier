<template>
    <div class="container">
        <div class="columns is-mobile is-centered">
            <div class="column is-8">
                <div class="is-primary">
                    <h1 class="title is-1">Add Product</h1>
                    <p class="subtitle is-size-6">Add products in system.</p>
                    <b-field label="Barcode" expanded>
                        <b-field>
                            <b-input v-model="add.barcode" size="is-large" expanded></b-input>
                        </b-field>
                    </b-field>
                    <b-field label="Product Name">
                        <b-input v-model="add.name" size="is-large" expanded></b-input>
                    </b-field>
                    <b-field label="Product Price">
                        <b-input v-model="add.price" size="is-large" expanded></b-input>
                    </b-field>
                    <p class="control">
                        <button class="button is-primary is-large" @click="saveProduct()">Add {{ add.name }}</button>
                    </p>
                </div>

                <div class="is-primary" style="margin-top: 24rem; margin-bottom: 16rem">
                    <h1 class="title is-1">Edit Product</h1>
                    <p class="subtitle is-size-6">Edit products in system.</p>
                    <b-field label="Search by barcode" expanded>
                        <b-field>
                            <b-input v-model="edit.barcode" size="is-large" v-on:keyup.enter="getProduct()" expanded></b-input>
                            <p class="control">
                                <button class="button is-primary is-large" @click="getProduct()">Search</button>
                            </p>
                        </b-field>
                    </b-field>

                    <hr>
                    <h4 class="title is-4">Edit Area</h4>
                    <p class="subtitle is-size-6">Barcode: {{ edit.barcode || 'No selected' }}</p>
                    <b-field label="Product Name">
                        <b-input v-model="edit.name" size="is-large" expanded></b-input>
                    </b-field>
                    <b-field label="Product Price">
                        <b-input v-model="edit.price" size="is-large" expanded></b-input>
                    </b-field>
                    <p class="control">
                        <button class="button is-primary is-large" @click="saveEditedProduct()">Save</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {},
        data() {
            return {
                add: {
                    barcode: '',
                    name: '',
                    price: '',
                },
                edit: {
                    barcode: '',
                    name: '',
                    price: '',
                },
            }
        },
        computed: { },
        methods: {
            getProduct: function() {
                if(this.barcode != '') {
                    axios.get('api/product/' + this.edit.barcode).then(response => {

                        this.edit.barcode = response.data.product_barcode
                        this.edit.name = response.data.product_name
                        this.edit.price = response.data.product_price

                        this.$buefy.toast.open({
                            message: 'Barcode: <b>' + response.data.product_barcode + "</b><br>" + response.data.product_name + " Added to cart list!",
                            type: 'is-info',
                            duration: 3000,
                        })

                    })
                }
                this.edit.barcode = ''
                this.edit.name = ''
                this.edit.price = ''
            },
            saveProduct: function() {
                axios.post('api/product/addnew', {

                    barcode: this.add.barcode,
                    name: this.add.name,
                    price: this.add.price,
                })

                this.$buefy.toast.open({
                    message: 'Added',
                    type: 'is-dark'
                })

                this.add.barcode = ''
                this.add.name = ''
                this.add.price = ''
            },
            saveEditedProduct: function() {
                axios.post('api/product/editproduct', {

                    barcode: this.edit.barcode,
                    name: this.edit.name,
                    price: this.edit.price,

                })

                this.$buefy.toast.open({
                    message: 'Edited',
                    type: 'is-info',
                    duration: 3000,
                })

                this.edit.barcode = ''
                this.edit.name = ''
                this.edit.price = ''

            },
        }
    }
</script>
