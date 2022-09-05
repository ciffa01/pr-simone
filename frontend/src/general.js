let urlPrefix = "/pr-simone/backend/";

async function postUser(ordine) {
    let json;
    try {
        json = await (await fetch(`${urlPrefix}ordine`, {
            body: ordine,
            method: "POST"
        })).json();
    } catch (err) {
        console.error(err);
    } finally {
        return json;
    }
}

function getUser() {
    return fetch(`${urlPrefix}items/read`).then(res=>{
        console.log(res.clone())
        return res.json()
    })
}

function getUsers(id, name, age) {
    let urlParams = new URLSearchParams();
    urlParams.set("q_id", id);
    urlParams.set("q_name", name);
    urlParams.set("q_age", age);

    return fetch(`${urlPrefix}items/read.php`).then(res=>{
        return res.json();
    })
}



/* CREAZIONE OGGETTI STANDARD */
export function makeUser() {
    let user = makeEmptyUser();
    return user;
}

export function makeEmptyUser() {
    return {
        id: "",
        name: "",
        age: ""
    }
}

export { getUser, postUser, getUsers, urlPrefix };