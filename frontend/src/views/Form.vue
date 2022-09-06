<script setup>
    import { onBeforeMount, ref, reactive, toRaw } from "vue";
    import { useRoute } from 'vue-router';
    import { getUser, urlPrefix, makeUser, fillInUser } from '../general.js';
    const routeName = useRoute().name;
    const id_user = useRoute().params.id;
    const messageStatus = ref("");
    const ready = ref(false);
    
    const STATUS_NOT_SENT = "not_sent";
	const STATUS_ERROR = "error";
	const STATUS_SUCCESS = "success";
	const status = ref(STATUS_NOT_SENT);

    const user = reactive({
        content: makeUser(),
        key: Date.now()
    });

    onBeforeMount(() => {
        if(routeName == "edit" ) {
            fetchOrdine();
        } else {
            console.log("sono in insert")
			ready.value = true;
        }
    });


    function fetchOrdine() {
		getUser(id_user).then((res)=>{
            console.log("sono users", res.items)
            user.content = fillInUser(res.items);
		});
        ready.value = true;
	}

    function getFetchUser() {
        if(routeName == "edit") {
            user.content.id = id_user;
        }

        let userString = JSON.stringify(user.content);

        console.log("sono user string", userString)
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
        ready.value = false;
        user.key = Date.now();
        getFetchUser().then((res)=>{
            if(res.status != 400) {
				return res.json();
			}

            messageStatus.value = "Inserimento non riuscito, mancano dei campi";
            status.value = STATUS_ERROR;
        }).then((resObj)=>{
            //console.log("sono obj", resObj)
           
            if(typeof resObj !== 'undefined') {
                messageStatus.value = "Inserimento effettuato";
				status.value = STATUS_SUCCESS;
			}

        }).catch((err)=>{
            messageStatus.value = "Errore nella fetch -->  " + err;
            status.value = STATUS_ERROR;
            console.error(err)

        }).finally(()=>{
			ready.value = true;
		});
    }

</script>
    
<template>
    <div class="mg-l" v-if="ready">
        <div class="card flex f-column gap-s cnt-s">
            <!-- <div>user.content: {{user.content}}</div> -->

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
       
        <div class="box-status width-25 pd-s" :class="(status !== STATUS_ERROR ? 'bg-green-400' : 'bg-red-400')" v-show="(status != STATUS_NOT_SENT)">{{ messageStatus }}</div>
    </div>

</template>
    
<style scoped>
</style>
    