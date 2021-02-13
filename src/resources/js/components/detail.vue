<template>
    <div>
        <b-container>
            <b-row>
                <b-col md="6" offset-md="3">
                    <b-overlay :show="busy" rounded="sm">
                    <b-card class="mt-3">
                        <b-form>
                            <b-form-group id="input-group-1" label="Name:" label-for="name">
                                <b-form-input
                                    id="name"
                                    v-model="customer.name"
                                    readonly
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group id="input-group-2" label="Email:" label-for="email">
                                <b-form-input
                                    id="email"
                                    type="email"
                                    v-model="customer.email"
                                    readonly
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group id="input-group-3" label="Password:" label-for="password">
                                <b-form-input
                                    id="password"
                                    type="password"
                                    v-model="customer.password"
                                    readonly
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
                                    readonly
                                ></b-form-textarea>
                            </b-form-group>
                            <div class="float-right">
                                <b-button variant="outline-secondary" to="/">Back</b-button>
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

                busy: true,
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

            })
        },
    }
</script>

<style scoped>

</style>
