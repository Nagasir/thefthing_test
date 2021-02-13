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
                       {{ alert.message }}
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
                                   placeholder="Enter password"
                                   required
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
                               <b-button type="submit" variant="primary">Save</b-button>
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
        name: "add",
        data() {
            return {
                customer: {
                    name: '',
                    email: '',
                    password: '',
                    gender: 'Male',
                    isMarried: 1,
                    address: ''
                },

                alert: {
                    show: false,
                    message: '',
                    type: ''
                },

                busy:false,
                dismissSecs: 3,
                dismissCountDown: 0,
            }
        },
        methods: {
            onSubmit(event) {
                event.preventDefault();
                this.busy = true;

                axios.post(`customer`, {
                    customer: this.customer
                })
                .then(response => {
                    if(response.status == 201){
                        this.busy = false;
                        this.showAlert(response.data.status.message, "success");
                        this.resetForm();
                    }
                })
                .catch(e => {
                    this.show = false;
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
                this.alert.show = true;
                this.alert.message = message;
                this.alert.type = status;
                this.dismissCountDown = this.dismissSecs

            },

            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },

            resetForm(){
                this.customer.name = '';
                this.customer.email = '';
                this.customer.password = '';
                this.customer.gender = 'Male';
                this.customer.isMarried = '1';
                this.customer.address = ''
            }
        },
    }
</script>

<style scoped>

</style>
