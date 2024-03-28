<!-- Notifications.vue -->
<template>
    <div>
      <h1>Mes notifications</h1>
      <ul v-if="notifications.length > 0">
        <li v-for="notification in notifications" :key="notification.id">
          {{ notification.message }}
        </li>
      </ul>
      <p v-else>Aucune notification pour l'instant.</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        notifications: []
      };
    },
    mounted() {
      // Charger les notifications de l'utilisateur depuis l'API ou une source de données
      // Exemple avec Axios :
      this.fetchNotifications();
    },
    methods: {
      fetchNotifications() {
        // Faites un appel API pour récupérer les notifications de l'utilisateur
        // par exemple :
        axios.get('/api/notifications').then((response) => {
          this.notifications = response.data;
        });
      }
    }
  };
  </script>
  