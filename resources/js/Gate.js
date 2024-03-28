
import { store } from './store';

export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.type === 'admin';
    }

    isSuperAdmin() {
        return this.user.type === 'super_admin';
    }

    isResponsible(boutique) {
        return this.isAdmin() && boutique.user_id === this.user.id;
    }

    isLocalStore() {
        return store.getters.currentBoutique.type.name === 'Local';    
    }
    isLivreur() {
        return this.user.type === 'livreur';
    }
    isNull() {
        return !this.user.type || this.user.type.trim() === '' || this.user.type.toLowerCase() === 'null';
    }

 }
    
