function users_table(el) {
    return {
        element: el,
        users: null,
        form_params: {
            show: false,
            user: null
        },
        init() {
            this.refresh_users_data();
        },
        refresh_users_data() {
            fetch('/users.php')
                .then(res => res.json())
                .then(data => {
                    this.users = data;
                });
        },
        add_new_user() {
            this.form_params.user = null;
            this.form_params.show = true;
        },
        edit_user(user_id) {
            this.form_params.user = this.users.find(user => user.id === user_id);
            this.form_params.show = true;
        },
        delete_user(user_id) {
            return fetch('/users.php?user_id=' + user_id, {
                method: 'DELETE',
                cache: 'no-cache',
                headers: {
                },
            });
        }

    }
}

export default users_table;