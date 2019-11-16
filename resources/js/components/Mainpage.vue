<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="column is-6">
                <h1 class="title is-1">POS</h1>
                <p class="subtitle is-size-6">Simple Cashier System powered by Vue.js and Laravel</p>
                <b-field grouped>
                    <b-field label="Product Barcode" expanded>
                        <b-field>
                            <b-input v-model="barcode" size="is-large" v-on:keyup.enter="getProduct()" expanded></b-input>
                            <p class="control">
                                <button class="button is-primary is-large" @click="getProduct()">Add to cart</button>
                            </p>
                        </b-field>
                    </b-field>
                </b-field>

                <h4 class="title is-4" style="margin-top: 2rem;">Payment Shotcuts</h4>
                <p class="subtitle is-size-6">Help paying have more easier</p>

                <div class="columns is-multiline">
                    <div class="column is-4">
                        <b-field grouped>
                            <b-field label="Money Recieved" expanded>
                                <b-field>
                                    <b-input v-model="moneypaid" size="is-large" expanded></b-input>
                                </b-field>
                            </b-field>
                        </b-field>
                    </div>
                    <div class="column is-4">
                        <b-field label="Explaination">
                            <div class="content">
                                เงินที่ได้ {{ moneypaid }}<br>
                                ราคาของทั้งหมด {{ payAmount }}<br>
                            </div>
                        </b-field>

                    </div>
                    <div class="column is-4">
                        <p class="subtitle is-size-6">Charge ({{ moneypaid }} - {{ payAmount }})</p>
                        <h1 class="title is-1">{{ moneypaid - payAmount }}
                            <b-tag v-if="carts.length == 0" type="is-danger">ไม่มีอะไรอยู่ในตะกร้า!</b-tag>
                            <b-tag v-if="carts.length > 0 && moneypaid == 0" type="is-warning">รอเงินจ่าย!</b-tag>
                            <b-tag v-if="carts.length > 0 && moneypaid > 0" type="is-success">ที่ต้องทอน</b-tag>
                        </h1>
                    </div>
                </div>

                <h4 class="title is-4" style="margin-top: 2rem;">Salable Products</h4>
                <p class="subtitle is-size-6">Most buy in this time!</p>
                <b-table :data="items" :columns="columns" style="margin-top: -1rem;"></b-table>
            </div>
            <div class="column is-6">
                <div class="box" style="height: 100%">
                    <div class="columns">
                        <div class="column is-6">
                            <h4 class="title is-4">ตะกร้าของที่ซื้อ ({{ carts.length || 'ว่างเปล่า' }})</h4>
                            <p class="subtitle is-size-6">Current Items which is calculating...</p>
                        </div>
                        <div class="column is-6 has-text-right">
                            <p class="subtitle"><button class="button is-small is-danger" @click="resetCart()">Reset Cart</button> ราคาสุทธิ</p>
                            <h1 class="title">{{ payAmount }} บาท</h1>
                        </div>
                    </div>

                    <table class="table is-fullwidth">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(cart, index) in carts" :key="cart.barcode">
                                <th>{{ cart.barcode }}</th>
                                <th>{{ cart.name }}</th>
                                <th>{{ cart.price }}</th>
                                <th><b-button type="is-danger" size="is-small" @click="removeFromCart(index)">Remove</b-button></th>
                            </tr>
                            <tr v-if="carts.length == 0">
                                <th col="4">
                                    <h1 class="title" style="margin-top: 3rem;">
                                        Ready for new process..
                                    </h1>
                                    <p class="subtitle">
                                        The cart is empty now!
                                    </p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getAllProduct();
        },
        data() {
            return {
                isEmpty: true,
                barcode: '',
                moneypaid: 0,
                total: 100,
                items: [],
                carts: [],
                columns: [
                    {
                        field: 'product_barcode',
                        label: 'Barcode ID',
                        width: '10',
                    },
                    {
                        field: 'product_name',
                        label: 'Name',
                    },
                    {
                        field: 'product_price',
                        label: 'Price',
                        numeric: true,
                        centered: true,
                    },
                ],
            }
        },
        computed: {
            payAmount: function() {
                var sum = this.carts.reduce(function(accumulate, data) {
                    return accumulate + Number(data.price);
                }, 0);

                return sum.toFixed(2);
            },
        },
        methods: {
            getAllProduct: function() {
                axios.get('api/product').then(response => {
                    this.items = response.data
                })
            },
            getProduct: function() {
                if(this.barcode != '') {
                    axios.get('api/product/' + this.barcode).then(response => {

                        this.carts.push({
                            barcode: response.data.product_barcode,
                            name: response.data.product_name,
                            price: response.data.product_price,
                        })

                        this.$buefy.toast.open({
                            message: 'Barcode: <b>' + response.data.product_barcode + "</b><br>" + response.data.product_name + " Added to cart list!",
                            type: 'is-info',
                            duration: 3000,
                        })

                    })
                }
                this.barcode = ''
            },
            testPut: function() {
                this.carts.push({
                    barcode: '88888888',
                    name: 'Lays Snack',
                    price: 20,
                })
            },
            removeFromCart: function(index) {
                this.$delete(this.carts, index)
            },
            resetCart: function(index) {
                this.carts = []
            },
        }
    }
</script>
