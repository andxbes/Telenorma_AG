function users_table(el) {
    return {
        element: el,
        users: null,
        init() {
            this.refresh_users_data();
        },
        refresh_users_data() {
            fetch('/users.php')
                .then(res => res.json())
                .then(data => {
                    console.info(data);
                    // if ((typeof data) !== "undefined") {
                    this.users = data;
                    // }
                });
        }
    }
}

export default users_table;