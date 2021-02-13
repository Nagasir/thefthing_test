<template>
    <div>
        <b-container>
            <b-row>
                <b-col md="6" offset-md="3">
                    <b-alert
                        :show="dismissCountDown"
                        dismissible fade
                        :variant="alert.type"
                        @dismissed="dismissCountDown=0"
                        @dismiss-count-down="countDownChanged"
                    >
                        {{ alert.message }} ...redirecting in  {{ dismissCountDown }} seconds
                        <b-progress
                            variant="light"
                            :max="dismissSecs"
                            :value="dismissCountDown"
                            height="4px"
                        ></b-progress>
                    </b-alert>
                    <b-overlay :show="busy" rounded="sm">
                    <b-card class="mt-3">
                        <b-form @submit="onSubmit">
                            <b-form-group id="input-group-1" label="Name:" label-for="name">
                                <b-form-input
                                    id="name"
                                    v-model="customer.name"
                                    placeholder="Enter name"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group id="input-group-2" label="Email:" label-for="email">
                                <b-form-input
                                    id="email"
                                    type="email"
                                    v-model="customer.email"
                                    placeholder="Enter email"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group id="input-group-3" label="Password:" label-for="password">
                                <b-form-input
                                    id="password"
                                    type="password"
                                    v-model="customer.password"
                                    placeholder="Ignore or enter password to update"
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group label="Gender:" v-slot="{ ariaDescribedby }">
                                <b-form-radio v-model="customer.gender" :aria-describedby="ariaDescribedby" name="gender" value="Male">Male</b-form-radio>
                                <b-form-radio v-model="customer.gender" :aria-describedby="ariaDescribedby" name="gender" value="Female">Female</b-form-radio>
                            </b-form-group>

                            <b-form-group label="Marital Status:" v-slot="{ ariaDescribedby }">
                                <b-form-radio v-model="customer.isMarried" :aria-describedby="ariaDescribedby" name="is_married" value="1">Married</b-form-radio>
                                <b-form-radio v-model="customer.isMarried" :aria-describedby="ariaDescribedby" name="is_married" value="0">Single</b-form-radio>
                            </b-form-group>

                            <b-form-group label="Address:" label-for="address">
                                <b-form-textarea
                                    id="address"
                                    v-model="customer.address"
                                    placeholder="Your Address"
                                    rows="3"
                                    max-rows="6"
                                    required
                                ></b-form-textarea>
                            </b-form-group>
                            <div class="float-right">
                                <b-button variant="outline-secondary" to="/">Back</b-button>
                                <b-button type="submit" variant="primary">Update</b-button>
                            </div>
                        </b-form>
                    </b-card>
                    </b-overlay>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
    export default {
        name: "edit",
        data() {
            return {
                customer: {
                    name: '',
                    email: '',
                    password: '',
                    gender: '',
                    isMarried: null,
                    address: ''
                },

                alert: {
                    show: false,
                    message: '',
                    type: ''
                },

                busy: true,

                dismissSecs: 3,
                dismissCountDown: 0,
            }
        },
        created() {
            axios.get(`customer/${this.$route.params.id}`)
            .then(response => {
                this.busy = false;
                this.customer.name = response.data.result.name;
                this.customer.email = response.data.result.email;
                this.customer.gender = response.data.result.gender;
                this.customer.isMarried = response.data.result.is_married;
                this.customer.address = response.data.result.address;
            })
            .catch(e => {
                this.errors.push(e)
            })
        },
        methods: {
            onSubmit(event) {
                event.preventDefault();
                this.busy = true;
                axios.put(`customer/${this.$route.params.id}`, {
                    customer: this.customer
                })
                .then(response => {
                    if(response.status == 200){
                        this.busy = false
                        this.showAlert(response.data.status.message, "success");
                    }
                })
                .catch(e => {
                    if (err.response) {
                        this.showAlert(response.data.status.message, "danger");
                    } else if (err.request) {
                        this.showAlert("Check Your Connection", "danger");
                    } else {
                        // anything else
                    }
                })
            },

            showAlert(message, status) {
                this.alert.message = message;
                this.alert.type = status;
                this.dismissCountDown = this.dismissSecs

            },

            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
                if(dismissCountDown == 0){
                    this.$router.push('/')
                }
            },
        },
    }
</script>

<style scoped>

</style>
