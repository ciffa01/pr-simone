<script setup>
import { onBeforeMount, ref, reactive } from "vue";

const q_id = ref("");
const q_name = ref("");
const q_age = ref("");
const users = ref([]);
let urlPrefix = "/pr-simone/backend/";

//////// GET /////////
function getUsers(id, name, age) {
    let urlParams = new URLSearchParams();
    urlParams.set("q_id", id);
    urlParams.set("q_name", name);
    urlParams.set("q_age", age);


    return fetch(`${urlPrefix}items/read.php`).then(res=>{
        return res.json();
    }).then(json=>{
        users.value = json;
    })
}

onBeforeMount(() => {
    getUsers(q_id.value, q_name.value, q_age.value);
});

////// INSERT ////////
const ordine = reactive({
    errors: makeOrdine(),
    content: makeOrdine(),
    key: Date.now()
});

function makeOrdine() {
    let user = makeEmptyOrdine();
    return user;
}



function makeEmptyOrdine() {
    return {
        name: "",
        age: ""
    }
}


function getFetchOrdine() {
    let ordineString = JSON.stringify(ordine.content);
    return fetch(`${urlPrefix}items/create`, {
        method: "POST",
        body: ordineString,
    })
    
}

function salvaOrdine() {
    getFetchOrdine().then((res)=>{
        //console.log("sono res", res.clone().json())
        return res.json();
    }).then((json)=>{
        ordine.content = json;
    }).catch((err)=>{
        console.error(err)
        console.log("ciao")
    })
}

function elimina(idC) {
    let idDelete =  {
        id: idC
    }

    let idd = JSON.stringify(idDelete);

    console.log(idDelete)
    return fetch(`${urlPrefix}items/delete`, {
        method: "PUT",
        body: idd
    })
}

console.log(users)


</script>

<template>
    <div>
        <div class="flex f-column gap-xs">
            <div class="card flex f-column gap-s mg-m cnt-s">
                <table>
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td>Anni</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in users.items" :key="index"> 
                            <td>{{value.name}}</td>
                            <td>{{value.age}}</td>
                            <td>
                                <button class="edit">Modifica</button>
                            </td>
                            <td>
                                <button class="delete" @click="elimina(value.id)">Elimina</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="card flex f-column gap-s mg-s cnt-s">
            <div class="cnt-floating-label">
                <input type="text" class="floating-input-100" v-model="ordine.content.name" placeholder=" ">
                <label class="floating-label-100">Nome</label>
            </div>
            <div class="cnt-floating-label">
                <input type="number" class="floating-input-100" v-model="ordine.content.age"  placeholder=" ">
                <label class="floating-label-100">Età</label>
            </div>
            <button @click="salvaOrdine" class="btn-default btn-blue-secondary width-25">Salva</button>
        </div>

        <div class="card flex f-column gap-s mg-s cnt-s">
            <div class="cnt-floating-label">
                <input type="text" class="floating-input-100" v-model="ordine.content.name" placeholder=" ">
                <label class="floating-label-100">Nome</label>
            </div>
            <div class="cnt-floating-label">
                <input type="number" class="floating-input-100" v-model="ordine.content.age"  placeholder=" ">
                <label class="floating-label-100">Età</label>
            </div>
            <button @click="salvaOrdine" class="btn-default btn-blue-secondary width-25">Salva</button>
        </div>
    </div>
</template>

<style scoped>
table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}

thead tr {
    padding: 0.8rem 0;
    background-color: #0c34a4;
    color: white;
    font-weight: 500;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 8px;
}

table tr:nth-child(even){
    background-color: #f2f2f2;
}

tbody button {
    padding: 0.5rem;
    border: 1px solid #b3b3b3;
    border-radius: 5px;
}

button.edit {    
    background: #f1ea17;
}

button.delete {    
    background: #d00606;
    color: #fff;
}


</style>
