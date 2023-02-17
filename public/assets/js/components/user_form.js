function user_form(el) {
    return {
        element: el,
        user_id: 0,
        first_name: "",
        last_name: "",
        position: "",
        init() {
            let that = this;
        },
        set_user_data(user, method) {
            if (user) {
                this.user_id = user.id;
                this.first_name = user.first_name;
                this.last_name = user.last_name;
                this.position = user.position;

            } else {
                this.user_id = 0;
                this.first_name = '';
                this.last_name = '';
                this.position = '';
            }

            console.info("setuserdata", user, method);
        },
        send_data(el) {
            var data = new FormData(el);
            return fetch('/users.php', {
                method: 'POST',
                cache: 'no-cache',
                headers: {
                },
                body: data
            });
        }
    };
}

export default user_form;
