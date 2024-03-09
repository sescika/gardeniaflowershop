window.onload = () => {
    console.log("hi");
    function validateForm(e) {
        let errors = [];

        let email = $("#email").val();
        let firstName = $("#first_name").val();
        let lastName = $("#last_name").val();

        let emailRegex =
            /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        //let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (!emailRegex.test(email)) {
            errors.push("Email must be in valid format: eg. johndoe@gmail.com");
        }

        if (firstName == "" || firstName.length < 2) {
            errors.push("First name can't be empty.");
        }

        if (lastName == "" || lastName.length < 2) {
            errors.push("Last name can't be empty.");
        }

        if (errors.length == 0) {
            document.querySelector("#updateUserInfoForm").submit();
        } else {
            document.querySelector("#updateInfoErros").innerHTML = "";

            errors.forEach((e) => {
                document.querySelector(
                    "#updateInfoErros"
                ).innerHTML += `<p class='alert alert-danger'>${e}</p>\n`;
            });
        }
    }

    //event

    $(document).on("click", "#submitUpdateUser", function (e) {
        e.preventDefault();

        validateForm();
    });
};
