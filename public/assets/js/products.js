window.onload = () => {
    function displayAllProducts(data) {
        console.log(data);

        let html = `
        <nav aria-label="Page navigation example">
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <p class="small text-muted">
            Showing
                <span class='fw-semibold'>${
                    data.products.from ? data.products.from : "0"
                }</span>
            to
                <span class='fw-semibold'>${
                    data.products.to ? data.products.to : "0"
                }</span>
            of
                <span class='fw-semibold'>${data.products.total}</span>
            results
            `;

        html += `</p>
            <ul class="pagination">
            `;

        data.products.links.forEach((x) => {
            if (x.url != null) {
                html += `<li class="page-item ${
                    x.active ? "active" : ""
                } "><button class='page-link pl' data-url='${x.url}'>${
                    x.label
                }</button></li>
                `;
            }
        });

        html += ` </ul> </nav> </div>`;

        data.products.data.forEach((p) => {
            html += `
        <div class="col-12 col-md-6 col-lg-4 card-group">
           <div class="card mb-3 text-center">
               <a href="${baseUrl}/products/${p.id_flower}">
                   <img src="${p.image.path}" class="card-img-top"
                       alt="${p.image.image_name}" />
               </a>

               <div class="card-body">
                   <h5 class="card-title">${p.flower_name}</h5>
                   <p class="fw-light">${p.current_pricing.price}&euro;</p>
               </div>
           </div>
       </div>
       `;
        });

        document.querySelector("#productsDisplay").innerHTML = html;
    }

    function getAllProducts(searchObj) {
        //console.log(searchObj);
        // let filtersQuery = ``;
        // // searchObj.filterValues.forEach((x) => {
        // //     filtersQuery += x + ",";
        // // });
        // console.log(searchObj.query);
        // console.log(searchObj.sortOrder);
        console.log(searchObj.filters);
        ajaxCallback(
            `/products/filter/${searchObj.query}/${searchObj.sortOrder}/${searchObj.filters}`,
            "GET",
            { _token: token },
            function (data) {
                displayAllProducts(data);
            },
            function (data) {
                console.log(data);
            }
        );
    }

    function getAllProductsFiltered(url) {
        $.ajax({
            url: url,
            method: "GET",
            success: function (data) {
                displayAllProducts(data);
            },
            error: function (data) {
                console.log(data);
            },
            dataType: "json",
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            processData: false,
        });
    }

    function lsSet(name, value) {
        localStorage.setItem(name, JSON.stringify(value));
    }

    function lsGet(name) {
        return localStorage.getItem(name);
    }

    //events

    function getSearchParameters() {
        let searchObj = {
            query: "0",
            sortOrder: "0",
            filters: new Array(),
        };

        let checkboxesArray = document.querySelectorAll(
            "input[type=checkbox]:checked"
        );
        let checkboxValues = [];

        for (let i = 0; i < checkboxesArray.length; i++) {
            checkboxValues.push(Number(checkboxesArray[i].value));
        }

        let inputQ = $("#productsSearch").val().toLowerCase();
        let inputS = $("#productsSelect").val();
        let inputF = checkboxValues;

        if (inputQ != "") {
            searchObj.query = inputQ;
        }

        if (inputS != "0") {
            searchObj.sortOrder = inputS;
        }
        if (inputF.length != 0) {
            searchObj.filters = inputF;
        }

        searchObj.filters = JSON.stringify(searchObj.filters);
        return searchObj;
    }

    $(document).on("input", "#productsSearch", function () {
        getAllProducts(getSearchParameters());
    });

    $(document).on("change", "#productsSelect", function () {
        getAllProducts(getSearchParameters());
    });

    $(document).on("change", ".form-filters", function () {
        getAllProducts(getSearchParameters());
    });
    $(document).on("change", ".form-filters", function () {
        getAllProducts(getSearchParameters());
    });
    $(document).on("click", ".pl", function () {
        getAllProductsFiltered($(this).attr("data-url"));
    });
};
