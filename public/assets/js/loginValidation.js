window.onload = () => {
    function validateForm(e) {
        let errors = [];

        let email = $("#loginEmail").val();
        let password = $("#loginPassword").val();

        let emailRegex =
            /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (!emailRegex.test(email)) {
            errors.push("Email must be in valid format: eg. johndoe@gmail.com");
        }

        if (!passwordRegex.test(password)) {
            errors.push("Password isn't in valid format.");
        }

        if (errors.length == 0) {
            document.querySelector("#loginForm").submit();
        } else {
            document.querySelector("#loginErrors").innerHTML = "";

            errors.forEach((e) => {
                document.querySelector(
                    "#loginErrors"
                ).innerHTML += `<p class='alert alert-danger'>${e}</p>\n`;
            });
        }
    }

    //event

    $(document).on("click", "#submitLogin", function (e) {
        e.preventDefault();

        validateForm();
    });
};
