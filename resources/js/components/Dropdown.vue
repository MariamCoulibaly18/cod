<template>
  <div v-if="isDropdownVisible" class="provided">
    <div style="font-weight: bold">Are these expenses provided by your business or a member?</div>
    <button v-for="(provided, index) in provideds" :key="'provided-button-' + index" @click="handleProvidedClick(provided)"
      :class="{'provided-blue': provided.name === 'provided by my business','provided-button': provided.name === 'provided by team' }">
      {{ provided.name }} 
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      provideds: [],
      isDropdownVisible: false,
    };
  },
  created(){
        this.showProvideds();
    },
  methods: {
       //pagination
       changePage(page){
            this.pagination.current_page = page;
        },
    showProvideds() {
            axios.get('/api/provided')
            .then(response => {
                this.provideds = response.data.provideds;
                this.selectedProvided = null; // Réinitialiser la sélection du fournisseur
                // Afficher le modal d'ajout ici
            })
            .catch(error => {
                console.error(error);
            });
        },
        showDropdown() {
            this.isDropdownVisible = !this.isDropdownVisible;
            // this.showAlert = true;
            },
    handleProvidedClick(provided) {
                this.selectedProvided= provided;
                this.loadCategoryProvided();
                this.editMode = false;
                this.form.reset();
                this.isDropdownVisible = false;
                $('#add_modal').modal('show');
            },
  }
};
</script>

<style scoped>
.provided {
  float: right;
  margin-right: 10px;
  margin-top: 3px;
  align-items: center;
  background-color: #DADADA;
  border-radius: 5px;
  border-width: 1px;
  padding:5px; 

}

.provided-button {
  background-color: #559ee8;
  margin-bottom: 10px; 
  padding:5px; 
  border-radius: 5px;
  border-width: 1px;
  border-color: #559ee8;
  color: white;
  margin-right: 5px;

}
.provided-blue{
    background-color: white;
    border-color: white;
    color: #559ee8;
    margin-bottom: 10px; 
    padding: 5px; 
    margin-right: 5px;
    border-radius: 5px;
    border-width: 1px;

}
</style>