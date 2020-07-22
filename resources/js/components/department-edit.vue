<template>
    <form>
        <div class="form-group">
            <label for="input-name">{{lang.name}}</label>
            <input v-model="form.name" type="email" class="form-control" id="input-name"
                   :placeholder="lang.enter_value+lang.name">
        </div>
        <div class="form-group">
            <label for="input-description">{{lang.description}}</label>
            <textarea v-model="form.description" class="form-control" id="input-description" rows="3"
                      :placeholder="lang.enter_value+lang.description"></textarea>
        </div>
        <div class="form-group">
            <label for="input-group-file">{{lang.logo}}</label>
            <div class="input-group mb-3" id="input-group-file">
                <div class="custom-file">
                    <input @change="selectFile" type="file" class="custom-file-input" id="input-file">
                    <label class="custom-file-label" for="input-file"
                           :data-browse="lang.browse">{{lang.select_file}}</label>
                </div>
            </div>
            <img class="preview" v-if="departament != null" :src="'/logo/'+departament.logo" alt="">
        </div>
        <div class="form-group">
            <label for="input-group-file">{{lang.users}}</label>
            <div v-for="user in users" :key="user.id">
                <input type="checkbox" :id="user.id" v-model="form.usersList[user.id]">
                <label>{{ user.name }} (<a :href="'mailto:'+user.email">{{ user.email }}</a>)</label>
            </div>
        </div>
        <input type="button" @click="save" class="btn btn-primary" :value="lang.save">
    </form>
</template>

<script>
    export default {
        name: "department-edit",
        props: {
            users: {
                id: {
                    type: Number
                },
                name: {
                    type: String
                },
                email: {
                    type: String
                }
            },
            lang: {
                type: Object
            },
            store_route: {
                type: String
            },
            edit_route: {
                type: String,
                default: ''
            },
            departament: {
                type: Object | null,
                default: null
            }
        },
        data() {
            return {
                form: {
                    name: '',
                    description: '',
                    file: null,
                    usersList: []
                }
            }
        },
        methods: {
            save() {
                let data = new FormData();
                data.append('name', this.form.name);
                data.append('description', this.form.description);
                data.append('file', this.form.file);
                data.append('users', this.form.usersList);
                if (this.departament !== null) {
                    data.append("_method", "put");
                    axios.post(this.edit_route, data, {'content-type': 'multipart/form-data'}).then((response) => {
                        alert(response.data.message);
                    });
                } else {
                    axios.post(this.store_route, data, {'content-type': 'multipart/form-data'}).then((response) => {
                        alert(response.data);
                    });
                }
            },
            selectFile(e) {
                this.form.file = e.target.files[0];
            }
        },
        mounted() {
            if (this.departament !== null) {
                this.form.name = this.departament.name;
                this.form.description = this.departament.description;
                this.form.usersList = [];
                let result = [];
                this.users.forEach((user) => {
                    this.departament.users.forEach((userDepartment) => {
                        delete userDepartment['pivot'];
                        if (JSON.stringify(user) === JSON.stringify(userDepartment)) {
                            result[user.id] = "true";
                        }
                    });
                });
                this.form.usersList = result;
            }
        }
    }
</script>

<style scoped lang="scss">
    .preview {
        height: 200px;
    }
</style>
