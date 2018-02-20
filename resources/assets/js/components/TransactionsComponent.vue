<template>
    <div class="container">
        <div class="row">
            <h2 class="text-center">Transactions</h2>
            <h4 class="col-xs-4 col-md-6">Filter:</h4>
            <h4 class="col-xs-8 col-md-6 text-right">Show by:
                <select v-model="formData.showby" name="showby" id="showby" class="form-control inline" @change.prevent="getTransactions('/transactions/filter/?page=1')">
                    <option :value="10" selected>10</option>
                    <option :value="30">30</option>
                    <option :value="50">50</option>
                </select>
            </h4>
            <form action="#" method="post" class="col-xs-12 col-sm-8 col-sm-push-2 col-md-10 col-md-push-0" @submit.prevent="getTransactions('/transactions/filter/?page=1')">
                <div class="row">
                    <div class="form-group col-md-3 text-center">
                        <label>Amount:</label>
                        <input v-model="formData.amount" type="number" class="form-control" id="amount" placeholder="Amount"  step="0.1">
                    </div>
                    <div class="form-group col-md-3 text-center">
                        <label>Date:</label>
                        <date-picker v-model="formData.date" :first-day-of-week="1" format="yyyy-MM-dd" lang="en" width="auto"></date-picker>
                    </div>
                    <div class="form-group col-md-3 text-center">
                        <label>Customer ID:</label>
                        <input v-model="formData.customerId" type="number" class="form-control" id="customer_id" placeholder="Customer ID">
                    </div>
                    <div class="form-group col-md-3 text-center ">
                        <label>Submit</label>
                        <button type="submit" class="btn btn-success form-control">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped table-responsive">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Customer ID</th>
                            <th>Amount</th>
                            <th>Limit</th>
                            <th>Offset</th>
                            <th>Date</th>
                        </tr>
                        <tr v-for="transaction in transactions.data">
                            <td>{{transaction.id}}</td>
                            <td>{{transaction.customerId}}</td>
                            <td>{{transaction.amount}}</td>
                            <td>{{transaction.limit}}</td>
                            <td>{{transaction.offset}}</td>
                            <td>{{transaction.date}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li v-if="transactions.prev_page_url" >
                                <a href="" @click.prevent="prevPage()">
                                    <span>Prev</span>
                                </a>
                            </li>
                            <li v-for="num in transactions.last_page" v-bind:class="[(num == transactions.current_page)?'active':'']">
                                <a href="" @click.prevent="[(num != transactions.current_page)? getPage(num): '']">
                                    <span>{{ num }}</span>
                                </a>
                            </li>
                            <li v-if="transactions.next_page_url">
                                <a href="" @click.prevent="nextPage()">
                                    <span>Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import DatePicker from 'vue2-datepicker'
    import moment from 'moment';

    export default {
        components: { DatePicker },
        data() {
            return {
                transactions: {},
                formData: {
                    showby: 10,
                    amount: '',
                    date: '',
                    customerId: '',
                }
            };
        },
        methods:{
            getTransactions: function (link) {
                if (this.formData.date){
                    this.formData.date = moment(this.formData.date).format('YYYY-MM-DD');
                }
                let url = link+'&showby='+this.formData.showby+'&amount='+this.formData.amount+'&date='+this.formData.date+'&customerId='+this.formData.customerId;
                axios.get(url).then(function (response) {
                    this.transactions = response.data;
                }.bind(this)).catch(function (error) {
                    console.log(error);
                });
            },
            getPage:function (pageNumber) {
                this.getTransactions(this.pageUrl(pageNumber))
            },
            pageUrl:function (pageNumber) {
                return '/transactions/filter/?page='+pageNumber;
            },
            nextPage:function () {
                this.getTransactions(this.transactions.next_page_url)
            },
            prevPage:function () {
                this.getTransactions(this.transactions.prev_page_url)
            },
        },
        mounted: function () {
            this.getTransactions('/transactions/filter?page=1');
        },
        computed: {
            dateFormat: function () {
                if (this.dateinput){
                    this.formData.date = moment(this.dateinput).format('YYYY-MM-DD');
                }
            }
        }
    }
</script>


<style>
    .form-control.inline{
        display: inline-block;
        width: auto;
    }
    .form-group label{
        margin-right: 5px;
    }
    .mx-datepicker{
        width: 100%;
    }
</style>