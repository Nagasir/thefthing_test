<template>
    <div>
        <b-container fluid>
            <b-row>
                <b-col md="12">
                    <b-card class="mt-3">
                      <h4 class="card-title">Customer</h4>
                        <b-row class="bigger" :no-gutters=true>
                            <b-col><b-button variant="primary" to="/add">Add New</b-button></b-col>
                            <b-col></b-col>
                            <b-col>
                                <b-alert
                                    :show="dismissCountDown"
                                    dismissible fade
                                    :variant="alert.type"
                                    @dismissed="dismissCountDown=0"
                                    @dismiss-count-down="countDownChanged"
                                >
                                    {{ alert.message }}
                                </b-alert>
                            </b-col>
                        </b-row>
                        <b-row class="mb-2" :no-gutters=true>
                            <b-col sm="1" md="1">
                                <b-form-select
                                    v-model="perPage"
                                    :options="pageOptions"
                                >
                                </b-form-select>
                            </b-col>
                            <b-col sm="1" md="1" class="lh2">
                                <span>&nbsp; Per Page</span>
                            </b-col>
                            <b-col sm="1" md="1" offset="6" class="text-right lh2">
                                <span>Search &nbsp;</span>
                            </b-col>
                            <b-col sm="3" md="3">
                                <b-form-input
                                    v-model="filter"
                                    type="search"
                                    placeholder="Search Everywhere"
                                ></b-form-input>
                            </b-col>
                        </b-row>
                        <b-table striped hover
                                 :items="customerProvider"
                                 :fields="fields"
                                 :busy.sync="loading"
                                 :sort-by.sync="sortBy"
                                 :sort-desc.sync="sortDesc"
                                 :per-page="perPage"
                                 :current-page="currentPage"
                                 :filter="filter"
                                 :filter-debounce="750"
                                 ref="table" show-empty>

                            <template #empty="scope">
                                <h5 class="text-center">{{ scope.emptyText }}</h5>
                            </template>
                            <template #emptyfiltered="scope">
                                <h5 class="text-center">{{ scope.emptyFilteredText }}</h5>
                            </template>
                            <template #table-busy>
                                <div class="text-center text-danger my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Loading...</strong>
                                </div>
                            </template>
                            <template #cell(index)="data">
                                {{ data.index + from }}
                            </template>
                            <template #cell(is_married)="data">
                                {{ data.value ? "Married" : "Single" }}
                            </template>
                            <template #cell(action)="data">
                                <b-link :to="{ name: 'detail', params: { id: data.item.id }}"><b-icon icon="eye" variant="dark"></b-icon></b-link> &nbsp;
                                <b-link :to="{ name: 'edit', params: { id: data.item.id }}"><b-icon icon="pencil"></b-icon></b-link> &nbsp;
                                <b-link  @click="onDelete(data.item.id)"><b-icon icon="trash" variant="danger"></b-icon></b-link>
                            </template>
                        </b-table>
                        <b-row>
                            <b-col class="lh2">Showing: {{from}} - {{ from + currentResult - 1 }} from {{total}} data</b-col>
                            <b-col>
                                <b-pagination
                                    v-model="currentPage"
                                    :total-rows="total"
                                    :per-page="perPage"
                                    aria-controls="my-table" class="justify-content-end"
                                ></b-pagination>
                            </b-col>
                        </b-row>
                    </b-card>
                    <b-overlay :show="confirm" no-wrap @shown="onShown">
                        <template #overlay>
                            <div
                                ref="dialog"
                                tabindex="-1"
                                role="dialog"
                                aria-modal="false"
                                aria-labelledby="form-confirm-label"
                                class="text-center p-3"
                            >
                                <p><strong id="form-confirm-label">Are you sure you want to delete this item?</strong></p>
                                <div class="d-flex justify-content-center">
                                    <b-button variant="outline-danger" class="mr-3" @click="onCancel">
                                        Cancel
                                    </b-button>
                                    <b-button variant="outline-success" @click="onOK">OK</b-button>
                                </div>
                            </div>
                        </template>
                    </b-overlay>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>

    export default {
        name: "home",
        data() {
            return {

                fields: [
                    {
                        key: 'index',
                        label: 'No',
                    },
                    {
                        key: 'name',
                        label: 'Name',
                        sortable: true
                    },
                    {
                        key: 'email',
                        label: 'Email',
                        sortable: true
                    },
                    {
                        key: 'gender',
                        label: 'Gender',
                        sortable: true
                    },
                    {
                        key: 'is_married',
                        label: 'Marital Status',
                        sortable: true
                    },
                    {
                        key: 'address',
                        label: 'Address',
                        sortable: true
                    },
                    {
                        key: 'action',
                        label: '',
                        sortable: false
                    },
                ],

                loading: false,
                confirm: false,
                deleteID: null,

                from:1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                total: 0,
                currentPage:1,
                currentResult:0,
                sortBy: '',
                sortDesc: false,
                filter: "",

                alert: {
                    show: false,
                    message: '',
                    type: ''
                },

                dismissSecs: 3,
                dismissCountDown: 0,

            };
        },

        methods: {
            customerProvider(ctx){
                let getQuery = `customers?page=${this.currentPage}&size=${this.perPage}`;
                if( ! _.isEmpty(ctx.sortBy)){
                    if(ctx.sortDesc){
                        getQuery += `&sort=-${ctx.sortBy}`
                    }else{
                        getQuery += `&sort=${ctx.sortBy}`
                    }
                }
                if( ! _.isEmpty(ctx.filter)){
                    getQuery += `&filter[name]=${ctx.filter}&filter[email]=${ctx.filter}&filter[gender]=${ctx.filter}&filter[is_married]=${ctx.filter}&filter[address]=${ctx.filter}`;
                }

                let promise = axios.get(getQuery);
                return promise.then((response) => {
                    this.total = response.data.result.total;
                    this.from = response.data.result.from;
                    this.currentPage = response.data.result.current_page;
                    this.currentResult = response.data.result.data.length;
                    return response.data.result.data;
                }).catch(error => {
                    return []
                });
            },
            onShown() {
                if(this.confirm){
                    this.$refs.dialog.focus()
                }
            },
            onDelete(customerId) {
                this.confirm = true;
                this.deleteID = customerId
            },
            onCancel() {
                this.confirm = false;
                this.deleteID = null;
            },
            onOK() {
                this.confirm = false;
                axios.delete(`customer/${this.deleteID}`)
                .then(response => {
                    if(response.status == 200){
                        this.deleteID = null;
                        this.currentPage = 1;
                        this.showAlert(response.data.status.message, response.data.status.response);
                        this.$refs.table.refresh();
                    }
                })
                .catch(err => {
                    if (err.response) {

                    } else if (err.request) {

                    } else {

                    }
                })
            },
            showAlert(message, status) {
                this.alert.show = true;
                this.alert.message = message;
                this.alert.type = status;
                this.dismissCountDown = this.dismissSecs

            },
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },
        }
    }
</script>

<style scoped>
    .lh2{
        line-height: 2.4;
    }

    .bigger{
        min-height: 66px;
    }
</style>
