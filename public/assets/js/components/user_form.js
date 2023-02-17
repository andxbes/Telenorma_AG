function user_form(el) {
    return {
        element: el,
        method: "",
        user_id: 0,
        first_name: "",
        last_name: "",
        position: "",
        init() {
            this.element.addEventListener("submit", function (e) {
                e.preventDefault();
                var data = new FormData(form);
                console.info(data);
            });
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
            this.method = method;

            console.info("setuserdata", user, method);
        },
    };
}

export default user_form;
