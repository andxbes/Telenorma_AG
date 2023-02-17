function users_table(el) {
    return {
        element: el,
        users: null,
        form_params: {
            show: false,
            method: '',
            user: null
        },
        init() {
            this.refresh_users_data();
        },
        refresh_users_data() {
            fetch('/users.php')
                .then(res => res.json())
                .then(data => {
                    //console.info(data);
                    // if ((typeof data) !== "undefined") {
                    this.users = data;
                    // }
                });
        },
        add_new_user() {
            this.form_params.method = "POST"
            this.form_params.user = null;
            this.form_params.show = true;
            console.info('add_new_user');
        },
        edit_user(user_id) {
            console.info('edit user', user_id);
            this.form_params.method = "PUT";
            this.form_params.user = this.users.find(user => user.id === user_id);
            this.form_params.show = true;
            // this.form_params.user = $id;
        },
        delete_user(user_id) {
            console.info('delete user', user_id);
        }

    }
}

export default users_table;