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


    return fetch(`${urlPrefix}index.php`).then(res=>{
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
        age: "",
    }
}


function getFetchOrdine() {
    let ordineString = JSON.stringify(ordine.content);
     
    return fetch(`${urlPrefix}index.php`, {
        method: "POST",
        body: ordineString
    })
    
}

function salvaOrdine() {
    getFetchOrdine().then((res)=>{
        console.log(res.clone().json())
        if(res.status == 200) {
            return res.json();
        }

        throw new Error('Res code is not 200');
    }).catch((err)=>{
        console.error(err)
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
                <input type="text" class="floating-input-100" placeholder=" ">
                <label class="floating-label-100">Nome</label>
            </div>
            <div class="cnt-floating-label">
                <input type="number" class="floating-input-100" placeholder=" ">
                <label class="floating-label-100">Età</label>
            </div>
            <button @click="salvaOrdine" class="btn-default btn-blue-secondary width-25">Salva</button>
        </div>
    </div>
</template>
