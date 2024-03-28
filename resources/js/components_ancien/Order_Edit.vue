<template>
    <div class="container-fluid">
        <div class="row justify-content-center ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                        <h3>Modifier Commande</h3>
                    </div>
                    <form action="" @submit.prevent="editOrder">
                        <div class="card-body">
                            <div class="row ">
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label for="client">Client : </label>
                                    <select class="form-control" id="client" v-model="form.client.id" >=
                                        <option value="" selected>-- Choisir un client --</option>
                                        <option v-for="client in clients" :key="client.id" :value="client.id">
                                            {{ client.first_name }} {{ client.last_name }}
                                        </option>
                                    </select>
                                </div> 
                                <!-- validation error-->
                                <span class="text-danger" v-if="validationErrors.client">
                                    {{ validationErrors.client }}
                                </span>
                            </div>   
                            <!-- email of the client-->
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label for="email">Email : </label>
                                    <input type="text" class="form-control" id="email" disabled v-model="form.client.email" placeholder="Email">
                                </div>
                            </div>
                       </div>
                       <!-- phone & adress of the client-->
                       <div class="row">
                           <div class="col col-md-6">
                               <div class="form-group">
                                   <label for="adress">Adresse : </label>
                                   <input type="text" class="form-control" id="adress" disabled v-model="form.client.adress" placeholder="Adresse">
                               </div>
                           </div>
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone : </label>
                                    <input type="text" class="form-control" id="phone" disabled v-model="form.client.phone" placeholder="Phone">
                                </div>
                            </div>
                        </div>
                        <!-- livreur & status of the order -->
                        <div class="row">
                            <!-- status of the order -->
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label for="status">Status : </label>
                                    <select class="form-control" id="status" v-model="form.status" >
                                        <option v-for="(status, index) in statuses" :key="index" :value="status" :selected="status == form.status">
                                            {{ status }}
                                        </option>
                                    </select>       
                                </div>
                                <!-- validation error-->
                                <span class="text-danger" v-if="validationErrors.status">
                                    {{ validationErrors.status }}
                                </span>
                            </div>
                        </div>

                       <!-- products -->
                       <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product">Produit : </label>
                                    <select class="form-control" id="product" v-model="product.id" >
                                        <option value="" selected>-- Choisir un produit --</option>
                                        <option v-for="pdt in products_list" :key="pdt.id" :value="pdt.id">
                                            {{ pdt.name }}
                                        </option>
                                    </select>
                                </div>
                                <!-- validation error-->
                                <span class="text-danger" v-if="validationErrors.products">
                                    {{ validationErrors.products }}
                                </span>
                            </div>
                            <!-- price of the product -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Prix : </label>
                                    <input type="number" class="form-control" id="price" v-model="product.price" disabled placeholder="Prix">
                                </div>
                            </div>
                            <!-- quantity of the product -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quantity">Quantité : </label>
                                    <input type="number" min="1" class="form-control" :class="[quantityClass]" id="quantity" v-model="product.quantity" placeholder="Quantité" :disabled="product.id == ''">
                                </div>
                            </div>
                            <!-- add product to the list -->
                            <div class="col-md-1">
                                <br/>
                                <a class="btn btn-success mt-1 w-100" @click="addProduct">
                                    <i class="fa fa-plus white" ></i>
                                </a>
                            </div>
                       </div>
                        <!-- list of products -->
                        <div class="row" v-if="form.products.length > 0">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Produit</th>
                                            <th>Prix</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="max-height: 100px; overflow-y: auto;" >
                                        <tr v-for="product in paginatedLinesItems" :key="product.id">
                                            <td>{{ product.name }}</td>
                                            <td>{{ product.price | prix }}</td>
                                            <td>{{ product.quantity }}</td>
                                            <td>{{ product.price * product.quantity | prix }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger" @click="deleteProduct(product)">
                                                    <i class="ti ti-trash-x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!-- total -->
                                    <tfoot class="bg-info">
                                        <tr>
                                            <td colspan="3" class="text-right">Total</td>
                                            <td colspan="2">{{ form.total | prix }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- Paginations-->
                                <div v-if="form.products.length > 0" class="row">
                                    <div class="col-md-12">
                                        <nav >
                                        <ul class="pagination">
                                            <li class="page-item" :class="{ disabled: lineItemsPagination.currentPage === 1 }">
                                            <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(lineItemsPagination.currentPage - 1)">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            </li>
                                            <li class="page-item" v-for="page in lineItemsPagination.totalPages" :key="page" :class="{ active: page === lineItemsPagination.currentPage }">
                                            <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                            </li>
                                            <li class="page-item" :class="{ disabled: lineItemsPagination.currentPage === lineItemsPagination.totalPages }">
                                            <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(lineItemsPagination.currentPage + 1)">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                            </li>
                                        </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- card footer -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger" @click="resetForm">
                                <i class="fa fa-times"></i>
                                Annuler
                            </button>
                            <button class="btn btn-success" type="submit" :disabled="isSubmitDisabled">
                                <i class="fa fa-check"></i>
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
        data() {
            return {
                clients: [],
                products: [],
                statuses: [ 'pending','processing','on-hold','completed','canceled','refunded'],
                product:{
                    id: '',
                    name: '',
                    price: 0,
                    quantity: 0,
                },
                form: new Form({
                    client: {
                        id: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        phone: '',
                        adress:''
                    },
                    products: [],//I want to specify structure of products array
                    status: 'processing',
                    total: 0.0,
                }),
                store: null,
                validationErrors:{
                    client: '',
                    products: '',
                    status: '',
                },
                lineItemsPagination: {
                    currentPage: 1,
                    perPage: 3,
                    totalPages: 0,
                    /*totalOrders: 0,
                    pages: [],*/
                },
                quantityClass: '',
            }
        },
        mounted() {
            if(!this.$store.getters.currentBoutique && !!this.$gate.isLocalStore() && !this.$gate.isSuperAdmin() && !this.$gate.isResponsible(this.$store.getters.currentBoutique)){
                this.$router.push('/404');
                return;
            }
            
            if(!this.$route.query.order){
                //push him back to the list if the order doesn't exist
                this.$router.push({name: 'orders'});
                return;
            }
            this.store = this.$store.getters.currentBoutique.id;
            this.form.id = this.$route.query.order;
            
            console.log(this.store);
            console.log(this.form.id);
            this.loadClients();
            //this.loadOrder();
            this.loadProducts();
        },
        computed:{
            products_list(){
                let filtered = Object.assign([], this.products);
                filtered = filtered.filter(product => product.quantity > 0);
                //I want return only products that havn't been added to the list by id
                this.form.products.forEach(pdt => {
                    filtered = filtered.filter(product => product.id != pdt.id);
                });
                return filtered;
            },
            isSubmitDisabled(){
                return this.form.products.length == 0 || this.form.total == 0.0 || this.form.client.id == ''  || this.form.status == '';
            },
            paginatedLinesItems(){
                if(this.form.products === undefined || this.form.products.length == 0) {
                    this.lineItemsPagination.totalPages = 0;
                    return;
                }

                this.lineItemsPagination.totalPages = Math.ceil(this.form.products.length / this.lineItemsPagination.perPage) ;
                const index = (this.lineItemsPagination.currentPage - 1) * this.lineItemsPagination.perPage;
                return this.form.products.slice(index, index + this.lineItemsPagination.perPage);
            }
            
        },
        methods:{
            //pagination
            changePage(page) {
                this.lineItemsPagination.currentPage = page;
            },
            //
            loadOrder(){
                axios.get(`/api/order/${this.store}/${this.form.id}`)
                    .then(({data}) => {
                        this.form.fill(data);
                        console.log(data);
                    })
                    .catch(error => {
                        //swal to tell him that there is no order with this id
                        Swal.fire({
                            title: 'Erreur',
                            text: 'Cette commande n\'existe pas',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            this.$router.push({name: 'orders'});
                        });

                        console.log(error);
                    })
            },
            loadClients() {
               axios.get(`/api/customer/${this.store}`)
                    .then(response => {
                        console.log(response.data);
                        response.data.forEach(client => {
                            this.clients.push({
                                id: client.id,
                                first_name: client.billing.first_name,
                                last_name: client.billing.last_name,
                                email: client.email,
                                phone: client.billing.phone,
                                adress: client.billing.address_1,
                            });
                        });
                    }).then(() => {
                        this.loadOrder();
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            loadProducts() {
                axios.get(`/api/product/${this.store}`)
                    .then(response => {
                        console.log(response.data);
                        response.data.forEach(product => {
                            if(product.stock_status == 'instock' && product.stock_quantity > 0 && product.status == 'publish') {
                                this.products.push({
                                    id: product.id,
                                    name: product.name,
                                    price: product.price,
                                    quantity: product.available_quantity,
                                });
                            }
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            addProduct(){
                if(this.product.id == '' || this.quantityClass != '' || this.product.quantity <= 0){
                    let message ='';
                    if(this.product.id == ''){
                        message += 'Veuillez choisir un produit';
                    }
                    if(this.quantityClass != ''){
                        message += 'Veuillez saisir une quantité valide';
                    }
                    if(this.product.quantity <= 0){
                        message += 'Veuillez saisir une quantité valide';
                    }

                    Swal.fire(
                        'Error!',
                        message,
                        'error'
                    );
                    return;
                }

                let pdt = Object.assign({}, this.product);
                this.form.products.push(pdt);
                this.form.total += pdt.price * pdt.quantity;

                if(this.validationErrors.products != '')
                    this.validationErrors.products = '';
                
            },
            deleteProduct(product){
                let index = this.form.products.indexOf(product);
                this.form.products.splice(index, 1);
                this.form.total -= product.price * product.quantity;
                //change quantity in products list
                let pdt = this.products.find(p => p.id == product.id);
                pdt.quantity += product.quantity;

            },
            resetForm(){
                this.form.products = [];
                this.form.total = 0.0;
                this.product = {};
                this.loadOrder();
                this.form.reset();
                this.$router.push({name: 'orders',query: {store: this.form.store} });

            },
            editOrder(){
                this.form.store = this.store;
                this.$Progress.start();
                this.form.put(`api/order/${this.form.id}`)
                    .then(response => {
                        this.resetForm();
                        console.log(response.data);
                        this.$Progress.finish();
                        this.validationErrors = {};
                        Swal.fire(
                            'Success!',
                            'Order created successfully!',
                            'success');
                        delete this.form.store;
                        //redirect to orders page
                        this.$router.push({name: 'orders',query: {store: this.form.store} });
                    })
                    .catch(error => {
                        console.log(error.response.data);
                        this.$Progress.fail();
                        if(error.response.status == 422){
                            if(error.response.data.errors['client'])
                                this.validationErrors.client = error.response.data.errors['client.id'][0];
                            else
                                this.validationErrors.client = '';
                            if(error.response.data.errors['products'])
                                this.validationErrors.products = error.response.data.errors['products'][0];
                            else
                                this.validationErrors.products = '';
                            //this.validationErrors.status = error.response.data.errors['status'][0];
                        }
                    });

            },
        },
        watch:{
            'form.client.id':function(){
                if(this.form.client.id){
                    let client = this.clients.find(client => client.id == this.form.client.id);
                    this.form.client.first_name = client.first_name;
                    this.form.client.last_name = client.last_name;
                    this.form.client.email = client.email;
                    this.form.client.phone = client.phone;
                    this.form.client.adress = client.adress;
                }else{
                    this.form.client.first_name = '';
                    this.form.client.last_name = '';
                    this.form.client.email = '';
                    this.form.client.phone = '';
                    this.form.client.adress = '';
                }
            },
            'product.id':function(){
                if(this.product.id){
                    let product = this.products.find(product => product.id == this.product.id);
                    this.product.name = product.name;
                    this.product.price = product.price;
                    this.product.quantity = 1;
                }else{
                    this.product= {};
                }
            },
            'product.quantity':function(){
                if(this.product.id){
                    let product = this.products.find(product => product.id == this.product.id);
                    //console.log(product.quantity + ' ' + this.product.quantity);
                    if(this.product.quantity > product.quantity){
                        this.quantityClass = 'is-invalid';
                    }else{
                        this.quantityClass = '';
                    }
                }
            },

        }

    }
</script>

<style scoped>

.is-invalid {
    color:red;
}

</style>