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

    console.log("ordine string", ordineString);
/* 
    return fetch(`${urlPrefix}/items/create.php`).then(res=>{
        console.log(res.json())
        return res.json();
    }) */

    return fetch(`${urlPrefix}items/create`, {
        method: "POST",
        body: ordineString,
    })
    
}
console.log("sono fextch", getFetchOrdine())

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


</script>

<template>
    <div>
        <div class="flex f-column gap-xs">
            <span v-for="(value, index) in users" :key="index"> {{value}}</span>
        </div>
        <div class="card flex f-column gap-s mg-m cnt-s">
            <span class="text-black-900 weight-500 text-l mg-b-xs">Prova 1</span>
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
