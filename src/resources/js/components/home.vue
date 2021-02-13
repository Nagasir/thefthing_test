<template>
    <div>
        <b-container fluid>
            <b-row>
                <b-col md="12">
                    <b-card class="mt-3">
                        <h4 class="card-title">Customer</h4>
                        <b-button variant="primary" to="/add">Add New</b-button>
                        <div class="table-responsive mt-2">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Marital Status</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(customer, index) in customers" :key="customer.id" >
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ customer.name }}</td>
                                    <td>{{ customer.email }}</td>
                                    <td>{{ customer.gender }}</td>
                                    <td>{{ customer.is_married ? 'Married' : 'Single'}}</td>
                                    <td>{{ customer.address }}</td>
                                    <td><b-link :to="{ name: 'detail', params: { id: customer.id }}"><b-icon icon="eye" variant="dark"></b-icon></b-link> &nbsp; <b-link :to="{ name: 'edit', params: { id: customer.id }}"><b-icon icon="pencil"></b-icon></b-link> &nbsp; <b-link  @click="onDelete(customer.id)"><b-icon icon="trash" variant="danger"></b-icon></b-link></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </b-card>
                    <b-overlay :show="busy" no-wrap @shown="onShown">
                        <template #overlay>
                            <div v-if="loading">
                                <div>Loading</div>
                            </div>
                            <div v-else-if="processing" class="text-center p-4 pb-2 bg-danger text-light rounded">
                                <b-icon icon="trash" font-scale="4"></b-icon>
                                <div>Deleting...</div>
                            </div>
                            <div
                                v-else
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
                customers : [],
                busy: true,
                processing: false,
                loading: false,
                counter: 1,
                deleteID: null
            };
        },

        created() {
            this.loadCustomer()
        },

        methods: {
            loadCustomer(){
                this.loading = true;
                axios.get(`customers`)
                .then(response => {
                    this.customers = response.data.result;
                    this.busy = this.loading = false
                })
                .catch(err => {
                    if (err.response) {

                    } else if (err.request) {

                    } else {

                    }
                })
            },
            onShown() {
                if(!this.loading){
                    this.$refs.dialog.focus()
                }
            },
            onDelete(customerId) {
                this.processing = false;
                this.busy = true;
                this.deleteID = customerId
            },
            onCancel() {
                this.busy = false;
                this.deleteID = null;
            },
            onOK() {
                this.processing = true;
                axios.delete(`customer/${this.deleteID}`)
                .then(response => {
                    if(response.status == 200){
                        this.processing = this.busy = false;
                        this.deleteID = null;
                        this.loadCustomer();
                    }
                })
                .catch(err => {
                    if (err.response) {

                    } else if (err.request) {

                    } else {

                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
