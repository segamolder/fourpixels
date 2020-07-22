<template>
    <div :id="'department-'+department.id" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-sm-12 col-md-2"><img class="image" :src="image_path+department.logo" alt=""></div>
            <div class="col-sm-12 col-md-4 d-flex flex-column">
                <b>{{department.name}}</b>
                {{department.description}}
            </div>
            <div class="col-sm-12 col-md-3">
                <span v-if="Object.keys(department.users).length != 0"><b>Users</b></span>
                <ol>
                    <li v-for="user in department.users">{{user.name}}</li>
                </ol>
            </div>
            <div class="col-sm-12 col-md-3">
                <a :href="edit_route"
                    class="btn btn-secondary">
                    {{ edit_button }}
                </a>
                <span
                    @click="deleteDepartment"
                    class="btn btn-danger">
                    {{ delete_button }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "department-item",
        props: {
            department: {
                name: {
                    type: String
                },
                description: {
                    type: String
                },
                logo: {
                    type: String
                },
            },
            image_path: {
                type: String,
                default: ''
            },
            edit_button: {
                type: String,
                default: 'Edit'
            },
            edit_route: {
                type: String,
            },
            delete_button: {
                type: String,
                default: 'Delete'
            },
            delete_route: {
                type: String
            }
        },
        data() {
            return {}
        },
        methods: {
            deleteDepartment() {
                axios.delete(this.delete_route).then((response) => {
                    $('#department-' + this.department.id).remove();
                    alert(response.data);
                });
            }
        }
    }
</script>
<style scoped lang="scss">
    .image {
        height: 100px;
    }
</style>
