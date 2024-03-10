window.onload = () => {
    //#region Users
    if (window.location.pathname == "/admin/users") {
        const newUserAdminBtn = document.querySelector("#newUserAdminButton");
        const newUserAdminCloseBtn =
            document.querySelector("#dialogCloseButton");
        const adminNewUserDialog = document.querySelector("dialog");

        newUserAdminBtn.addEventListener("click", () => {
            adminNewUserDialog.showModal();
        });

        newUserAdminCloseBtn.addEventListener("click", () => {
            adminNewUserDialog.close();
        });

        function displayAllUsers(data) {
            console.log(data);
            let html = `
            ${data.links}
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id:</th>
                    <th>First / Last Name:</th>
                    <th>Email:</th>
                    <th>Role:</th>
                    <th>Edit:</th>
                    <th>Delete:</th>
                </tr>
            </thead>
            <tbody>`;
            data.users.data.forEach((u) => {
                html += `
                    <tr>
                    <td>${u.id}</td>    
                    <td>${u.first_name} ${u.last_name}</td>    
                    <td>${u.email}</td>    
                    <td>${u.role.role_name}</td>    
                    <td>
                        <button data-id="${u.id}" type="button" class="btn btnEditUser"><i class="fa-regular fa-pen-to-square"></i></button>
                    </td>    
                    <td>
                        <button data-id="${u.id}" type="button" class="btn btnDeleteUser"><i class="fa-regular fa-trash-can"></i></button>    
                    </td>    
                </tr>
                    `;
            });

            html += `
            </tbody>
            </table>

            `;

            document.querySelector("#userDisplay").innerHTML = html;
        }

        function getAllUsers() {
            ajaxCallback(
                "/admin/users/getAll",
                "GET",
                { _token: token },
                function (data) {
                    displayAllUsers(data);
                },
                function (data) {
                    console.log(data);
                }
            );
        }

        function getUser(id) {
            ajaxCallback(
                "/admin/users/getUser/" + id,
                "GET",
                {
                    _token: token,
                },
                function (data) {
                    fillFormForEdit(data);
                },
                function (data) {
                    console.log(data);
                }
            );
        }

        function getRoles() {
            ajaxCallback(
                "/admin/users/getRoles",
                "GET",
                function (data) {
                    return data;
                },
                function (data) {
                    console.log(data);
                }
            );
        }

        function fillFormForEdit(data) {
            adminNewUserDialog.showModal();
            adminNewUserDialog.innerHTML = "";
            let html = `
            <h4>Edit user:</h4>
            <hr />
            <div id='editUserAdminErrors'>
            </div>
            <form class='form' action="${baseUrl}/admin/users/update/${data.id}" method="POST" name='editUserAdminForm' id='editUserAdminForm'>
                <input type="hidden" id="_method" name="_method" value="PUT" />
                <input type="hidden" id="_token" name="_token" value="${token}" />
                <div class="mb-3">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email" name="email" value="${data.email}" />
                </div>
                <div class="mb-3">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="${data.first_name}" />
                </div>
                <div class="mb-3">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="${data.last_name}" />
                </div>
                <div class="mb-3">
                    <select class="form-select" id="role_id" name="role_id">
                        <option value="${data.role_id}" selected>${data.role.role_name}</option>
                    </select>
                </div>
    
                <div class="d-flex justify-content-lg-between justify-content-center">
                    <button type="button" class="btn btn-secondary me-3" id="dialogCloseButton">Close</button>
                    <button type="submit" class="btn btn-success" data-id='${data.id}' id='editUser'>Edit user data</button>
                </div>
            </form>
    
            `;

            adminNewUserDialog.innerHTML = html;
        }

        // function setFormDataForEdit() {
        //     let formData = {
        //         first_name: $("#first_name").val(),
        //         last_name: $("#last_name").val(),
        //         email: $("#email").val(),
        //         role_id: $("#role_id").val(),
        //         _token: token,
        //         _method: 'PUT'
        //     };

        //     //data = new FormData(document.querySelector("#editUserAdminForm"));
        //     // formData = new FormData();
        //     // formData.append("first_name", $("#first_name").val());
        //     // formData.append("last_name", $("#last_name").val());
        //     // formData.append("email", $("#email").val());
        //     // formData.append("role_id", $("#role_id").val());
        //     // formData.append("_token", token);
        //     // let formData = new FormData(document.querySelector('#editUserAdminForm'));
        //     console.log(formData)
        //     return formData;
        // }

        function deleteUser(id) {
            if (confirm("Are you sure you want to delete user?")) {
                ajaxCallback(
                    `/admin/users/destroy/${id}`,
                    "POST",
                    {
                        id: id,
                        _token: token,
                    },
                    function (data) {
                        getAllUsers(data);
                    },
                    function (data) {
                        console.log(data);
                    }
                );
            }
        }

        // function editUser(id) {

        //     let data = Object.entries(setFormDataForEdit());
        //     console.log(data);
        //     ajaxCallback(
        //         `/admin/users/update/${id}`,
        //         "PUT",
        //         data,
        //         function (data) {
        //             getAllUsers(data);
        //         },
        //         function (data) {
        //                 console.log(data)
        //         },
        //         'json',
        //         'application/json',
        //         false
        //     );
        // }

        function printErrors(errors, errorsDiv) {
            $(`#${errorsDiv}`).html("");
            let html = "";
            errors.forEach((e) => {
                html += `<p class='alert alert-danger'>${e[1]}</p>\n`;
                $(`#${errorsDiv}`).html(html);
            });
        }

        //Events
        $(document).on("click", ".btnDeleteUser", function (e) {
            e.preventDefault();

            let currentId = $(this).attr("data-id");

            deleteUser(currentId);
        });
        $(document).on("click", "#refreshUsers", function (e) {
            getAllUsers();
        });
        $(document).on("click", ".btnEditUser", function (e) {
            e.preventDefault();

            let currentId = $(this).attr("data-id");
            getUser(currentId);
        });
        // $(document).on("click", "#editUser", function (e) {
        //     e.preventDefault();

        //     let currentId = $(this).attr("data-id");
        //     editUser(currentId);
        // });
        $(document).on("click", "#dialogCloseButton", function (e) {
            e.preventDefault();
            adminNewUserDialog.close();
        });

        function validateForm() {
            let errors = [];

            let email = $("#registerEmail").val();
            let password = $("#registerPassword").val();
            let firstName = $("#registerFirstName").val();
            let lastName = $("#registerLastName").val();

            let emailRegex =
                /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

            if (!emailRegex.test(email)) {
                errors.push(
                    "Email must be in valid format: eg. johndoe@gmail.com"
                );
            }

            if (!passwordRegex.test(password)) {
                errors.push("Password isn't in valid format.");
            }

            if (firstName == "" || firstName.length < 2) {
                errors.push("First name can't be empty.");
            }

            if (lastName == "" || lastName.length < 2) {
                errors.push("Last name can't be empty.");
            }
            if (errors.length === 0) {
                document.querySelector("#registerUserDialogForm").submit();
            } else {
                document.querySelector("#registerUserDialogErrors").innerHTML =
                    "";

                errors.forEach((e) => {
                    document.querySelector(
                        "#registerUserDialogErrors"
                    ).innerHTML += `<p class='alert alert-danger'>${e}</p>\n`;
                });
            }
        }
        //event
        $(document).on("click", "#editUserDialog", function (e) {
            e.preventDefault();

            validateForm();
        });
    }
    //#endregion

    //#region UserLogs

    if (window.location.pathname.includes("/admin/userLogs")) {
        function getAllUserLogs(order) {
            ajaxCallback(
                `/admin/userLogs/${order}`,
                "GET",
                {},
                function (data) {
                    displayAllUserLogs(data);
                },
                function (data) {
                    console.log(data);
                }
            );
        }

        function getAllUserLogsFiltered(url) {
            $.ajax({
                url: url,
                method: "GET",
                success: function (data) {
                    displayAllUserLogs(data);
                },
                error: function (data) {
                    console.log(data);
                },
                dataType: "json",
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                processData: false,
            });
        }

        function displayAllUserLogs(data) {
            console.log(data);
            let html = `
            <nav aria-label="Page navigation example">
            <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                <p class="small text-muted">
                Showing
                    <span class='fw-semibold'>${
                        data.from ? data.from : "0"
                    }</span>
                to
                    <span class='fw-semibold'>${data.to ? data.to : "0"}</span>
                of
                    <span class='fw-semibold'>${data.total}</span>
                results
                </p>
                <ul class="pagination">
                `;

            data.links.forEach((x) => {
                if (x.url != null) {
                    html += `<li class="page-item ${
                        x.active ? "active" : ""
                    } "><button class='page-link pl' data-url='${x.url}'>${
                        x.label
                    }</button></li>
                    `;
                }
            });

            html += ` </ul> </nav> </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id:</th>
                                <th>Type:</th>
                                <th>Message</th>
                                <th>Date:</th>
                            </tr>
                        </thead>
                        <tbody>`;

            data.data.forEach((l) => {
                html += `
                                <tr>
                                    <td>${l.id_log}</td>
                                    <td>${l.type}</td>
                                    <td>${l.message}</td>
                                    <td>${l.formattedDate}</td>
                                </td>
                            </tr>
                                `;
            });

            html += `
                        </tbody>
                    </table>

            `;

            $("#userLogsDisplay").html(html);
        }

        $(document).on("change", "#sortDate", function () {
            let orderValue = $("#sortDate").val();
            getAllUserLogs(orderValue);
        });

        $(document).on("click", ".pl", function () {
            getAllUserLogsFiltered($(this).attr("data-url"));
        });
    }
    //#endregion

    //#region Products
    if (window.location.pathname.includes("/admin/products")) {
        const newProduct = document.querySelector("#newProductAdmin");
        const newProductClose = document.querySelector("#dialogClose");
        const newProductDialog = document.querySelector("dialog");

        $(document).on("click", "#dialogClose", function () {
            newProductDialog.close();
        });

        newProduct.addEventListener("click", () => {
            newProductDialog.showModal();
        });

        newProductClose.addEventListener("click", () => {
            newProductDialog.close();
        });

        function getAllProducts() {
            ajaxCallback(
                "/admin/products",
                "GET",
                {},
                function (data) {
                    displayAllProducts(data);
                },
                function (data) {
                    console.log(data);
                }
            );
        }

        function displayAllProducts(data) {
            console.log(data);
            let html = `
            ${data.links}
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id:</th>
                    <th>Product Name:</th>
                    <th>Image:</th>
                    <th>Price:</th>
                    <th>Edit:</th>
                    <th>Delete:</th>
                </tr>
            </thead>
            <tbody>`;
            data.flowers.data.forEach((u) => {
                html += `
                    <tr>
                    <td>${u.id_flower}</td>    
                    <td>${u.flower_name}</td>     
                    <td><img class="img-small" src="${baseUrl}/${u.image.path}" alt="${u.image.img_name}"/></td>     
                    <td class='fw-bold'>${u.current_pricing.price} &euro;</td>    
                    <td>
                        <button data-id="${u.id_flower}" type="button" class="btn btnEditProduct"><i class="fa-regular fa-pen-to-square"></i></button>
                    </td>    
                    <td>
                        <button data-id="${u.id_flower}" type="button" class="btn btnDeleteProduct"><i class="fa-regular fa-trash-can"></i></button>    
                    </td>    
                </tr>
                    `;
            });

            html += `
            </tbody>
            </table>

            `;

            document.querySelector("#productDisplay").innerHTML = html;
        }

        function deleteProduct(id) {
            if (confirm("Are you sure you want to delete product?")) {
                ajaxCallback(
                    `/admin/products/destroy/${id}`,
                    "POST",
                    {
                        id: id,
                        _token: token,
                    },
                    function (data) {
                        displayAllProducts(data);
                    },
                    function (data) {
                        console.log(data);
                    }
                );
            }
        }

        function getProduct(id) {
            ajaxCallback(
                `/products/${id}`,
                "GET",
                {
                    _token: token,
                },
                function (data) {
                    fillFormProduct(data);
                },
                function (data) {
                    console.log(data);
                },
                "json",
                "application/x-www-form-urlencoded;charset=UTF-8",
                true
            );
        }
        function fillFormProduct(data) {
            console.log(data);
            newProductDialog.showModal();
            newProductDialog.innerHTML = "";

            let html = `
            <div id='editProductAdminErrors' class="my-3">
            </div>
            <h4>Edit product:</h4>
            <hr />
            <form enctype="multipart/form-data" class='form' action="${baseUrl}/admin/products/update/${data.product.id_flower}" method="POST" name='editProductAdminForm' id='editProductAdminForm'>

                <input type="hidden" id="_method" name="_method" value="PUT" />
                <input type="hidden" id="_token" name="_token" value="${token}" />
                <div class="mb-3">
                    <label class="form-label" for="productName">Name</label>
                    <input class="form-control" type="text" name="productName" id="productName" value="${data.product.flower_name}" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="productPrice">Price</label>
                    <input class="form-control" type="number" step="0.1" min="0" name="productPrice" id="productPrice" value="${data.product.current_pricing.price}" />
                </div>
                <div class="mb-3">
                    <p>Categories</p>
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">`;

            productCatIdArray = [];
            for (const p in data.product.categories) {
                productCatIdArray.push(data.product.categories[p].id_category);
            }
            data.categories.forEach((c) => {
                html += `
                <input type="checkbox" name="productCategories[]" class="btn-check" id="cat-${
                    c.id_category
                }" value="${c.id_category}" autocomplete="off" ${
                    productCatIdArray.includes(c.id_category) ? "checked" : ""
                } />
                <label class="btn btn-outline-primary" for="cat-${
                    c.id_category
                }">${c.category_name}</label>`;
            });

            html += `
                    </div>
                </div>
            <div class="mb-3">
                <div class="mb-3">  
                    <p>Current image</p>
                    <img src="${baseUrl}/${data.product.image.path}" alt='${data.product.image.img_name}' class='img-small'/>

                </div>
                <div class="mb-3">
                    <label for="productImage" class="form-label">Change image? (PNG, JPG)</label>
                    <input class="form-control" type="file" id="productImage" name="productImage" accept=".jpg, .jpeg, .png"/>
                </div>
            </div>
            <div class="mt-5 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="dialogClose">Close</button>
                <button type="submit" class="btn btn-success" id="submitEditProduct">Save</button>
            </div>
            </form>
    
            `;

            newProductDialog.innerHTML = html;
        }

        function validateProductEdit() {
            let name = $("#productName").val();
            let price = Number($("#productPrice").val());
            let catArray = $(`input[name='productCategories[]']:checked`)
                .map(function () {
                    return this.value;
                })
                .get();
            let img = $("#productImage").val();
            let errors = [];

            console.log(name, price, catArray, img);

            if (name.length === 0 || name.length < 2) {
                errors.push("Product name must contain at least 3 letters");
            }

            if (price < 0.0 || price == 0) {
                errors.push("Product price must be greater than 0");
            }

            if (catArray.length === 0) {
                errors.push("Product must belog to at least 1 category");
            }

            if (errors.length === 0) {
                document.querySelector("#editProductAdminForm").submit();
            } else {
                document.querySelector("#editProductAdminErrors").innerHTML =
                    "";
                var htmlF = ``;
                errors.forEach((e) => {
                    htmlF += `<p class='alert alert-danger'>${e}</p>\n`;
                });
                document.querySelector("#editProductAdminErrors").innerHTML =
                    htmlF;
            }
        }

        //events
        $(document).on("click", ".btnDeleteProduct", function (e) {
            e.preventDefault();

            let currentId = $(this).attr("data-id");

            deleteProduct(currentId);
        });
        $(document).on("click", ".btnEditProduct", function (e) {
            e.preventDefault();

            let currentId = $(this).attr("data-id");

            getProduct(currentId);
        });
        $(document).on("click", "#submitEditProduct", function (e) {
            e.preventDefault();
            validateProductEdit();
        });
        $(document).on("click", "#refreshProducts", function () {
            getAllProducts();
        });
    }
    //#endregion
};
