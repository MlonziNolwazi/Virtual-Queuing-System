//Apis

//AUTH 
const auth = ({ action, data }) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `php/api.php`,
            type: "GET",
            data: { service: action, data },
            dataType: 'json',
            success: (response) => {
                debugger
                resolve(response); // Resolve the promise with the response
            },
            error: (xhr, status, error) => {
                debugger
                reject({ status, error }); // Reject the promise if there's an error
            }
        });
    });
}

//GET
const getAll = ({action}) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `php/api.php`,
            type: "GET",
            data: { service: action },
            dataType: 'json',
            success: (response) => {
                debugger
                resolve(response); // Resolve the promise with the response
            },
            error: (xhr, status, error) => {
                debugger
                reject({ status, error }); // Reject the promise if there's an error
            }
        });
    });
}

const getById = ({ id, action}) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url : 'php/api.php',
            type: 'GET',
            data: { id, service: action },
            dataType : 'json',
            success: (response) => {
                debugger
                resolve(response.isFound && response?.user[0]);
            },
            error: (xhr, status, error) => {
                debugger
                reject({status, error});
            }
        })
    })
}

const getAllBy = ({ filter, action, columns }) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `php/api.php`,
            type: "GET",
            data: { service: action , filter, columns},
            dataType: 'json',
            success: (response) => {
                debugger
                resolve(response); // Resolve the promise with the response
            },
            error: (xhr, status, error) => {
                debugger
                reject({ status, error }); // Reject the promise if there's an error
            }
        });
    });
}

//POST
const create = ({ action, data }) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `php/api.php`,
            type: "POST",
            data: { service: action, data },
            dataType: 'json',
            success: (response) => {
                debugger
                resolve(response); // Resolve the promise with the response
            },
            error: (xhr, status, error) => {
                debugger
                reject({ status, error }); // Reject the promise if there's an error
            }
        });
    });
}


//PUT
const update = ({id,  data, action }) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `php/api.php`,
            type: "PUT",
            data: JSON.stringify({ service: action, id, data }), // Send data as JSON
            dataType: 'json',
            success: (response) => {
                debugger
                resolve(response); // Resolve the promise with the response
            },
            error: (xhr, status, error) => {
                debugger
                reject({ status, error }); // Reject the promise if there's an error
            }
        });
    });
}


//DELETE
const remove = ({ id, action }) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `php/api.php`,
            type: "DELETE",
            contentType: "application/json", // Specify JSON content type
            data: JSON.stringify({ service: action, id }), // Send data as JSON in the request body
            dataType: 'json',
            success: (response) => {
                debugger;
                resolve(response); // Resolve the promise with the response
            },
            error: (xhr, status, error) => {
                debugger;
                reject({ status, error }); // Reject the promise if there's an error
            }
        });
    });
};



