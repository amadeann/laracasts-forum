<template>
    <li class="dropdown nav-item" v-if="notifications.length">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="far fa-bell"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
            <li class="dropdown-item" v-for="notification in notifications" :key="notification.data.message">
                <a :href="notification.data.link" @click="markAsRead(notification)">{{ notification.data.message }}</a>
            </li>
        </ul>
    </li>
</template>

<script>
export default {
    data() {
        return {
            notifications: false
        };
    },
    created() {
        axios
            .get("/profiles/" + window.App.user.name + "/notifications/")
            .then(response => (this.notifications = response.data));
    },
    methods: {
        // '/profiles/' . $user->name . '/notifications/' . $user->unreadNotifications->first()->id
        markAsRead(notification) {
            axios.delete(
                "/profiles/" +
                    window.App.user.name +
                    "/notifications/" +
                    notification.id
            );
        }
    }
};
</script>

<style scoped>
.dropdown-toggle::after {
    display: none;
}
</style>
