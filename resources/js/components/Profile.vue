<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="margin-right: 100px;">
                <div>
                    <h4 class="fw-bold text-center">Mon Profil</h4>
                </div>
                <div class="profile-image" style="margin-left: 131px;margin-top: 19px;">
                    <div class="bg-gray" style="border-radius: 50%;">
                        <input type="file" id="fileInput" accept="image/*" @change="onFileChange" ref="fileInput" style="display: none">
                        <img style="border-radius: 50%;" alt="User image" :src="getImage" />
                    </div>
                    <div v-if="isEdit" class="d-flex flex-column ms-3">
                        <button  @click="chooseImage" class="btn  border rounded-pill" type="button" style="background: var(--bs-indigo);color: white;">changer la photo</button>
                        <button  @click="deleteImage" class="btn btn-light border-1 border rounded-pill" :disabled="form.image === 'profile.jpg'" type="button" style="color: var(--bs-btn-active-color);background: var(--bs-btn-bg);margin-top: 13px;">
                            <i class="far fa-trash-alt text-danger me-2"></i>
                            supprimer
                        </button>
                    </div>
                </div>
            </div>
            <form @submit.prevent>
                <div style="margin-top: 20px;">
                   <div style="width: 87%;margin-top: 8px;">
                    <label for="nom" class="form-label form-label">Nom et Prenom</label>
                        <div class="input-group">
                            <input class="form-control" :class="{nomClass,'text-center':!isEdit}"   :disabled="!isEdit" type="text" name="nom" id="nom" v-model="form.name" required/>
                        </div>
                        <span v-show="validationErrors.nomErr" style="color:red">{{ validationErrors.nomErr }}</span>
                   </div>
                    <div style="width: 87%;margin-top: 8px;">
                        <label for="email" class="form-label form-label">Adresse Email</label>
                        <div class="input-group" style="width: 100%;">
                            <input class="form-control" :class="{emailClass,'text-center':!isEdit}"   :disabled="!isEdit"  type="text" name="email" id="email" v-model="form.email" required />
                        </div>
                        <span v-show="validationErrors.emailErr" style="color:red">{{ validationErrors.emailErr }}</span>
                    </div>
                    <div style="width: 87%;margin-top: 8px;">
                        <label for="password" class="form-label form-label">Mot de passe</label>
                        <div class="input-group" style="width: 100%;">
                            <input class="form-control" :class="passwordClass"   :disabled="!isEdit" type="password" name="password" id="password" v-model="form.password" />
                        </div>
                        <span v-show="validationErrors.passwordErr"  style="color:red">{{ validationErrors.passwordErr }}</span>
                    </div>
                    <div style="width: 87%;margin-top: 8px;">
                        <label for="confirmation_password"  class="form-label form-label">Confirmer le Mot de Passe</label>
                        <div class="input-group" style="width: 100%;">
                            <input class="form-control" :class="confirmation_passwordClass"   :disabled="!isEdit" type="password" name="confirmation_password" id="confirmation_password" v-model="form.confirmation_password" />
                        </div>
                        <span v-show="validationErrors.confirmation_passwordErr" style="color:red">{{ validationErrors.confirmation_passwordErr }}</span>
                    </div>
                    <div class="d-flex justify-content-center" style="margin-top: 20px;">
                        <button v-show="isEdit" class="btn btn-success btn-sm" @click="SubmitForm" style="margin-right: 10px;">
                            <i class="fas fa-check"></i>
                            Valider
                        </button>
                        <button v-show="isEdit" class="btn btn-danger btn-sm" style="margin-right:100px" @click="cancelEdit">
                            <i class="fas fa-times"></i>
                            Annuler
                        </button>
                        <button v-show="!isEdit" class="btn btn-info btn-sm" type="button" style="margin-right:100px" @click.prevent="isEdit = true" >
                            <i class="fas fa-edit"></i>
                            Modifier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import Echo from 'laravel-echo';

    export default {
        data() {
            return {
                form : new Form({
                    id: '',
                    name: '',
                    image:'',
                    email: '',
                    password: '',
                    confirmation_password: '',
                    
                }),
                //previewImage: '',
                selectedFile: null,
                validationErrors : {
                    nomErr:null,
                    emailErr:null,
                    passwordErr:null,
                    confirmation_passwordErr:null
                },
                isEdit: false,
            }
        },
        // mounted() {
        //     Echo.channel('profile.' + this.$root.user.id)
        //         .listen('ProfileUpdated', (event) => {
        //             // Mettez à jour l'image de profil dans le composant
        //             this.selectedFile = null; // Effacez le fichier sélectionné
        //             this.form.image = event.user.image; // Mettez à jour le chemin de l'image
        //         });
        // },
        methods: {
            SubmitForm() {
                //if password is not empty but confirmation password is empty
                if(this.form.password && !this.form.confirmation_password){
                    this.validationErrors.confirmation_passwordErr = "Veuillez confirmer votre mot de passe";
                    return;
                }
                if(this.validationErrors.confirmation_passwordErr){
                    //after we can show an error message
                    return;
                }

                this.$Progress.start()
                this.form.put('/api/profile')
                .then(response => {
                    this.$Progress.finish();
                    console.log(response.data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile mis à jour avec succès'
                    });
                     // Réinitialiser les champs de mot de passe et de confirmation de mot de passe
                    this.form.password = ''; // Réinitialiser le champ mot de passe à une chaîne vide
                    this.form.confirmation_password = ''; // Réinitialiser le champ de confirmation à une chaîne vide
                    this.isEdit=false;
                    //reload the page
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error);
                })
            },
            loadProfile(){
                /*axios.get('/api/profile')
                .then(response => {
                    //fill the form with the data,with method fill
                    this.form.fill(response.data);
                    if(response.data.profile){
                        this.previewImage = response.data.profile;
                    }
                    //console.log(response.data);
                })
                .catch(error => {
                    //console.log(error);
                })*/

                this.form.fill(window.user);
            },

            chooseImage() {
                this.$refs.fileInput.click();
            },
            onFileChange(event) {
                this.selectedFile = event.target.files[0];
                if (!this.selectedFile) {
                    return;
                }
                //this.previewImage = URL.createObjectURL(this.selectedFile);
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.form.image = e.target.result;
                };
                reader.readAsDataURL(this.selectedFile);
            },
            deleteImage() {
                this.form.image = 'profile.jpg';
                this.selectedFile = null;
            },
            cancelEdit(){
                this.isEdit = false;
                this.selectedFile = null;
                this.loadProfile();
            }
        },
        created() {
            // currentUser
            this.currentUser = window.user;
            console.log(this.currentUser);
            //load users
            this.loadProfile();
        },
        computed:{
            getImage(){
                if(this.selectedFile)
                    return URL.createObjectURL(this.selectedFile);    
                return '/images/profile/'+this.form.image;
            },
            nomClass(){
                if(this.form.name === undefined || this.form.name == '' || !this.isEdit)
                    return '';
                if(this.validationErrors.nomErr)
                    return 'input-error';
                return 'input-valid';
            },
            emailClass(){
                if(this.form.email === undefined || this.form.email == '' || !this.isEdit)
                    return '';
                if(this.validationErrors.emailErr)
                    return 'input-error';
                return 'input-valid';
            },
            passwordClass(){
                if(this.form.password === undefined || this.form.password == '')
                    return '';
                if(this.validationErrors.passwordErr)
                    return 'input-error';
                return 'input-valid';
            },
            confirmation_passwordClass(){
                if(this.form.confirmation_password === undefined || this.form.confirmation_password == '')
                    return '';
                if(this.validationErrors.confirmation_passwordErr)
                    return 'input-error';
                return 'input-valid';
            }
        },
        watch:{
            'form.name': function (val) {
                //regex pour verifier le nom
                let regex = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
                if ( !val || regex.test(val)) {
                    this.validationErrors.nomErr = null;
                } else {
                    this.validationErrors.nomErr = "Le nom doit contenir que des lettres";
                }
            },
            'form.email': function(val){
                //regex pour verifier l'email
                let regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
                if ( !val || regex.test(val)) {
                    this.validationErrors.emailErr = null;
                } else {
                    this.validationErrors.emailErr = "L'email n'est pas valide";
                }
            },
            'form.password':function(val){
                //minimum 8 caracteres
                let regex = /^.{8,}$/;
                if ( !val || regex.test(val)) {
                    this.validationErrors.passwordErr = null;
                } else {
                    this.validationErrors.passwordErr = "Le mot de passe doit contenir au moins 8 caracteres";
                }
            },
            'form.confirmation_password':function(val){
                if ( !val || val == this.form.password) {
                    this.validationErrors.confirmation_passwordErr = null;
                } else {
                    this.validationErrors.confirmation_passwordErr = "Les mots de passe ne sont pas identiques";
                }
            }    
        }
    }
</script>

<style scoped>
.input-error{
    border: 1px solid red;
}
.input-valid{
    border: 1px solid green;
}

.valid-btn{
    margin-top: 20px;
    width: 100px;
    background:green;
}

.profile-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-left: 0 !important;
    margin-top: 20px !important;
}
.profile-image img {
    width: 130px;
    height: 130px;
}
.profile-image button {
    margin-top: 10px;
}
</style>
