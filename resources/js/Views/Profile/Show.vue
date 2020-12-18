<template>
    <div>
        <update-profile-information-form @updated="fetchUser" :user.sync="user"></update-profile-information-form>

        <section-border></section-border>

        <update-password-form></update-password-form>

        <section-border></section-border>

        <two-factor-authentication-form @updated="fetchUser" :user.sync="user"></two-factor-authentication-form>

        <section-border></section-border>

        <signout-other-browser-sessions-form @updated="fetchUser" :sessions="user.sessions"></signout-other-browser-sessions-form>

        <section-border></section-border>

        <delete-user-form></delete-user-form>
    </div>
</template>

<script>
    import axios from 'axios';
    import FetchData from '@/Components/Base/FetchData';
    import DeleteUserForm from '@/Views/Profile/DeleteUserForm';
    import SignoutOtherBrowserSessionsForm from '@/Views/Profile/SignoutOtherBrowserSessionsForm';
    import TwoFactorAuthenticationForm from '@/Views/Profile/TwoFactorAuthenticationForm';
    import UpdatePasswordForm from '@/Views/Profile/UpdatePasswordForm';
    import UpdateProfileInformationForm from '@/Views/Profile/UpdateProfileInformationForm';
    import ApiTokenManagement from '@/Views/API/ApiTokenManagement';

    export default {
        props: ['data'],

        components: {
            FetchData,
            DeleteUserForm,
            SignoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,
            ApiTokenManagement,
        },

        created() {
            this.fetchUser();
        },

        data() {
            return {
                user: this.data
            }
        },

        methods: {
            async fetchUser() {
                await axios.get(route('profile.show')).then(({ data }) => this.user = data);
            }
        }
    }
</script>
