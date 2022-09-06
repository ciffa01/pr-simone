<script setup>
import { onBeforeMount, ref, reactive } from "vue";
import { useRouter } from 'vue-router';
import { getUsers, urlPrefix } from "../general.js";
import emailjs from 'emailjs-com';

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
    //console.log("sono users", users)
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

const name = ref("");
const email = ref("");
const message = ref("");

function sendEmail() {
    var templateParams = {
        name: name.value,
        email: email.value,
        message: message.value
    };
 
    emailjs.send('service_u21ff44', 'template_b7nstxb', templateParams, 'zkqbZARQ0zM7tRtJD')
        .then(function(response) {
            console.log('SUCCESS!', response.status, response.text);
        }, function(error) {
            console.log('FAILED...', error);
        }
    );

    name.value = ""
    email.value = ""
    message.value = ""
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

        
        <div class="container">
           
            <label>Name</label>
            <input 
                type="text" 
                v-model="name"
                name="name"
                placeholder="Your Name"
            >

            <label>Email</label>
            <input 
                type="email" 
                v-model="email"
                name="email"
                placeholder="Your Email"
            >

            <label>Message</label>
            <textarea 
                name="message"
                v-model="message"
                cols="30" rows="5"
                placeholder="Message">
            </textarea>

            <button class="btn-default btn-green-secondary text-xs" @click="sendEmail()">invia</button>
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


/******* EMAIL ******/
.container {
    display: block;
    margin:auto;
    text-align: center;
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
    width: 50%;
}

label {
    float: left;
}

input[type=text], [type=email], textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
    resize: vertical;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}


</style>
