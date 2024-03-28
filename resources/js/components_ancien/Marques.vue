<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3" >
                <div class="d-flex justify-content-between">
                    <h1 >Marques</h1>
                    <a class="btn btn-light h-50 w-10 mt-2" @click="addModal"  style="color: #01356F;" >
                        Nouveau <i class="ti ti-plus"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-8 mt-5 marque-wrapper">
                <div v-for="marque in marques" :key="marque.id" class=" marque-container" style="max-width: 100%;">
                    <div style="display: flex;">
                        <img :src="marque.logo"  alt="logo" style="width: 80px; height: 80px; margin-right: 1rem;"  />
                        <h1 class="align-middle">{{ marque.name }}</h1>
                    </div>
                    <div >
                        <p class="description">{{ marque.description }}</p>
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-primary h-50 w-10 mt-2 ms-5" style="height: 40px;width: 150px;" @click="editModal(marque)">
                                <i class="ti ti-edit"></i>
                                Modifier
                            </a>
                            <a class="btn btn-danger mt-2 ms-5" style="height: 40px;width: 150px;" @click="deleteMarque(marque.id)" >
                                <i class="ti ti-trash-x"></i>
                                Supprimer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- bootstrap modal for create and edit -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode">Ajouter Marque</h5>
                    <h5 class="modal-title" v-show="editMode">Modifier Marque</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeAddMarque()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateMarque() : createMarque()">
                    <div class="modal-body">
                        <div class="container">   
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" id="name" v-model="form.name" placeholder="Enter Name">
                                </div>                 
                                <div class="col-md-12">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" v-model="form.description" placeholder="Enter Description"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="logo">Logo</label>
                                    <input type="text" id="logo" class="form-control" v-model="form.logo" placeholder="Enter Logo URL">
                                </div>              
                            </div>                             
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="closeAddMarque()">Fermer</button>
                        <button type="submit" class="btn btn-light" v-show="!editMode">Creer</button>
                        <button type="submit" class="btn btn-info" v-show="editMode">Modifier</button>
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
                marques: [],
                editMode: false,
                form : new Form({
                    id: '',
                    name: '',
                    description: '',
                    logo: '',
                }),
            }
        },
        mounted(){
            this.loadMarques();
        },
        methods:{
            loadMarques(){
                axios.get('/api/marque')
                .then(({data}) => (this.marques = data.data))
                .catch(({response}) => console.log(response.data));
            },
            addModal(){
                this.editMode = false;
                this.form.reset();
                $('#modal').modal('show');
            },
            editModal(marque){
                this.editMode = true;
                this.form.reset();
                this.form.fill(marque);
                $('#modal').modal('show');
            },
            createMarque(){
                this.form.post('/api/marque')
                .then((response) => {
                $('#modal').modal('hide');
                Swal.fire(
                    'Good job!',
                    'Marque added successfully!',
                    'success'
                );
                console.log(response.data);
                this.loadMarques();
                })
                .catch(({response}) => {
                console.log(response.data);
                });
            },
            closeAddMarque(){
                $('#modal').modal('hide');
            },
            updateMarque(){
                this.form.put(`/api/marque/${this.form.id}`)
                .then(() => {
                $('#modal').modal('hide');
                Swal.fire(
                    'Good job!',
                    'Marque updated successfully!',
                    'success'
                );
                this.loadMarques();
                })
                .catch(({response}) => {
                this.$toast.error(response.data.message);
                });
            },
            deleteMarque(id){
                 //Swal confirm
                 Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b3f5c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/marque/${id}`)
                    .then(() => {
                    this.loadMarques();
                    Swal.fire(
                        'Deleted!',
                        'Type has been deleted.',
                        'success'
                    )
                    })
                    .catch(({response}) => {
                    console.log(response.data);
                    });
                }
                })
            }
        }

    }
</script>


<style scoped>
    .description {
        white-space: pre-wrap;
        text-align: left;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .marque-container {
        border: 1px solid #e2e8f0;
        border-radius: 0.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .spinner-container {
    position: fixed;
    top: 43%; /* Ajustez cette valeur pour centrer verticalement */
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999; /* Assurez-vous que le spinner est au-dessus de tout le reste */
    background-color: rgba(255, 255, 255, 0.7); /* Un arrière-plan semi-transparent pour le contraste */
}
</style>