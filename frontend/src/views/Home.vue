<script setup>
import { onBeforeMount, ref, reactive } from "vue";
import { useRouter } from 'vue-router';
import { getUsers, urlPrefix } from "../general.js";

const router = useRouter();
const q_id = ref("");
const q_name = ref("");
const q_age = ref("");
const users = ref([]);



async function fetchUser() {
    getUsers(q_id.value, q_name.value, q_age.value).then((res)=>{
        if(!res) {
            console.error("Errore nella fetch degli ordini");
            return;
        }
        users.value = res.items;
        
    }).catch(e=>{
       console.error(e)
    });
    console.log("sono users", users)
}

onBeforeMount(() => {
    fetchUser();
});

function deleteUser(id_user) {
    let idUserDelete =  {
        id: id_user
    }

    idUserDelete = JSON.stringify(idUserDelete);

    return fetch(`${urlPrefix}items/delete`, {
        method: "PUT",
        body: idUserDelete
    })

}

</script>

<template>
    <div>
        
        <div class="card flex f-column gap-s mg-m cnt-s">
            <router-link class="btn-default btn-blue-secondary width-50 text-center" :to="{ name: 'insert' }">Aggiungi nuovo</router-link>
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
                    <tr v-for="(value, index) in users" :key="index"> 
                        <td>{{value.name}}</td>
                        <td>{{value.age}}</td>
                        <td>
                            <router-link  class="btn-action edit" :to="{ name: 'edit', params: { id: value.id } }">Modifica</router-link>
                        </td>
                        <td>
                            <button class="delete" @click="deleteUser(value.id)">Elimina</button>
                        </td>
                    </tr>
                </tbody>
            </table>
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

tbody .btn-action, tbody button {
    padding: 0.5rem;
    border: 1px solid #b3b3b3;
    border-radius: 5px;
}

.btn-action.edit {    
    background: #f1ea17;
}

.button.delete {    
    background: #d00606;
    color: #fff;
}


</style>
