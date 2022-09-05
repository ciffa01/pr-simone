<script setup>
    import { onBeforeMount, ref, reactive, toRaw } from "vue";
    import { useRoute } from 'vue-router';
    import { getUser, urlPrefix, makeUser } from '../general.js';
    const routeName = useRoute().name;
    const id_user = useRoute().params.id;
    const users = ref([]);

    ////// INSERT ////////
    const user = reactive({
        content: makeUser(),
        key: Date.now()
    });

    onBeforeMount(() => {
        if(routeName == "edit" ) {
            fetchOrdine();
        } else {
			console.log("ciao")
        }
    });

    function fetchOrdine() {
		getUser().then((res)=>{
			if(!res) {
				console.error("Error getUser form");
				return;
			}

            users.value = res.items;
            console.log("sono users", users)
		});
	}

    function getFetchUser() {
        if(routeName == "edit") {
            user.content.id = id_user;
        }

        let userString = JSON.stringify(user.content);
        if(routeName == "edit") {
            return fetch(`${urlPrefix}items/update`, {
                method: "PUT",
                body: userString
            });
        } else if (routeName == "insert") {
            return fetch(`${urlPrefix}items/create`, {
                method: "POST",
                body: userString
            })
        } else {
            throw new Error("Metodo non riconosciuto")
        }
    }

    function salvaUser() {
        user.key = Date.now();
        getFetchUser().then((res)=>{
            console.log("sono res", res.clone().json())
            return res.json();
        }).then((json)=>{
            console.log("json", json)
            user.content = json;
        }).catch((err)=>{
            console.error(err)
            console.log("ciao")
        })
    }

</script>
    
<template>
    <div>
        <span>sono in {{routeName}}</span>
        <div v-show="(routeName == 'edit' && $route.params.id == value.id)" 
            class="card flex f-column gap-s mg-s cnt-s" 
            v-for="(value, index) in users" :key="index">
            <div>ciao: {{user.content}}</div>
            <div class="cnt-floating-label">
               <input type="text" class="floating-input-100"  v-model="user.content.name" placeholder=" ">
               <label class="floating-label-100">Nome</label>
            </div>
            <div class="cnt-floating-label">
               <input type="number" class="floating-input-100" v-model="user.content.age"  placeholder=" ">
               <label class="floating-label-100">Età</label>
            </div>
            <button @click="salvaUser" class="btn-default btn-blue-secondary width-25">Salva</button>
       </div>
   
        <div v-show="(routeName == 'insert')" class="card flex f-column gap-s mg-s cnt-s">
           <div class="cnt-floating-label">
               <input type="text" class="floating-input-100" v-model="user.content.name" placeholder=" ">
               <label class="floating-label-100">Nome</label>
           </div>
           <div class="cnt-floating-label">
               <input type="number" class="floating-input-100" v-model="user.content.age"  placeholder=" ">
               <label class="floating-label-100">Età</label>
           </div>
           <button @click="salvaUser" class="btn-default btn-blue-secondary width-25">Salva</button>
       </div>
    </div>
</template>
    
<style scoped>

    
    
</style>
    